<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderOn;
use App\Models\Restaurant;
use App\Models\OrderOff;
use App\Models\Owner;
use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PosController extends Controller
{
    /**
     * Display the home page with tables
     */
    public function home($owner_id)
    {
        $owner = Owner::find($owner_id);
        $restaurant = Restaurant::where('owner_id', $owner_id)->first();
    
        if (!$owner || !$restaurant) {
            return view('pos-home')->with([
                'error' => 'No restaurant found for this owner.',
                'owner_id' => $owner_id,
                'restaurant' => null,
                'tablesByFloor' => collect(),
            ]);
        }
    
        try {
            $restaurants = $restaurant;
    
            // generate tables as before...
            $floors = ['Ground Floor', 'First Floor'];
            $tables = [];
    
            foreach ($floors as $floor) {
                for ($i = 1; $i <= 6; $i++) {
                    $tables[] = [
                        'floor' => $floor,
                        'table_number' => $i + (array_search($floor, $floors) * 6),
                        'capacity' => rand(2, 8)
                    ];
                }
            }
    
            $tablesByFloor = collect($tables)->groupBy('floor');
    
            return view('pos-home', [
                'restaurant' => $restaurants,
                'tablesByFloor' => $tablesByFloor,
                'owner_id' => $owner_id
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading restaurant data: ' . $e->getMessage());
            return view('pos-home')->with([
                'error' => 'Error loading restaurant data: ' . $e->getMessage(),
                'restaurant' => null,
                'tablesByFloor' => collect(),
                'owner_id' => $owner_id
            ]);
        }
    }

    /**
     * Display the menu for the specific restaurant
     */
    public function menu(Request $request, $owner_id)
    {
        // Get the owner by ID
        $owner = Owner::find($owner_id);
        $restaurant = Restaurant::where('owner_id', $owner_id)->first();
    
        if (!$owner || !$restaurant) {
            return redirect()->back()->with('error', 'No restaurant found for this owner.');
        }
    
        try {
            // Log the restaurant ID for debugging
            Log::info('Using restaurant ID: ' . $restaurant->id);
    
            // Only fetch items for the specific restaurant
            $menuItems = MenuItem::where('restaurant_id', $restaurant->id)
                                 ->when($request->has('category'), function($query) use ($request) {
                                     return $query->where('category_id', $request->category);
                                 })
                                 ->orderBy('item_name')
                                 ->get();
    
            // Get categories for this restaurant
            $categories = MenuItem::where('restaurant_id', $restaurant->id)
                                  ->select('category_id')
                                  ->distinct()
                                  ->pluck('category_id');
    
            // Get table and guest information from request
            $tableNumber = $request->query('table', null);
            $guestCount = $request->query('guests', null);
    
            // Log for debugging
            Log::info('Menu items retrieved for restaurant #' . $restaurant->id . ': ' . $menuItems->count());
    
            return view('pos-menu', compact(
                'menuItems', 
                'restaurant', 
                'categories', 
                'tableNumber', 
                'guestCount', 
                'owner_id'
            ));
    
        } catch (\Exception $e) {
            Log::error('Error retrieving menu items: ' . $e->getMessage());
            return view('pos-menu')->with('error', 'Error loading menu items: ' . $e->getMessage());
        }
    }

    /**
     * Update a menu item
     */
    public function updateMenuItem(Request $request, $owner_id, $itemId)

    {
         // Log the request for debugging
         Log::info('Update menu item request received', [
            'owner_id' => $owner_id,
            'item_id' => $itemId,
            'request_data' => $request->all()
        ]);

        // Get the owner by ID
        $owner = Owner::find($owner_id);
        $restaurant = Restaurant::where('owner_id', $owner_id)->first();
        if (!$owner || !$restaurant) {
            return response()->json(['success' => false, 'message' => 'No restaurant found for this owner.']);
        }
        
        try {
            // Find the menu item and ensure it belongs to this restaurant
            $menuItem = MenuItem::where('id', $itemId)
                              ->where('restaurant_id', $restaurant->id)
                              ->firstOrFail();
            
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'item_name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'category_id' => 'nullable|string|max:255',
                'image' => 'nullable|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ]);
            }
            // Store old price for comparison
            $oldPrice = $menuItem->price;
            
            
            // Update the menu item
            $menuItem->item_name = $request->item_name;
            $menuItem->price = $request->price;
            $menuItem->description = $request->description;
            $menuItem->category_id = $request->category_id;
            $menuItem->image = $request->image;
            $menuItem->save();
             
            
            $orderItems = OrderItem::where('menu_item_id', $itemId)->get();
            
            foreach ($orderItems as $orderItem) {
                // Calculate the price adjustment factor if the price has changed
                $priceAdjustmentFactor = 1;
                if ($oldPrice > 0 && $oldPrice != $menuItem->price) {
                    $priceAdjustmentFactor = $menuItem->price / $oldPrice;
                }
                
                // Update the order item price based on the new menu item price
                $newPrice = $orderItem->price * $priceAdjustmentFactor;
                
                // Update the order item
                $orderItem->price = $newPrice;
                $orderItem->save();
                
                // Update the order total
                $order = Order::find($orderItem->orders_id);
                if ($order) {
                    // Recalculate the total price for the order
                    $orderTotal = OrderItem::where('orders_id', $order->id)->sum('price');
                    $order->total_price = $orderTotal;
                    $order->save();
                }
            }
            
            return response()->json(['success' => true, 'message' => 'Menu item updated successfully']);
        } catch (\Exception $e) {
            Log::error('Error updating menu item: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error updating menu item: ' . $e->getMessage()]);
        }
    }

    
    /**
     * Confirm an order for the specific restaurant
     */
    public function confirmOrder(Request $request, $owner_id)
{
    $owner = Owner::find($owner_id);
    $restaurant = Restaurant::where('owner_id', $owner_id)->first();

    if (!$owner || !$restaurant) {
        return response()->json(['success' => false, 'message' => 'No restaurant found for this owner.']);
    }

    $cart = $request->input('cart');
    $table = $request->input('table', 'N/A');
    $guests = $request->input('guests', 'N/A');

    if (empty($cart)) {
        return response()->json(['success' => false, 'message' => 'Cart is empty.']);
    }

    DB::beginTransaction();
    try {
        // Create guest customer
        $customer = new Customer();
        $customer->name = 'Guest';
        $customer->phone = 'guest_' . uniqid(); // Generate unique identifier
        $customer->save();

        // Create order
        $order = new Order();
        $order->owner_id = $owner_id;
        $order->restaurant_id = $restaurant->id;
        $order->status = 'pending';
        $order->total_price = 0;
        $order->customer_id = $customer->id;
        $order->localisation = json_encode(['table' => $table, 'guests' => $guests]);
        $order->save();

        $total = 0;

        foreach ($cart as $item) {
            $menuItem = MenuItem::where('id', $item['id'])
            ->where('restaurant_id', $restaurant->id)
            ->first();
        

            if ($menuItem) {
                $price = $menuItem->price * $item['quantity'];

                $orderItem = new OrderItem(); 
                $orderItem->order_id = $order->id; 
                $orderItem->menu_item_id = $menuItem->id;
                $orderItem->quantity = $item['quantity'];
                $orderItem->price = $price;
                $orderItem->created_at;
                $orderItem->save();

                $total += $price;
            }
        }

        $order->total_price = $total;
        $order->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'order_number' => $this->generateOrderNumber($owner->restaurant_id)
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Order failed: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Order failed: ' . $e->getMessage()]);
    }
}


    /**
     * Generate a unique order number for the restaurant
     */
    private function generateOrderNumber($restaurantId)
    {
        // Get today's date in format YYYYMMDD
        $datePrefix = date('Ymd');
        
        // Get the count of orders for this restaurant today
        $orderCount = Order::where('restaurant_id', $restaurantId)
                          ->whereDate('created_at', DB::raw('CURDATE()'))
                          ->count();
        
        // Increment the count
        $orderCount++;
        
        // Format: YYYYMMDD-RESTAURANT_ID-COUNT (e.g., 20250427-123-42)
        return $datePrefix . '-' . $restaurantId . '-' . str_pad($orderCount, 3, '0', STR_PAD_LEFT);

    }

    public function toggleOrderStatus(Request $request, $owner_id)
    {
        // Get the owner by ID
        $owner = Owner::find($owner_id);
        $restaurant = Restaurant::where('owner_id', $owner_id)->first();
        if (!$owner || !$restaurant) {
            return response()->json(['success' => false, 'message' => 'No restaurant found for this owner.']);
        }
        
        $newStatus = $request->input('status');
        
        if (!in_array($newStatus, ['on', 'off'])) {
            return response()->json(['success' => false, 'message' => 'Invalid status. Must be "on" or "off".']);
        }
        
        DB::beginTransaction();
        try {
            // Get all orders for this restaurant
            $orders = Order::where('restaurant_id', $restaurant->id)
                         ->orderBy('created_at', 'desc')
                         ->get();
            
            if ($orders->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No orders found for this restaurant.']);
            }
            
            if ($newStatus === 'on') {
                // Turn on all orders
                foreach ($orders as $order) {
                    // Check if already on
                    $isAlreadyOn = OrderOn::where('owner_id', $owner_id)
                                         ->where('order_id', $order->id)
                                         ->exists();
                
                    if (!$isAlreadyOn) {
                        // Turn on order
                        $orderOn = new OrderOn();
                        $orderOn->owner_id = $owner_id;
                        $orderOn->order_id = $order->id;
                        $orderOn->save();
                    }
                
                    // Remove any order off records for this order
                    OrderOff::where('order_id', $order->id)->delete();
                }
            } else {
                // Turn off all orders
                foreach ($orders as $order) {
                    // Check if already off
                    $isAlreadyOff = OrderOff::where('order_id', $order->id)
                                           ->exists();
                    
                    if (!$isAlreadyOff) {
                        // Turn off order
                        $orderOff = new OrderOff();
                        $orderOff->chef_id = $owner_id; // Using owner_id as chef_id
                        $orderOff->order_id = $order->id;
                        $orderOff->save();
                    }
                }
            }
        
            DB::commit();
            return response()->json(['success' => true, 'status' => $newStatus]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error toggling order status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error toggling order status: ' . $e->getMessage()]);
        }
    }


    /**
     * View orders for the specific restaurant
     */
    public function orders($owner_id)
    {  
        
        $owner = Owner::find($owner_id);
        $restaurant = Restaurant::where('owner_id', $owner_id)->first();

        if (!$owner || !$restaurant) {
            return redirect()->back()->with('error', 'No restaurant found for this owner.');
        }
        
        try {
           
               
            // Get today's orders for this restaurant
            $todayOrders = Order::where('restaurant_id', $restaurant->id)
            -> whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->with(['orderItems.menuItem'])
            ->get();

           // Check if any orders exist
           if ($todayOrders->isEmpty()) {
            $orderStatus = 'off'; // Default to off if no orders
        } else {
            // Check if all orders are on
            $allOrdersOn = true;
            
            foreach ($todayOrders as $order) {
                $isOrderOn = OrderOn::where('owner_id', $owner_id)
                                   ->where('order_id', $order->id)
                                   ->exists();
                               
                $isOrderOff = OrderOff::where('order_id', $order->id)
                                     ->exists();
                
                // If any order is off, then not all orders are on
                if (!$isOrderOn || $isOrderOff) {
                    $allOrdersOn = false;
                    break;
                }
            }
            
            $orderStatus = $allOrdersOn ? 'on' : 'off';
        }
            return view('pos-orders', compact('restaurant', 'todayOrders', 'owner_id', 'orderStatus'));
            
        } catch (\Exception $e) {
            Log::error('Error retrieving orders: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error retrieving orders: ' . $e->getMessage());
        }
    }

    /**
     * Check Order Status (ON/OFF) for the specific restaurant
     */
    public function orderStatusCheck($owner_id)
    {
        // Get the owner by ID
        $owner = Owner::find($owner_id);
        $restaurant = Restaurant::where('owner_id', $owner_id)->first();
        if (!$owner || !$restaurant) {
            return response()->json(['success' => false, 'message' => 'No restaurant found for this owner.']);
        }

        // Get all orders for this restaurant
        $orders = Order::where('restaurant_id', $restaurant->id)
                     ->orderBy('created_at', 'desc')
                     ->get();
        
        if ($orders->isEmpty()) {
            return response()->json(['success' => true, 'status' => 'off', 'restaurant_id' => $restaurant->id]);
        }

        // Check if all orders are on
        $allOrdersOn = true;
        
        foreach ($orders as $order) {
            $isOrderOn = OrderOn::where('owner_id', $owner_id)
                               ->where('order_id', $order->id)
                               ->exists();
                           
            $isOrderOff = OrderOff::where('order_id', $order->id)
                                 ->exists();
            
            // If any order is off, then not all orders are on
            if (!$isOrderOn || $isOrderOff) {
                $allOrdersOn = false;
                break;
            }
        }
        
        $status = $allOrdersOn ? 'on' : 'off';

        return response()->json(['success' => true, 'status' => $status, 'restaurant_id' => $restaurant->id]);
    }

    

    /**
     * Update the status of an order
     */
    public function updateOrderStatus(Request $request, $owner_id, $orderId)
    {
        // Get the owner by ID
        $owner = Owner::find($owner_id);
        $restaurant = Restaurant::where('owner_id', $owner_id)->first();
        if (!$owner || !$restaurant) {
            return response()->json(['success' => false, 'message' => 'No restaurant found for this owner.']);
        }
        
        try {
            // Find the order and ensure it belongs to this restaurant
            $order = Order::where('id', $orderId)
                         ->where('restaurant_id', $restaurant->id)
                         ->firstOrFail();
            
            // Update the status
            $order->status = (string) $request->input('status');
            
            $order->save();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error updating order status: ' . $e->getMessage()]);
        }
    }

    /**
     * Print a receipt for an order
     */
    public function printReceipt($owner_id, $orderId)
    {
        // Get the owner by ID
        $owner = Owner::find($owner_id);
        $restaurant = Restaurant::where('owner_id', $owner_id)->first();
        if (!$owner || !$restaurant) {
            return redirect()->back()->with('error', 'No restaurant found for this owner.');
        }
        
        try {
            // Find the order and ensure it belongs to this restaurant
            $order = Order::where('id', $orderId)
                         ->where('restaurant_id', $restaurant->id)
                         ->with(['orderItems.menuItem'])
                         ->firstOrFail();
            
        
            
            
        } catch (\Exception $e) {
            Log::error('Error generating receipt: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error generating receipt: ' . $e->getMessage());
        }
    }

    
}
