<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegistrationOwner2 extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'resturantName' => 'required|string|max:255',
            'State' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        // Store the form data in the session
        Session::put('resturantName', $validated['resturantName']);
        Session::put('State', $validated['State']);
        Session::put('location', $validated['location']);
        Session::put('type', $validated['type']);

        // Redirect to the next page
        return redirect()->route('registration-owner-3');
    }
}

