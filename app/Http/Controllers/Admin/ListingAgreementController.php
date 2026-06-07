<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\ListingAgreementSignature;
use App\Models\ListingAgreementTemplate;
use App\Models\Property;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ListingAgreementController extends Controller
{
    public function index()
    {
        $template = ListingAgreementTemplate::query()->first();

        $signatures = ListingAgreementSignature::query()
            ->whereIn('status', [
                ListingAgreementSignature::STATUS_PENDING,
                ListingAgreementSignature::STATUS_SIGNED,
            ])
            ->with([
                'signable' => function (MorphTo $morphTo) {
                    $morphTo->morphWith([
                        Hotel::class => ['owner'],
                        Property::class => ['owner'],
                    ]);
                },
            ])
            ->orderByDesc('updated_at')
            ->paginate(30)
            ->withQueryString();

        $setting = Setting::first();

        return view('admin.listing-agreement.index', [
            'signatures' => $signatures,
            'template' => $template,
            'setting' => $setting,
        ]);
    }

    public function showSigned(ListingAgreementSignature $signature)
    {
        $signature->load([
            'signable' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    Hotel::class => ['owner'],
                    Property::class => ['owner'],
                ]);
            },
        ]);

        $template = ListingAgreementTemplate::current();
        if (empty($template->sections)) {
            $template->update(['sections' => ListingAgreementTemplate::defaultSections()]);
            $template->refresh();
        }

        $listing = $signature->signable;
        $owner = $listing ? ($listing->owner ?? null) : null;
        $listingName = $listing ? ($listing->name ?? '—') : '(listing removed)';
        $typeLabel = class_basename($signature->signable_type);
        $matchesTemplate = $template ? $signature->isCurrentForTemplate($template) : false;
        $setting = Setting::first();

        return view('admin.listing-agreement.signed-show', [
            'signature' => $signature,
            'template' => $template,
            'listing' => $listing,
            'owner' => $owner,
            'listingName' => $listingName,
            'typeLabel' => $typeLabel,
            'matchesTemplate' => $matchesTemplate,
            'setting' => $setting,
        ]);
    }

    public function approve(Request $request, ListingAgreementSignature $signature)
    {
        $validated = $request->validate([
            'admin_signature' => 'nullable|image|max:4096',
            'admin_notes' => 'nullable|string|max:2000',
            'use_template_signature' => 'nullable|boolean',
        ]);

        $template = ListingAgreementTemplate::current();

        if (! $signature->owner_signature_path) {
            return redirect()->back()->with('error', 'The host has not submitted a signature yet.');
        }

        $adminSigPath = $signature->admin_signature_path;

        if ($request->hasFile('admin_signature')) {
            if ($adminSigPath && Storage::exists('public/'.$adminSigPath)) {
                Storage::delete('public/'.$adminSigPath);
            }
            $path = $request->file('admin_signature')->store('public/listing-agreements/platform');
            $adminSigPath = str_replace('public/', '', $path);
        } elseif ($request->boolean('use_template_signature') && $template->platform_signature_path) {
            $adminSigPath = $template->platform_signature_path;
        } elseif (! $adminSigPath && $template->platform_signature_path) {
            $adminSigPath = $template->platform_signature_path;
        }

        if (! $adminSigPath) {
            return redirect()->back()->with('error', 'Upload a platform signature or set one on the agreement template first.');
        }

        $signature->update([
            'status' => ListingAgreementSignature::STATUS_SIGNED,
            'admin_signature_path' => $adminSigPath,
            'admin_approved_at' => now(),
            'admin_approved_by' => Auth::id(),
            'admin_notes' => $validated['admin_notes'] ?? null,
            'signed_at' => $signature->signed_at ?? now(),
            'template_version_at' => $template->fresh()->updated_at,
        ]);

        return redirect()->route('admin.listing-agreement.signed.show', $signature)
            ->with('success', 'Agreement approved and marked as signed.');
    }

    public function edit()
    {
        $template = ListingAgreementTemplate::current();
        if (empty($template->sections)) {
            $template->update(['sections' => ListingAgreementTemplate::defaultSections()]);
            $template->refresh();
        }
        $setting = Setting::first();

        return view('admin.listing-agreement.edit', [
            'template' => $template,
            'setting' => $setting,
        ]);
    }

    public function update(Request $request)
    {
        $template = ListingAgreementTemplate::current();

        $validated = $request->validate([
            'platform_name' => 'required|string|max:255',
            'platform_email' => 'nullable|string|max:255',
            'platform_website' => 'nullable|string|max:255',
            'platform_phone' => 'nullable|string|max:255',
            'platform_tagline' => 'nullable|string|max:500',
            'platform_representative_name' => 'nullable|string|max:255',
            'intro_text' => 'nullable|string|max:65000',
            'damage_report_hours' => 'nullable|integer|min:1|max:720',
            'termination_notice_days' => 'nullable|integer|min:1|max:365',
            'commission_rate' => 'nullable|string|max:50',
            'payment_method' => 'nullable|string|max:255',
            'payment_timeline' => 'nullable|string|max:255',
            'footer_services_text' => 'nullable|string|max:500',
            'platform_signature' => 'nullable|image|max:4096',
            'sections' => 'nullable|array',
            'sections.*.heading' => 'nullable|string|max:500',
            'sections.*.items_text' => 'nullable|string|max:10000',
        ]);

        $sections = [];
        foreach ($request->input('sections', []) as $block) {
            if (empty($block['heading']) || ! is_string($block['heading'])) {
                continue;
            }
            $lines = preg_split('/\r\n|\r|\n/', (string) ($block['items_text'] ?? ''));
            $items = array_values(array_filter(array_map('trim', $lines), static function ($line) {
                return $line !== '';
            }));
            $sections[] = [
                'heading' => trim($block['heading']),
                'items' => $items,
            ];
        }

        $payload = [
            'platform_name' => $validated['platform_name'],
            'platform_email' => $validated['platform_email'] ?? null,
            'platform_website' => $validated['platform_website'] ?? null,
            'platform_phone' => $validated['platform_phone'] ?? null,
            'platform_tagline' => $validated['platform_tagline'] ?? null,
            'platform_representative_name' => $validated['platform_representative_name'] ?? null,
            'intro_text' => $validated['intro_text'] ?? null,
            'damage_report_hours' => $validated['damage_report_hours'] ?? 24,
            'termination_notice_days' => $validated['termination_notice_days'] ?? 30,
            'commission_rate' => $validated['commission_rate'] ?? '5%',
            'payment_method' => $validated['payment_method'] ?? null,
            'payment_timeline' => $validated['payment_timeline'] ?? null,
            'footer_services_text' => $validated['footer_services_text'] ?? null,
            'sections' => $sections ?: ListingAgreementTemplate::defaultSections(),
        ];

        if ($request->hasFile('platform_signature')) {
            if ($template->platform_signature_path && Storage::exists('public/'.$template->platform_signature_path)) {
                Storage::delete('public/'.$template->platform_signature_path);
            }
            $path = $request->file('platform_signature')->store('public/listing-agreements/platform');
            $payload['platform_signature_path'] = str_replace('public/', '', $path);
        }

        $template->update($payload);

        return redirect()->route('admin.listing-agreement.index')
            ->with('success', 'Listing agreement template updated.');
    }
}
