<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyChooseUsItem;
use App\Models\Setting;
use Illuminate\Http\Request;

class WhyChooseUsItemController extends Controller
{
    public function index()
    {
        if (! WhyChooseUsItem::tableReady()) {
            return redirect()->route('dashboard')
                ->with('error', 'The Why Choose Us table is missing. Run: php artisan migrate');
        }

        $items = WhyChooseUsItem::ordered()->get();
        $setting = Setting::first();

        return view('admin.whyChooseUs.index', compact('items', 'setting'));
    }

    public function store(Request $request)
    {
        if (! WhyChooseUsItem::tableReady()) {
            return redirect()->back()
                ->with('error', 'The Why Choose Us table is missing. Run: php artisan migrate');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:32',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        WhyChooseUsItem::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'icon' => $validated['icon'] ?? '★',
            'sort_order' => $validated['sort_order'] ?? (WhyChooseUsItem::max('sort_order') + 1),
            'is_active' => true,
        ]);

        cache()->forget('home_why_choose_us');

        return redirect()->route('admin.why-choose-us.index')->with('success', 'Item added successfully.');
    }

    public function update(Request $request, $id)
    {
        if (! WhyChooseUsItem::tableReady()) {
            return redirect()->back()
                ->with('error', 'The Why Choose Us table is missing. Run: php artisan migrate');
        }

        $item = WhyChooseUsItem::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:32',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $item->fill([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'icon' => $validated['icon'] ?? '★',
            'sort_order' => $validated['sort_order'] ?? $item->sort_order,
            'is_active' => $request->boolean('is_active'),
        ]);
        $item->save();

        cache()->forget('home_why_choose_us');

        return redirect()->route('admin.why-choose-us.index')->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        if (! WhyChooseUsItem::tableReady()) {
            return redirect()->back()
                ->with('error', 'The Why Choose Us table is missing. Run: php artisan migrate');
        }

        WhyChooseUsItem::findOrFail($id)->delete();
        cache()->forget('home_why_choose_us');

        return redirect()->route('admin.why-choose-us.index')->with('success', 'Item removed.');
    }
}
