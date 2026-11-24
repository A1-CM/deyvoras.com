<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->scopes(['openid', 'email', 'profile'])->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email = strtolower(trim((string) $googleUser->getEmail()));

            if ($email === '' || ! ($googleUser->user['verified_email'] ?? false)) {
                return redirect()->route('login')->withErrors([
                    'google' => 'Google sign-in requires a verified email address.',
                ]);
            }

            $user = User::where('email', $email)->first();

            if (! $user) {
                $name = trim((string) $googleUser->getName()) ?: Str::before($email, '@');
                $organization = Organization::create(['name' => Str::limit($name."'s Workspace", 160, '')]);
                $user = User::create([
                    'organization_id' => $organization->id,
                    'role' => 'owner',
                    'name' => $name,
                    'email' => $email,
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(64)),
                ]);
            }

            Auth::login($user);
            request()->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('login')->withErrors([
                'google' => 'Google sign-in could not be completed. Please try again.',
            ]);
        }
    }
}
