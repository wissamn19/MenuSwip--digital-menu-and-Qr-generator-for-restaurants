<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class MenuItemController extends Controller
{
    public function store(Request $request)
    {
        // Get category_id and restaurant_id from session, default to 1 if not set
        $category_id = session('category_id', 1);
        $restaurant_id = session('restaurant_id', 1);

        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        // Process each food item
        $foodCards = count($request->input('name', []));
        
        for ($i = 0; $i < $foodCards; $i++) {
            // Get form data for this item
            $name = $request->input('name.' . $i);
            $description = $request->input('description.' . $i);
            $price = $request->input('price.' . $i);
            $image_path = $request->input('food_image_path.' . $i);

            // Skip empty items
            if (empty($name) && empty($price) && empty($image_path)) {
                continue;
            }

            // Validate required fields
            if (empty($name)) {
                $errors[] = "Food name is required for item #" . ($i + 1);
                $errorCount++;
                continue;
            }

            if (empty($price)) {
                $errors[] = "Price is required for item #" . ($i + 1);
                $errorCount++;
                continue;
            }

            // Generate slug from name
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

            // Set default language
            $language = 'en';

            // Set visibility
            $is_hidden = 0;

            try {
                // Insert the menu item into the database using Laravel's DB facade
                DB::table('menu_items')->insert([
                    'category_id' => $category_id,
                    'item_name' => $name,
                    'slug' => $slug,
                    'description' => $description,
                    'price' => $price,
                    'image' => $image_path,
                    'is_hidden' => $is_hidden,
                    'language' => $language,
                    'restaurant_id' => $restaurant_id,
                ]);

                $successCount++;
            } catch (\Exception $e) {
                $errors[] = "Error saving item #" . ($i + 1) . ": " . $e->getMessage();
                $errorCount++;
            }
        }

        // Store session messages
        if ($successCount > 0) {
            Session::flash('success', "Successfully added $successCount food items.");
        }

        // Store errors in session if there are any
        if ($errorCount > 0) {
            Session::flash('errors', $errors);
        }

        // Redirect to next page or show errors
        if ($errorCount === 0) {
            return redirect()->route('menu.type2'); // Route for 'menu-type-2.html'
        } else {
            return redirect()->route('menu.type1'); // Route for 'menu-type-1.html'
        }
    }
}
