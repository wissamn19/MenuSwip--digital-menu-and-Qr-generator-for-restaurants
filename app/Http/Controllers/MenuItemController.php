<?php

namespace App\Http\Controllers;

use App\Models\restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class MenuItemController extends Controller
{
    // Affiche la page Menu-Type-1
    public function showType1($restaurant)
    {
        // On stocke en session pour la store() plus bas
        session([
            'restaurant_id' => $restaurant,
            'category_id'   => 1,
        ]);

        return view('menu-type-1', [
            'restaurant_id' => $restaurant,
        ]);
    }

    // Affiche la page Menu-Type-2
    public function showType2($restaurant)
    {
        session([
            'restaurant_id' => $restaurant,
            'category_id'   => 2,
        ]);

        return view('menu-type-2', [
            'restaurant_id' => $restaurant,
        ]);
    }

    // Affiche la page Menu-Type-3
    

public function showType3($restaurant)
{
    // Stocke l'ID du restaurant et la catégorie en session
    session([
        'restaurant_id' => $restaurant,
        'category_id'   => 3,
    ]);

    // Retourne la vue en envoyant également le restaurant_id à la vue
    return view('menu-type-3', [
        'restaurant_id' => $restaurant,  
    ]);
}


    







// Store menu items from Type 1 (Salty food)
public function store(Request $request)
{
    // Get restaurant ID
    $restaurant_id = $request->input('restaurant_id') ?? session('restaurant_id');
    
    if (!$restaurant_id) {
        return redirect()->back()->with('error', 'Restaurant ID is required');
    }
    
    // Save in session for backup
    session(['restaurant_id' => $restaurant_id]);
    session(['category_id' => 1]); // Set the category for salty foods
    
    try {
        // Process the form data
        $itemNames = $request->input('item_name', []);
        $descriptions = $request->input('description', []);
        $prices = $request->input('price', []);
        $imagePaths = $request->input('food_image_path', []);
        
        $count = 0;
        
        // Process each item
        foreach ($itemNames as $key => $name) {
            // Skip if name or price is empty
            if (empty($name) || empty($prices[$key])) {
                continue;
            }
            
            // Create slug
            $slug = \Illuminate\Support\Str::slug($name);
            
            // Insert into database
            DB::table('menu_items')->insert([
                'category_id' => 1, // Salty food category
                'restaurant_id' => $restaurant_id,
                'item_name' => $name,
                'slug' => $slug,
                'description' => $descriptions[$key] ?? null,
                'price' => $prices[$key],
                'image' => $imagePaths[$key] ?? null,
                'is_hidden' => 0,
                'language' => 'en',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $count++;
        }
        
        // Flash a success message
        return redirect()
            ->route('menu.type2', ['restaurant' => $restaurant_id])
            ->with('success', "Successfully added $count salty food items.");
    } catch (\Exception $e) {
        // Log the error
        Log::error('Error saving salty food items: ' . $e->getMessage());
        
        // Redirect back with error
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'An error occurred while saving your salty food items. Please try again.');
    }
}










public function storeType2(Request $request)
{
    // Get restaurant ID
    $restaurant_id = $request->input('restaurant_id') ?? session('restaurant_id');
    
    if (!$restaurant_id) {
        return redirect()->back()->with('error', 'Restaurant ID is required');
    }
    
    // Save in session for backup
    session(['restaurant_id' => $restaurant_id]);
    session(['category_id' => 2]); // Set the category for sweet foods
    
    try {
        // Process the form data
        $itemNames = $request->input('item_name', []);
        $descriptions = $request->input('description', []);
        $prices = $request->input('price', []);
        $imagePaths = $request->input('food_image_path', []);
        
        $count = 0;
        
        // Process each item
        foreach ($itemNames as $key => $name) {
            // Skip if name or price is empty
            if (empty($name) || empty($prices[$key])) {
                continue;
            }
            
            // Create slug
            $slug = \Illuminate\Support\Str::slug($name);
            
            // Insert into database
            DB::table('menu_items')->insert([
                'category_id' => 2, // Sweet food category
                'restaurant_id' => $restaurant_id,
                'item_name' => $name,
                'slug' => $slug,
                'description' => $descriptions[$key] ?? null,
                'price' => $prices[$key],
                'image' => $imagePaths[$key] ?? null,
                'is_hidden' => 0,
                'language' => 'en',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $count++;
        }
        
        // Flash a success message
        return redirect()
            ->route('menu.type3', ['restaurant' => $restaurant_id])
            ->with('success', "Successfully added $count sweet food items.");
    } catch (\Exception $e) {
        // Log the error
        Log::error('Error saving sweet food items: ' . $e->getMessage());
        
        // Redirect back with error
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'An error occurred while saving your sweet food items. Please try again.');
    }
}















// 3. Update the storeType3 method in MenuItemController.php:
public function storeType3(Request $request, $restaurant) {
    $restaurant_id = $request->input('restaurant_id') ?? $restaurant;
    
    // Make sure we have a restaurant ID
    if (!$restaurant_id) {
        $restaurant_id = session('restaurant_id');
        if (!$restaurant_id) {
            abort(400, 'Restaurant ID is required');
        }
    }
    
    // Save in session for backup
    session(['restaurant_id' => $restaurant_id]);
    session(['category_id' => 3]); // Set the category for drinks
    
    try {
        // Process the menu items
        $itemNames = $request->input('item_name', []);
        $descriptions = $request->input('description', []);
        $prices = $request->input('price', []);
        $images = $request->file('image', []);
        $imagePaths = $request->input('food_image_path', []);
        
        $count = 0;
        
        // Process each item
        foreach ($itemNames as $key => $name) {
            // Skip if name or price is empty
            if (empty($name) || empty($prices[$key])) {
                continue;
            }
            
            // Handle image upload if present
            $imagePath = null;
            
            // First check if we already have an uploaded image path
            if (isset($imagePaths[$key]) && !empty($imagePaths[$key])) {
                $imagePath = $imagePaths[$key];
            }
            // Otherwise check if a file was uploaded with the form
            else if (isset($images[$key]) && $images[$key]) {
                $image = $images[$key];
                
                // Store the image in public/uploads/food_images directory directly
                // This is different from using Laravel's store() method
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/food_images'), $filename);
                $imagePath = 'uploads/food_images/' . $filename;
            }
            
            // Create slug
            $slug = Str::slug($name);
            
            // Insert into database
            DB::table('menu_items')->insert([
                'category_id' => 3, // Drinks category
                'restaurant_id' => $restaurant_id,
                'item_name' => $name,
                'slug' => $slug,
                'description' => $descriptions[$key] ?? null,
                'price' => $prices[$key],
                'image' => $imagePath,
                'is_hidden' => 0,
                'language' => 'en',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $count++;
        }
        
        // Flash a success message
        Session::flash('success', "Successfully added $count drink items.");
        
        // Redirect to QR code page
        return redirect()->route('qrcode.show', ['restaurant_id' => $restaurant_id]);
    
    } catch (\Exception $e) {
        // Log the error
        Log::error('Error saving drink items: ' . $e->getMessage());
        
        // Redirect back with error and input
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'An error occurred while saving your drink items: ' . $e->getMessage());
    }
}
        
    
    
    //  method to handle menu item storage consistently
    protected function storeMenuItems(Request $request, $category_id)
{
    // Validate the input
    $request->validate([
        'item_name' => 'required|array',
        'item_name.*' => 'required|string|max:100',
        'description.*' => 'nullable|string',
        'price.*' => 'required|numeric',
        'image.*' => 'nullable|image|max:2048',
    ]);

    $restaurant_id = $request->input('restaurant_id');
    
    // Loop through each item and save it
    foreach ($request->item_name as $key => $name) {
        // Handle image upload if present
        $imagePath = null;
        if ($request->hasFile('image') && isset($request->file('image')[$key])) {
            $image = $request->file('image')[$key];
            $imagePath = $image->store('menu-items', 'public');
        }
        
        // Create the menu item
        DB::table('menu_items')->insert([
            'category_id' => $category_id,
            'restaurant_id' => $restaurant_id,
            'item_name' => $name,
            'slug' => Str::slug($name),
            'description' => $request->description[$key] ?? null,
            'price' => $request->price[$key],
            'image' => $imagePath ?? 'default-image.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    
    return true;
}
        
    











public function defaultMenu($restaurant_id)
{
    $sweet  = DB::table('menu_items')
                 ->where('restaurant_id', $restaurant_id)
                 ->where('category_id', 1)
                 ->get();
    $salty  = DB::table('menu_items')
                 ->where('restaurant_id', $restaurant_id)
                 ->where('category_id', 2)
                 ->get();
    $drinks = DB::table('menu_items')
                 ->where('restaurant_id', $restaurant_id)
                 ->where('category_id', 3)
                 ->get();

    // on passe aussi restaurant_id à la vue
    return view('menus.default', compact('restaurant_id','sweet','salty','drinks'));
}

}

