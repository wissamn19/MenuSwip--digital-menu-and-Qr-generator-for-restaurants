<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GeoCode extends Controller
{
    public function getCoordinates(Request $request)
    {
        $restaurant_id = $request->query('id');

        if (!is_numeric($restaurant_id)) {
            return response()->json(['success' => false, 'message' => 'Invalid restaurant ID']);
        }

        $restaurant = DB::table('restaurants')
            ->select('user_id', 'location', 'State')
            ->where('id', $restaurant_id)
            ->first();

        if (!$restaurant) {
            return response()->json(['success' => false, 'message' => 'Restaurant not found']);
        }

        if (empty($restaurant->location) || empty($restaurant->State)) {
            return response()->json(['success' => false, 'message' => 'Restaurant location data is incomplete']);
        }
        $api_key = env('GOOGLE_MAPS_KEY');

        $address = urlencode($restaurant->location . ', ' . $restaurant->State . ', Algeria');

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$api_key}";

        try {
            $response = Http::get($url);

            if (!$response->ok()) {
                return response()->json(['success' => false, 'message' => 'Failed to connect to Google Maps API']);
            }

            $data = $response->json();

            if ($data['status'] !== 'OK' || empty($data['results'])) {
                return response()->json(['success' => false, 'message' => 'Invalid address or no results found']);
            }

            $location = $data['results'][0]['geometry']['location'];

            return response()->json([
                'success' => true,
                'data' => [
                    'lat' => $location['lat'],
                    'lng' => $location['lng'],
                    'formatted_address' => $data['results'][0]['formatted_address']
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
