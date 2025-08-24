<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\Owner;



use App\Mail\PasswordResetMail;   

class ForgetPassword extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'Email' => 'required|email'
        ]);
    
        $email = $request->input('Email');
    
        $owner = DB::table('owners')->where('Email', $email)->first();
    
        if (!$owner) {
            return back()->withErrors(['Email' => 'Email not found.']);
        }
    
        $token = Str::random(64);
        $expiresAt = Carbon::now()->addHours(24);
    
        DB::table('owners')
            ->where('Email', $email)
            ->update([
                'reset_token' => $token,
                'reset_token_expires_at' => $expiresAt
            ]);
    
        $resetLink = url("/reset_password?token=$token");
    
        // Envoi de l'email
        Mail::to($email)->send(new PasswordResetMail($resetLink));
    
        session()->flash('link', $resetLink);
session()->flash('status', 'Password reset link has been sent to your email address.');
return redirect()->back();

        
        
    }
    
    public function showResetLink(Request $request)
{
    $email = $request->input('email');

    // Exemple : vÃ©rifier dans la table des utilisateurs
    $owner = Owner::where('email', $email)->first(); // avec "O" majuscule


    if ($owner) {
        $link = url('/reset-password/' . base64_encode($email)); // Lien fictif
        return view('forget_password', ['link' => $link, 'status' => 'email_found']);
    } else {
        return view('forget_password', ['status' => 'email_not_found']);
    }
}

}
