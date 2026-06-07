<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OwnerSignatureController extends Controller
{
    public function edit()
    {
        return view('frontend.owner.signature-settings', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'signature_image' => 'required|image|max:4096',
        ]);

        $user = Auth::user();
        if ($user->signature_path && Storage::exists('public/'.$user->signature_path)) {
            Storage::delete('public/'.$user->signature_path);
        }

        $path = $request->file('signature_image')->store('public/signatures/users');
        $user->signature_path = str_replace('public/', '', $path);
        $user->save();

        return redirect()->back()->with('success', 'Your signature has been saved. It will be offered when signing listing agreements.');
    }
}
