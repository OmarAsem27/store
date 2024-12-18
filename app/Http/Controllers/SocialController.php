<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function index($provider)
    {
        $user = Auth::user();

        $providerUser = Socialite::driver($provider)->userFromToken($user->provider_token);

        dd($providerUser);
    }
}
