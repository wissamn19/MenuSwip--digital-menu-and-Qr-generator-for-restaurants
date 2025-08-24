<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordHandler extends Controller
{
    public function reset(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed', // You can add password confirmation check if needed
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }

        $token = $request->input('token');
        $newPassword = $request->input('password');

        // Check if the token is valid and not expired
        $user = DB::table('users')
            ->where('reset_token', $token)
            ->where('reset_token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired token'], 400);
        }
        

        // Update the user's password and clear the reset token
        DB::table('users')
            ->where('Email', $user->Email)
            ->update([
                'password' => Hash::make($newPassword),
                'reset_token' => null,
                'reset_token_expires_at' => null,
            ]);

            
        return response()->json([
            'success' => true,
            'message' => 'Password successfully reset! You can now log in.',
        ]);
    }


}