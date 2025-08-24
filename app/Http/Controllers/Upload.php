<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Upload extends Controller
{
    // Define constants
    const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
    const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif'];

    /**
     * Handle image upload for restaurant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        // Initialize response array
        $response = [
            'success' => false,
            'message' => '',
            'file_path' => ''
        ];

        // Check if file was uploaded
        if ($request->hasFile('imageurl') && $request->file('imageurl')->isValid()) {
            $file = $request->file('imageurl');

            // Validate file size
            if ($file->getSize() > self::MAX_FILE_SIZE) {
                $response['message'] = 'File is too large. Maximum size is ' . (self::MAX_FILE_SIZE / 1024 / 1024) . 'MB';
                return response()->json($response);
            }

            // Validate file extension
            $extension = $file->getClientOriginalExtension();
            if (!in_array(strtolower($extension), self::ALLOWED_EXTENSIONS)) {
                $response['message'] = 'Invalid file type. Allowed types: ' . implode(', ', self::ALLOWED_EXTENSIONS);
                return response()->json($response);
            }

            // Generate unique filename
            $newFilename = uniqid('restaurant_') . '.' . $extension;

            // Store file in the 'uploads' directory
            $uploadPath = 'uploads/' . $newFilename;
            $file->move(public_path('uploads'), $newFilename);

            // Update the restaurant record in the database
            $restaurantId = $request->input('restaurant_id');
            if ($restaurantId) {
                try {
                    $affectedRows = DB::table('restaurants')
                        ->where('id', $restaurantId)
                        ->update(['urlimage' => $uploadPath]);

                    if ($affectedRows > 0) {
                        $response['success'] = true;
                        $response['message'] = 'Image uploaded and database updated successfully!';
                        $response['file_path'] = $uploadPath;
                    } else {
                        $response['message'] = 'Restaurant not found or no changes made.';
                    }
                } catch (\Exception $e) {
                    $response['message'] = 'Database error: ' . $e->getMessage();
                }
            } else {
                $response['message'] = 'Restaurant ID not provided.';
            }
        } else {
            $response['message'] = 'No file uploaded or upload error occurred.';
            if ($request->hasFile('imageurl')) {
                $response['error_code'] = $request->file('imageurl')->getError();
            }
        }

        // Return JSON response
        return response()->json($response);
    }
}
