@extends('layouts.app')

@section('content')
<form action="{{ route('qrcode.show') }}" method="GET">
  <div class="max-w-3xl mx-auto px-4 py-8 px-4 py-10 print:px-0 print:py-0">
    <div class="bg-white rounded-lg shadow p-6 print:shadow-none print:border print:border-gray-300 print:rounded-none">
      <h1 class="text-2xl font-semibold text-center mb-4 text-[#ff8903] print:text-black">
        Your Restaurant QR Code
      </h1>

      <div class="text-center">
        <h2 class="text-lg font-medium mb-4 print:text-black">
          {{ $restaurant->resturantName ?? 'Your Restaurant' }}
        </h2>

        <!-- QR Code Image -->
        <div class="flex justify-center mb-4">
          <img 
            src="{{ $qrCodeUrl }}" 
            alt="Menu QR Code" 
            class="w-full max-w-xs object-contain"
          >
        </div>

        <p class="text-gray-700 mb-4 print:text-black">
          Scan this QR code to view your restaurant menu!
        </p>

        <!-- Menu URL -->
        <p class="text-sm text-gray-600 print:text-black">
          <strong>Menu URL:</strong>
          <a href="{{ $menuUrl }}" target="_blank" class="text-blue-600 underline break-words print:text-black print:no-underline">
            {{ $menuUrl }}
          </a>
        </p>

        <!-- Action Buttons (hidden when printing) -->
        <div class="mt-6 flex flex-col sm:flex-row justify-center gap-4 print:hidden">
          <button 
            type="button"
            onclick="window.print()" 
            class="bg-[#ff8903]  px-5 py-2 rounded-md shadow hover:bg-orange-500 transition"
          >
            <i class="fas fa-print mr-2"></i> Print QR Code
          </button>

          <a 
            href="{{ route('owner.profile', ['id' => $restaurant_id]) }}"
            class="bg-gray-500 text-white px-5 py-2 rounded-md shadow hover:bg-gray-600 transition"
          >
            <i class="fas fa-user mr-2"></i> Back to Profile
          </a>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

