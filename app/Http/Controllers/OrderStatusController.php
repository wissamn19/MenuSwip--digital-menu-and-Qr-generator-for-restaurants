<?php

namespace App\Http\Controllers;

use App\Models\OrderOn;
use App\Models\OrderOff;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderStatusController extends Controller
{
    /**
     * Turn on orders for a restaurant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function turnOn(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        $restaurant = Restaurant::findOrFail($request->restaurant_id);
        
        // Check if user is authorized to manage this restaurant
        if ($restaurant->owner_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Create a new OrderOn record
        OrderOn::create([
            'order_id' => null, // No specific order associated
            'owner_id' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Orders are now enabled',
            'status' => true
        ]);
    }

    /**
     * Turn off orders for a restaurant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function turnOff(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        $restaurant = Restaurant::findOrFail($request->restaurant_id);
        
        // Check if user is authorized to manage this restaurant
        if ($restaurant->owner_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Create a new OrderOff record
        OrderOff::create([
            'order_id' => null, // No specific order associated
            'chef_id' => Auth::id(), // Using chef_id as per model
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Orders are now disabled',
            'status' => false
        ]);
    }

    /**
     * Check the current order status for a restaurant.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkStatus($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $isAccepting = $restaurant->isAcceptingOrders();

        return response()->json([
            'status' => $isAccepting,
            'message' => $isAccepting ? 'Orders are enabled' : 'Orders are disabled'
        ]);
    }
}

