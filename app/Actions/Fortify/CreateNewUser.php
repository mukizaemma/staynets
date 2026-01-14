<?php

namespace App\Actions\Fortify;

use Ramsey\Uuid\Uuid;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Mail\AdminNotification;


class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'userName' => $input['email'],
            'role' => 0,
            'user_id' => Uuid::uuid4(),
            'password' => Hash::make($input['password']),
        ]);

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        // Notify all admins (role = 1) that a new user account has been created
        $admins = User::where('role', 1)->get();
        if ($admins->isNotEmpty()) {
            $details = [
                'subject'  => 'New user registered on Accommodation Booking Engine',
                'greeting' => 'Hello Admin,',
                'body'     => "A new user account has been created.\n\nName: {$user->name}\nEmail: {$user->email}",
                'lastline' => 'Please log in to the admin dashboard to review this user if needed.',
            ];

            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new AdminNotification($details));
            }
        }

        return $user;
    }
}
