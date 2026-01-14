<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = $request->user();

        // Check if email is verified
        if (!$user->hasVerifiedEmail()) {
            // Don't logout - keep user logged in but redirect to verification notice
            // This allows them to resend verification email while authenticated
            
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Please verify your email address. We have sent you a verification link.',
                    'verified' => false,
                    'redirect' => route('verification.notice'),
                    'resend_url' => route('verification.send')
                ], 200); // Changed to 200 so AJAX doesn't treat it as error
            }

            return redirect()->route('verification.notice')
                ->with('status', 'verification-link-sent')
                ->with('message', 'Please verify your email address before accessing the system.');
        }

        // Email is verified - proceed with redirect based on user role
        // Check if user is admin (role == 1) - redirect to admin dashboard
        if ($user->role == 1) {
            $adminRedirectUrl = route('dashboard');
            
            return $request->wantsJson()
                        ? response()->json([
                            'redirect' => $adminRedirectUrl,
                            'verified' => true
                        ])
                        : redirect($adminRedirectUrl);
        }
        
        // Regular users - check if there's a redirect_after_login parameter (from booking modal)
        $redirectUrl = $request->input('redirect_after_login');
        if (!$redirectUrl) {
            $redirectUrl = $request->session()->get('url.intended', route('home'));
        }
        
        return $request->wantsJson()
                    ? response()->json([
                        'redirect' => $redirectUrl,
                        'verified' => true
                    ])
                    : redirect($redirectUrl);
    }
}

