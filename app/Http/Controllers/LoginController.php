<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Owner;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('log-in-owner');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => ['required'],
            'password' => ['required'],
        ]);

        // Check whether identifier is an email or phone
        $fieldType = filter_var($request->identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // Attempt login with dynamic field
        if (Auth::attempt([$fieldType => $request->identifier, 'password' => $request->password])) {
            $request->session()->regenerate();

            $owner = Auth::user();
            $restaurant = $owner->restaurant;

            if ($restaurant) {
                return redirect()->route('owner.profile', ['id' => $restaurant->id]);
            }

            return redirect('/home');
        }

        return back()->withErrors([
            'identifier' => 'Invalid credentials.',
        ])->onlyInput('identifier');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/log-in-owner');
    }
}
