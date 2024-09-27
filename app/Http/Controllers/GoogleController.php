<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function handleRedirect(Request $request) {
        return Socialite::driver('google')->stateless()->redirect();
    } 

    public function handleCallback(Request $request) {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
            ]);
        }

        $token = $user->createToken('BaseupAPI')->accessToken;

        return redirect()->away('baseup://google-callback?token'. $token);
    } 
}
