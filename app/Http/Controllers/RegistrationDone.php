<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegistrationDone extends Controller
{
    public function storeSession(Request $request)
    {
        // Assuming these values are coming from the request or from some logic
        $owner_id = $request->input('owner_id');
        $restaurant_id = $request->input('restaurant_id');

        // Store user and restaurant ID in the session
        Session::put('owner_id', $owner_id);
        Session::put('restaurant_id', $restaurant_id);

        return response()->json([
            'success' => true,
            'message' => 'Session data stored successfully!',
            'session_data' => [
                'owner_id' => Session::get('owner_id'),
                'restaurant_id' => Session::get('restaurant_id'),
            ]
        ]);
    }
}
