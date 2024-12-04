<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Throwable;

class SocialLoginController extends Controller
{

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        try {
            $providerUser = Socialite::driver($provider)->stateless()->user();
            $user = User::where([
                'provider' => $providerUser->provider,
                'provider_id' => $providerUser->id
            ])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $providerUser->name,
                    'email' => $providerUser->email,
                    'password' => Hash::make(Str::random(8)),
                    'provider' => $provider,
                    'provider_id' => $providerUser->id,
                    'provider_token' => $providerUser->token,
                ]);
                Auth::login($user);
            }
            return redirect()->route('home');
        } catch (Throwable $e) {
            return redirect()->route('login')->withErrors(['email' => $e->getMessage()]);
        }
    }
}
