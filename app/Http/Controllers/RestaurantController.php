<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the restaurants.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('restaurants.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new restaurant.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurants.create');
    }

    /**
     * Store a newly created restaurant in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'restaurantName' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'State' => 'required|string|max:255',
            'phonen' => 'nullable|string|max:20',
            'type' => 'nullable|string|max:100',
            'starttime' => 'required|date_format:H:i',
            'endtime' => 'required|date_format:H:i|after:starttime',
            'urlimage' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'owner_id' => 'required|exists:users,id',
        ]);

        // Create a new restaurant
        $restaurant = new Restaurant();
        $restaurant->restaurantName = $request->input('restaurantName');
        $restaurant->location = $request->input('location');
        $restaurant->State = $request->input('State');
        $restaurant->phonen = $request->input('phonen');
        $restaurant->type = $request->input('type');
        $restaurant->starttime = $request->input('starttime');
        $restaurant->endtime = $request->input('endtime');
        $restaurant->owner_id = $request->input('owner_id');

        // Handle the image upload if there's an image
        if ($request->hasFile('urlimage')) {
            $image = $request->file('urlimage');
            $imagePath = $image->store('restaurant_images', 'public');
            $restaurant->urlimage = asset('storage/' . $imagePath);
        }

        // Save the restaurant
        $restaurant->save();

        return redirect()->route('restaurant.show', $restaurant->id)
            ->with('success', 'Restaurant created successfully!');
    }

    /**
     * Display the specified restaurant.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $restaurant = Restaurant::find($id);
       
        if (!$restaurant) {
            abort(404, 'Restaurant not found');
        }

        return view('owner-profile', compact('restaurant'));
    }

    /**
     * Show the form for editing the specified restaurant.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('restaurants.edit', compact('restaurant'));
    }

    public function ownerProfile($id)
    {
        $restaurant = \App\Models\Restaurant::where('owner_id', $id)->first();
    
        if (!$restaurant) {
            abort(404, 'No restaurant found for this owner.');
        }
    
        return view('owner-profile', ['restaurant' => $restaurant]);
    }
    
    


    /**
     * Update the specified restaurant in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);

        // Validate the incoming data
        $validated = $request->validate([
            'restaurantName' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'State' => 'required|string|max:255',
            'phonen' => 'nullable|string|max:20',
            'type' => 'nullable|string|max:100',
            'starttime' => 'required|date_format:H:i',
            'endtime' => 'required|date_format:H:i|after:starttime',
            'urlimage' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Update the restaurant's details
        $restaurant->restaurantName = $request->input('restaurantName');
        $restaurant->location = $request->input('location');
        $restaurant->State = $request->input('State');
        $restaurant->phonen = $request->input('phonen');
        $restaurant->type = $request->input('type');
        $restaurant->starttime = $request->input('starttime');
        $restaurant->endtime = $request->input('endtime');

        // Handle the image upload if there's a new image
        if ($request->hasFile('urlimage')) {
            // Delete old image if it exists
            if ($restaurant->urlimage) {
                $oldPath = str_replace(asset('storage/'), '', $restaurant->urlimage);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            
            $image = $request->file('urlimage');
            $imagePath = $image->store('restaurant_images', 'public');
            $restaurant->urlimage = asset('storage/' . $imagePath);
        }

        // Save the updated restaurant details
        $restaurant->save();

        return redirect()->route('restaurant.show', $restaurant->id)
            ->with('success', 'Restaurant details updated successfully!');
    }

    /**
     * Remove the specified restaurant from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        
        // Delete the restaurant image if it exists
        if ($restaurant->urlimage) {
            $imagePath = str_replace(asset('storage/'), '', $restaurant->urlimage);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }
        
        // Delete the restaurant
        $restaurant->delete();
        
        return redirect()->route('restaurants.index')
            ->with('success', 'Restaurant deleted successfully!');
    }

    /**
     * Handle AJAX image upload for restaurant
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'urlimage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'restaurant_id' => 'required|exists:restaurants,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . $validator->errors()->first()
            ]);
        }

        try {
            // Get the restaurant
            $restaurantId = $request->input('restaurant_id');
            $restaurant = Restaurant::findOrFail($restaurantId);
            
            // Handle file upload
            if ($request->hasFile('urlimage')) {
                // Delete old image if it exists
                if ($restaurant->urlimage) {
                    // Extract the path from the full URL
                    $oldPath = parse_url($restaurant->urlimage, PHP_URL_PATH);
                    if ($oldPath) {
                        $oldPath = ltrim($oldPath, '/storage/');
                        if (Storage::disk('public')->exists($oldPath)) {
                            Storage::disk('public')->delete($oldPath);
                        }
                    }
                }
                
                // Generate a unique filename
                $filename = Str::random(20) . '.' . $request->file('urlimage')->getClientOriginalExtension();
                
                // Store the file in the public disk under 'restaurant_images'
                $imagePath = $request->file('urlimage')->storeAs('restaurant_images', $filename, 'public');
                
                // Generate the URL for the stored image
                $imageUrl = asset('storage/' . $imagePath);
                
                // Update the restaurant with the new image URL
                $restaurant->urlimage = $imageUrl;
                $restaurant->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully!',
                    'file_path' => $imageUrl
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'No file uploaded.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get restaurants by owner ID
     *
     * @param  int  $ownerId
     * @return \Illuminate\Http\Response
     */
    public function getByOwner($ownerId)
    {
        $restaurants = Restaurant::where('owner_id', $ownerId)->get();
        
        if ($restaurants->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No restaurants found for this owner'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $restaurants
        ]);
    }

    /**
     * Search restaurants by name, location, or type
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $restaurants = Restaurant::where('restaurantName', 'like', "%{$query}%")
            ->orWhere('location', 'like', "%{$query}%")
            ->orWhere('State', 'like', "%{$query}%")
            ->orWhere('type', 'like', "%{$query}%")
            ->get();
            
        return view('restaurants.search', compact('restaurants', 'query'));
    }

    /**
     * Get restaurant working hours
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWorkingHours($id)
    {
        $restaurant = Restaurant::with(['workingHours' => function ($query) {
            $query->orderBy('start_time');
        }])->findOrFail($id);
    
        return view('owner-profile', compact('restaurant'));
    }
    

    /**
     * Update restaurant working hours
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateWorkingHours(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'starttime' => 'required|date_format:H:i',
            'endtime' => 'required|date_format:H:i|after:starttime',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . $validator->errors()->first()
            ]);
        }

        $restaurant = Restaurant::find($id);
        
        if (!$restaurant) {
            return response()->json([
                'success' => false,
                'message' => 'Restaurant not found'
            ]);
        }
        
        $restaurant->starttime = $request->input('starttime');
        $restaurant->endtime = $request->input('endtime');
        $restaurant->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Working hours updated successfully',
            'data' => [
                'starttime' => $restaurant->starttime,
                'endtime' => $restaurant->endtime
            ]
        ]);
    }

  
    
    

}