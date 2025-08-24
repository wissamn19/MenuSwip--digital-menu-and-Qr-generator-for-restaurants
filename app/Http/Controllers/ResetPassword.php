<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class ResetPassword extends Controller
{
    public function verifyToken(Request $request)
    {
        // Validate token parameter in the URL
        $request->validate([
            'token' => 'required|string',
        ]);

        $token = trim($request->input('token'));

        // Debugging: Log the received token (remove in production)
        Log::debug("Token reçu : $token");

        // Query the database to find the user with the matching token and check its expiration
        $owner = DB::table('owners')
            ->where('reset_token', '=', $token)
            ->where('reset_token_expires_at', '>', now())  // Ensure the token is not expired
            ->first();

        // If no user is found, the token is either invalid or expired
        if (!$owner) {
            return response()->json([
                'success' => false,
                'message' => ' Aucun compte ne correspond à ce token ou le token a expiré !'
            ], 400);
        }

        // Token is valid, return success response with the user's email
        return response()->json([
            'success' => true,
            'message' => " Token valide pour : " . $owner->Email,
            'email' => $owner->Email
        ]);
    }
    public function showResetForm(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect()->route('forgot.password.form')
                ->withErrors(['token' => 'Le lien est invalide ou manquant.']);
        }

        $owner = DB::table('owners')
            ->where('reset_token', $token)
            ->where('reset_token_expires_at', '>', now())
            ->first();

        if (!$owner) {
            return redirect()->route('forgot.password.form')
                ->withErrors(['token' => 'Le token est invalide ou expiré.']);
        }

        return view('reset_password', ['token' => $token, 'email' => $owner->Email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        $owner = DB::table('owners')
            ->where('Email', $request->email)
            ->where('reset_token', $request->token)
            ->where('reset_token_expires_at', '>', now())
            ->first();

        if (!$owner) {
            return back()->withErrors(['email' => 'Email ou token invalide.']);
        }

        DB::table('owners')
            ->where('Email', $request->email)
            ->update([
                'Password' => password_hash($request->password, PASSWORD_DEFAULT),
                'reset_token' => null,
                'reset_token_expires_at' => null
            ]);

        return redirect()->route('owner.login')->with('status', 'Mot de passe réinitialisé avec succès.');

        
    }

}