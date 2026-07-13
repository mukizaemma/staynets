<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ListingAgreementTemplate extends Model
{
    protected $fillable = [
        'platform_name',
        'platform_email',
        'platform_website',
        'platform_phone',
        'platform_tagline',
        'platform_representative_name',
        'platform_signature_path',
        'intro_text',
        'damage_report_hours',
        'termination_notice_days',
        'commission_rate',
        'payment_method',
        'payment_timeline',
        'footer_services_text',
        'page_break_after',
        'sections',
    ];

    protected $casts = [
        'sections' => 'array',
        'damage_report_hours' => 'integer',
        'termination_notice_days' => 'integer',
        'page_break_after' => 'integer',
    ];

    public static function current(): self
    {
        $row = static::query()->first();
        if ($row) {
            $existing = is_array($row->sections) ? $row->sections : [];
            $existingKeys = [];
            foreach ($existing as $block) {
                if (is_array($block)) {
                    $key = self::normalizeHeadingKey($block['heading'] ?? '');
                    if ($key !== '') {
                        $existingKeys[] = $key;
                    }
                }
            }

            $defaultKeys = array_map(
                static fn ($s) => self::normalizeHeadingKey($s['heading'] ?? ''),
                self::defaultSections()
            );
            $missing = array_values(array_diff($defaultKeys, $existingKeys));

            $dirty = [];
            if ($existing === [] || $missing !== []) {
                $dirty['sections'] = self::ensureCompleteSections($existing);
            }
            if (blank($row->intro_text)) {
                $dirty['intro_text'] = self::defaultIntro();
            }
            if ($row->page_break_after === null && Schema::hasColumn($row->getTable(), 'page_break_after')) {
                $dirty['page_break_after'] = 6;
            }
            if ($dirty !== []) {
                $row->update($dirty);
                $row->refresh();
            }

            return $row;
        }

        return static::query()->create([
            'platform_name' => 'Stay Nets',
            'platform_email' => 'staynets2@gmail.com',
            'platform_website' => 'www.staynets.com',
            'platform_phone' => '+250784251094/250788788633',
            'platform_tagline' => 'Stay Nets - One Platform, Endless Destinations.',
            'platform_representative_name' => 'Joseph K',
            'platform_signature_path' => null,
            'intro_text' => self::defaultIntro(),
            'damage_report_hours' => 24,
            'termination_notice_days' => 30,
            'commission_rate' => 'up to 10%',
            'payment_method' => 'Bank transfer / Mobile Money / Card',
            'payment_timeline' => 'Within 7–14 days after guest checkout',
            'footer_services_text' => 'Booking Engine: Hotel, Apartment, Villa House, Tour Package and Car Rental.',
            'page_break_after' => 6,
            'sections' => self::renumberSections(self::defaultSections()),
        ]);
    }

    public static function defaultIntro(): string
    {
        return "This Agreement is made between:\n\n"
            . "1. Stay Nets Owner: [REPRESENTATIVE]\n"
            . "   Stay Nets operating an online booking platform\n\n"
            . "AND\n\n"
            . "2. Property Owner / Host:\n"
            . "   [HOST NAME] (“Host”)";
    }

    /**
     * @return array<int, array{heading: string, lead_in?: string, items: array<int, string>, closing?: string, type?: string}>
     */
    public static function defaultSections(): array
    {
        return [
            [
                'heading' => 'PURPOSE',
                'items' => [
                    'The Host agrees to list their property on the Platform, and the Platform agrees to market and facilitate bookings for the Host.',
                ],
            ],
            [
                'heading' => 'PROPERTY DETAILS',
                'items' => [
                    'Property Name: [PROPERTY NAME]',
                    'Location: [LOCATION]',
                    'Type (Apartment / Hotel / Villa): [TYPE]',
                ],
            ],
            [
                'heading' => 'PLATFORM SERVICES',
                'lead_in' => 'Stay Nets will:',
                'items' => [
                    'Display the property listing to users',
                    'Process reservations',
                    'Provide customer support tools',
                    'Promote the property online',
                ],
            ],
            [
                'heading' => 'COMMISSION & PAYMENTS',
                'items' => [
                    'Commission Rate: [COMMISSION] per booking',
                    'Payment Method: [PAYMENT METHOD]',
                    'Payment Timeline: [PAYMENT TIMELINE]',
                ],
                'closing' => 'Commission is a standard part of such agreements',
            ],
            [
                'heading' => 'HOST RESPONSIBILITIES',
                'lead_in' => 'The Host agrees to:',
                'items' => [
                    'Provide accurate property information',
                    'Maintain availability and pricing',
                    'Deliver the service booked by guests',
                    'Handle guest complaints related to the property',
                ],
            ],
            [
                'heading' => 'BOOKINGS & CONTRACT',
                'items' => [
                    'A booking becomes valid once confirmed and paid',
                    'The agreement for stay is between Host and Guest',
                    'The Platform acts only as an intermediary but when list a property and booking pass to Stay Nets and Stay Nets book to the Hotel. This is common in booking systems',
                ],
            ],
            [
                'heading' => 'CANCELLATION POLICY',
                'lead_in' => 'The Host must define:',
                'items' => [
                    'Free cancellation period (if any)',
                    'Refund conditions',
                    'No-show policy',
                ],
            ],
            [
                'heading' => 'DAMAGE & LIABILITY',
                'items' => [
                    'Guests are responsible for damages',
                    'Host must report damages within [X] hours',
                    'Platform is not liable for property damage or guest behavior',
                ],
            ],
            [
                'heading' => 'CONTENT & LISTING RIGHTS',
                'lead_in' => 'Host grants Platform the right to use:',
                'items' => [
                    'Photos',
                    'Property descriptions',
                    'Platform may promote listings for marketing',
                ],
            ],
            [
                'heading' => 'TERM & TERMINATION',
                'items' => [
                    'Start Date: [START DATE]',
                    'Either party may terminate with [30 days] notice',
                    'Platform may suspend listing for policy violations',
                ],
            ],
            [
                'heading' => 'LEGAL COMPLIANCE',
                'lead_in' => 'The Host must:',
                'items' => [
                    'Follow local laws and tax regulations',
                    'Ensure the property is legally rentable',
                ],
            ],
            [
                'heading' => 'LIMITATION OF LIABILITY',
                'lead_in' => 'The Platform:',
                'items' => [
                    'Is not responsible for guest behavior',
                    'Does not guarantee bookings',
                    'Is not liable for indirect losses',
                ],
            ],
            [
                'heading' => 'GOVERNING LAW',
                'items' => [
                    'This Agreement shall be governed by the laws of Rwanda',
                ],
            ],
            [
                'heading' => 'SIGNATURES',
                'type' => 'signatures',
                'items' => [
                    'By signing below, the Host confirms they have read and accept this Property Listing Agreement.',
                ],
            ],
        ];
    }

    public static function normalizeHeadingKey(?string $heading): string
    {
        $heading = strtoupper(trim((string) $heading));
        $heading = preg_replace('/^\d+\.\s*/', '', $heading) ?? $heading;

        return trim($heading);
    }

    /**
     * Append any missing default sections and renumber headings 1..N.
     *
     * @param  array<int, mixed>|null  $sections
     * @return array<int, array{heading: string, lead_in?: string, items: array<int, string>, closing?: string, type?: string}>
     */
    public static function ensureCompleteSections(?array $sections): array
    {
        $defaults = self::defaultSections();
        if ($sections === null || $sections === []) {
            return self::renumberSections($defaults);
        }

        $normalized = [];
        foreach ($sections as $block) {
            if (! is_array($block)) {
                continue;
            }
            $heading = trim((string) ($block['heading'] ?? ''));
            if ($heading === '') {
                continue;
            }
            $items = $block['items'] ?? [];
            if (! is_array($items)) {
                $items = preg_split('/\r\n|\r|\n/', (string) $items) ?: [];
            }
            $items = array_values(array_filter(array_map('trim', $items), static fn ($line) => $line !== ''));

            $entry = [
                'heading' => self::normalizeHeadingKey($heading),
                'items' => $items,
            ];
            $leadIn = trim((string) ($block['lead_in'] ?? ''));
            $closing = trim((string) ($block['closing'] ?? ''));
            $type = trim((string) ($block['type'] ?? ''));
            if ($leadIn !== '') {
                $entry['lead_in'] = $leadIn;
            }
            if ($closing !== '') {
                $entry['closing'] = $closing;
            }
            if ($type !== '') {
                $entry['type'] = $type;
            } elseif (self::normalizeHeadingKey($heading) === 'SIGNATURES') {
                $entry['type'] = 'signatures';
            }
            $normalized[] = $entry;
        }

        $existingKeys = array_map(
            static fn ($s) => self::normalizeHeadingKey($s['heading'] ?? ''),
            $normalized
        );

        foreach ($defaults as $def) {
            $key = self::normalizeHeadingKey($def['heading'] ?? '');
            if ($key !== '' && ! in_array($key, $existingKeys, true)) {
                $normalized[] = $def;
                $existingKeys[] = $key;
            }
        }

        return self::renumberSections($normalized);
    }

    /**
     * @param  array<int, array{heading: string, lead_in?: string, items: array<int, string>, closing?: string, type?: string}>  $sections
     * @return array<int, array{heading: string, lead_in?: string, items: array<int, string>, closing?: string, type?: string}>
     */
    public static function renumberSections(array $sections): array
    {
        $out = [];
        $n = 1;
        foreach ($sections as $block) {
            if (! is_array($block)) {
                continue;
            }
            $title = self::normalizeHeadingKey($block['heading'] ?? '');
            if ($title === '') {
                continue;
            }
            $block['heading'] = $n.'. '.$title;
            if (($block['type'] ?? '') === '' && $title === 'SIGNATURES') {
                $block['type'] = 'signatures';
            }
            $out[] = $block;
            $n++;
        }

        return $out;
    }

    public function isSignaturesSection(array $block): bool
    {
        if (($block['type'] ?? '') === 'signatures') {
            return true;
        }

        return str_contains(self::normalizeHeadingKey($block['heading'] ?? ''), 'SIGNATURE');
    }
}
