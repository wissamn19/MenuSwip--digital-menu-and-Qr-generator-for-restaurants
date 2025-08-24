<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LogInOwner extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
{
    return view('log-in-owner');
}

    /**
     * Handle a login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $identifier = trim($validated['identifier']);
        $password = $validated['password'];
        
        // Query the database for the owner based on email or phone number
        $owner = DB::table('owners')
            ->where('Email', $identifier)
            ->orWhere('phonen', $identifier)
            ->first();
        
        if ($owner && Hash::check($password, $owner->password)) {
            // Set session data
            session([
                'id' => $owner->id,
                'fullName' => $owner->fullName,
                'owner_id' => $owner->id,
            ]);
            
            // Redirect to the owner profile page
            return redirect()->route('owner.profile', ['id' => $owner->id])

                ->with('success', 'You have successfully logged in!');
        }
        
        // If authentication fails
        return back()
            ->withInput($request->only('identifier'))
            ->with('error', 'Invalid email/phone number or password');
    }

    /**
     * Log the owner out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Session::flush();
        
        return redirect()->route('owner.login')
            ->with('success', 'You have been successfully logged out!');
    }
}