<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        if (config('services.google.hd')) {
            return Socialite::driver('google')
                ->with(['hd' => config('services.google.hd')])
                ->redirect();
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', __('Google authentication failed.'));
        }

        $user = User::updateOrCreate([
            'google_id' => $googleUser->id,
        ], [
            'name' => strstr($googleUser->getEmail(), '@', true),
            'email' => $googleUser->email,
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
            'profile_picture' => $googleUser->avatar,

        ]);

        Auth::login($user);

        return redirect(route('home'));
    }
}
