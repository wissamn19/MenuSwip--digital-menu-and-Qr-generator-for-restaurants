<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class FoodImageUploadController extends Controller
{
    // Define allowed file types and max file size
    private $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private $maxFileSize = 5 * 1024 * 1024; // 5MB
    private $minWidth = 320;
    private $minHeight = 279;

    public function upload(Request $request)
    {
        // Validate request method
        if ($request->isMethod('post')) {

            // Check if a file is uploaded
            if (!$request->hasFile('food_image') || !$request->file('food_image')->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No file uploaded or upload error'
                ]);
            }

            $file = $request->file('food_image');
            $index = $request->input('index', 0);

            // Validate file type
            if (!in_array($file->getClientMimeType(), $this->allowedTypes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.'
                ]);
            }

            // Validate file size
            if ($file->getSize() > $this->maxFileSize) {
                return response()->json([
                    'success' => false,
                    'message' => 'File size exceeds the limit of 5MB'
                ]);
            }

            // Validate image dimensions
            list($width, $height) = getimagesize($file->getRealPath());
            if ($width < $this->minWidth || $height < $this->minHeight) {
                return response()->json([
                    'success' => false,
                    'message' => "Image dimensions should be at least {$this->minWidth}x{$this->minHeight} pixels"
                ]);
            }

            // Generate unique filename
            $newFileName = uniqid('food_') . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Define the upload path
            $uploadPath = 'uploads/food_images/' . $newFileName;

            // Store the file
            if ($file->move(public_path('uploads/food_images'), $newFileName)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully',
                    'image_path' => $uploadPath,
                    'index' => $index
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save the uploaded image'
                ]);
            }
        }

        // Handle invalid request method
        return response()->json([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }
}