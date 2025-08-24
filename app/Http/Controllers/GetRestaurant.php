<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class GetRestaurant extends Controller
{
    public function getRestaurant(Request $request)
    {
        // Check if user is authenticated via session
        $user_id = session('user_id');

        if (!$user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Session not set',
                'debug' => session()->all()
            ], 400);
        }

        // Fetch restaurant for authenticated user
        $restaurant = DB::table('restaurants')
            ->where('user_id', $user_id)
            ->first();

        if ($restaurant) {
            return response()->json([
                'success' => true,
                'data' => $restaurant
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Restaurant not found'
            ], 404);
        }
    }
}

