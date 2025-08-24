<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Exception;

class RegistrationOwner3 extends Controller 
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'Email' => 'required|email|unique:owners,Email',
            'password' => 'required|min:6',
            'phonen' => 'required|string',
        ]);
        
        // Ensure all required session data exists
        if (!Session::has('fullName') || !Session::has('dob') || !Session::has('gender') ||
            !Session::has('resturantName') || !Session::has('State') || !Session::has('location') || !Session::has('type')) {
            return redirect()->back()->with('error', 'Missing registration information. Please complete all previous steps.');
        }

        // Retrieve session data
        $fullName = Session::get('fullName');
        $dob = Session::get('dob');
        $gender = Session::get('gender');
        $resturantName = Session::get('resturantName');
        $State = Session::get('State');
        $location = Session::get('location');
        $type = Session::get('type');

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Insert the user into the "owners" table
            $ownerId = DB::table('owners')->insertGetId([
                'fullName' => $fullName,
                'dob' => $dob,
                'gender' => $gender,
                'Email' => $validated['Email'],
                'password' => Hash::make($validated['password']),
                'phonen' => $validated['phonen'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

         
           // Insert the restaurant linked to this owner
           DB::table('restaurants')->insert([
            'owner_id' => $ownerId,
            'resturantName' => $resturantName,
            'State' => $State,
            'location' => $location,
            'type' => $type,
            'urlimage' => 'default.jpg', // Add a default image path here
        ]);

            // Commit the transaction if everything is successful
            DB::commit();

            // Clear session data and set owner_id
            Session::forget(['fullName', 'dob', 'gender', 'resturantName', 'State', 'location', 'type']);
            Session::put('owner_id', $ownerId);

            return redirect()->route('registration.done');            
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            DB::rollback();
            return redirect()->back()->with('error', 'Registration error: ' . $e->getMessage());
        }
    }
}