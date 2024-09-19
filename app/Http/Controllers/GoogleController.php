<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function handleRedirect(Request $request) {
        return Socialite::driver()->redirect();
    } 

    public function handleCallback(Request $request) {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
            ]);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return redirect('baseup://google-callback?token'. $token);
    } 
}
