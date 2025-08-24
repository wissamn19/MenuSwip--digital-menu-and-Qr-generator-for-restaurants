<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MenuItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FoodItemController extends Controller
{
    /**
     * Show the form for creating food items.
     */
    public function create()
    {
        // Get the category ID from the route or session
       
        $categoryId = session('category_id', 1); // Default to 1 (salty food)
        $categoryName = 'salty food'; // You can fetch this from a categories table
        
        return view('menu-type-1', compact('categoryId', 'categoryName'));
    }

    /**
     * Store food items in the database.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string|max:100',
            'items.*.description' => 'nullable|string',
            'items.*.price' => 'required|numeric',
            'items.*.image_path' => 'nullable|string',
        ]);

        // Get category ID and restaurant ID
        $categoryId = $request->input('category_id', 1);
        $restaurantId = auth()->user()->restaurant_id ?? 1; // Assuming user is logged in and has a restaurant_id
        
        // Process each food item
        $items = $request->input('items');
        foreach ($items as $item) {
            // Skip if no name is provided
            if (empty($item['name'])) {
                continue;
            }
            
            // Create a new food item
            MenuItem::create([
                'category_id' => $categoryId,
                'restaurant_id' => $restaurantId,
                'item_name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'description' => $item['description'] ?? null,
                'price' => $item['price'],
                'image' => $item['image_path'] ?? null,
                'is_hidden' => 0,
                'language' => app()->getLocale(),
            ]);
        }
        
        // Redirect to the next page with success message
        return redirect()->route('menu.type.2')
            ->with('success', 'Food items saved successfully!');
    }

    /**
     * Upload an image for a food item.
     */
    public function uploadImage(Request $request)
    {
        // Validate the request
        $request->validate([
            'food_image' => 'required|image|max:5120', // Max 5MB
        ]);
        
        // Check if file exists
        if (!$request->hasFile('food_image')) {
            return response()->json([
                'success' => false,
                'message' => 'No image uploaded'
            ]);
        }
        
        try {
            // Get the file
            $file = $request->file('food_image');
            
            // Generate a unique filename
            $filename = 'food_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Store the file
            $path = $file->storeAs('public/food_images', $filename);
            
            // Return success response with the file path
            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'image_path' => Storage::url($path),
                'index' => $request->input('index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image: ' . $e->getMessage()
            ]);
        }
    }
}