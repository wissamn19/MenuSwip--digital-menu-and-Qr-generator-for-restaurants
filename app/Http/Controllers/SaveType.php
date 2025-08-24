<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SaveType extends Controller
{
    public function store(Request $request)
    {
        // Check if the 'type' field is present in the POST request
        if ($request->has('type')) {
            // Sanitize and store the 'type' in the session
            $type = trim(htmlspecialchars($request->input('type'))); // Secure the input
            session(['type' => $type]);

            // Return success message
            return response()->json(['message' => "Type enregistré : " . $type], 200);
        }

        // Return error message if 'type' is not received
        return response()->json(['message' => 'Erreur : Type non reçu.'], 400);
    }
}

