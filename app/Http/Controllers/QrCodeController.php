<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Config\WriterConfig;
use Illuminate\Support\Facades\DB;
class QrCodeController extends Controller

{
    
public function showQR(Request $request) {
    // Get restaurant_id from request or session
    $restaurant_id = $request->query('restaurant_id') ?? session('restaurant_id');
    
    if (!$restaurant_id) {
        abort(400, 'Restaurant ID is required');
    }
    
    // Get the restaurant info
    $restaurant = DB::table('restaurants')
        ->where('id', $restaurant_id)
        ->first();
    
    if (!$restaurant) {
        abort(404, 'Restaurant not found');
    }
    
    // Generate the menu URL
    $menuUrl = route('menu.default', ['restaurant_id' => $restaurant_id]);
    
    // For the view, we'll generate the QR code inline or show it as an image
    return view('qrcode.show', [
        'restaurant' => $restaurant,
        'restaurant_id' => $restaurant_id,
        'qrCodeUrl' => route('qr-code.generate', ['restaurant_id' => $restaurant_id]),
        'menuUrl' => $menuUrl
    ]);
}

public function generate($restaurant_id)
{
    // Generate the menu URL
    $menuUrl = route('menu.default', ['restaurant_id' => $restaurant_id]);
    
    // Create QR code
    $qrCode = new QrCode($menuUrl);
    $writer = new PngWriter();
    $qrImage = $writer->write($qrCode)->getString();
    
    return response($qrImage)
        ->header('Content-Type', 'image/png');
}

}
