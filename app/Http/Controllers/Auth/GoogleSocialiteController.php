<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleSocialiteController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Check if user already exists with this google_id
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            Auth::login($user);
            return redirect(route('dashboard', absolute: false));
        }

        // Check if user exists with this email
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            // Update existing user with google_id
            $existingUser->update([
                'google_id' => $googleUser->getId(),
                'google_email' => $googleUser->getEmail(),
            ]);

            Auth::login($existingUser);
            return redirect(route('dashboard', absolute: false));
        }

        // Create new user
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'google_email' => $googleUser->getEmail(),
        ]);

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
