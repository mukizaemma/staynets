<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

/**
 * Legacy controller kept for backward compatibility with older admin routes.
 * Left Bags page content is managed via SettingsController (getLeftBags/updateBags).
 */
class BagsController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('getLeftBags');
    }

    public function store(Request $request): RedirectResponse
    {
        // Legacy endpoint: send admins to the canonical Left Bags settings page.
        return redirect()->route('getLeftBags');
    }

    public function edit($id): RedirectResponse
    {
        return redirect()->route('getLeftBags');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        return redirect()->route('getLeftBags');
    }
    


    public function destroy($id): RedirectResponse
    {
        return redirect()->route('getLeftBags');
    }
}
