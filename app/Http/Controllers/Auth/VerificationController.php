<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    // Verificar el correo del usuario
    public function verify(Request $request, $id, $hash)
    {
        // Obtener el usuario por ID
        $user = User::findOrFail($id);

        // Verificar que el hash concuerde con el email del usuario
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link'], 400);
        }

        // Verificar si ya está verificado
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 400);
        }

        // Marcar el correo como verificado
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->noContent();
    }

    // Reenviar el correo de verificación
    public function resend(Request $request)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link sent']);
    }
}
