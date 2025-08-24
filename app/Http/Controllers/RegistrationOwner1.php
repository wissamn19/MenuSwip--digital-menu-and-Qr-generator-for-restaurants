<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class RegistrationOwner1 extends Controller 
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'fullName' => 'required|string|max:255',
            'Year' => 'required|integer|digits:4',
            'Month' => 'required|integer|between:1,12',
            'date' => 'required|integer|between:1,31',
            'gender' => 'nullable|string|in:Male,Female,Not specified',
        ]);

        // Store the form data in the session
        Session::put('fullName', $request->input('fullName'));
        Session::put('dob', $request->input('Year') . '-' . $request->input('Month') . '-' . $request->input('date'));
        Session::put('gender', $request->input('gender', 'Not specified'));

        // Redirect to the next page
        return redirect()->route('registration-owner-2');
    }
}
