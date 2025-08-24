@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  <h1 class="text-2xl md:text-3xl font-medium text-[#ff8903] text-center mb-8">
    Restaurant's menu: {{ $restaurant_id }}
  </h1>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <!-- Salty Food Section -->
    <div>
      <h2 class="text-xl font-semibold text-center lg:text-left text-gray-800 mb-4">Salty Food</h2>
      <div class="space-y-6">
        @forelse($sweet as $item)
          <div class="menu-item flex flex-col items-center text-center p-4 bg-white shadow rounded-lg">
            @if($item->image)
              <div class="w-24 h-24 mb-2">
                <img 
                  src="{{ $item->image ? (str_starts_with($item->image, 'http') ? $item->image : asset($item->image)) : asset('images/placeholder.png') }}" 
                  alt="{{ $item->item_name }}" 
                  class="w-full h-full object-cover rounded-lg"
                  onerror="this.src='{{ asset('images/placeholder.png') }}'"
                >
              </div>
            @endif
            <div class="menu-item-content">
              <h3 class="font-medium text-lg">{{ $item->item_name }}</h3>
              <p class="text-gray-600 text-sm my-1">{{ $item->description }}</p>
              <p class="font-bold text-[#ff8903]">{{ $item->price }} DZ</p>
            </div>
          </div>
        @empty
          <p class="text-gray-500 italic text-center">No salty food items available</p>
        @endforelse
      </div>
    </div>

    <!-- Sweet Food Section -->
    <div>
      <h2 class="text-xl font-semibold text-center lg:text-left text-gray-800 mb-4">Sweet Food</h2>
      <div class="space-y-6">
        @forelse($salty as $item)
          <div class="menu-item flex flex-col items-center text-center p-4 bg-white shadow rounded-lg">
            @if($item->image)
              <div class="w-24 h-24 mb-2">
                <img 
                  src="{{ $item->image ? (str_starts_with($item->image, 'http') ? $item->image : asset($item->image)) : asset('images/placeholder.png') }}" 
                  alt="{{ $item->item_name }}" 
                  class="w-full h-full object-cover rounded-lg"
                  onerror="this.src='{{ asset('images/placeholder.png') }}'"
                >
              </div>
            @endif
            <div class="menu-item-content">
              <h3 class="font-medium text-lg">{{ $item->item_name }}</h3>
              <p class="text-gray-600 text-sm my-1">{{ $item->description }}</p>
              <p class="font-bold text-[#ff8903]">{{ $item->price }} DZ</p>
            </div>
          </div>
        @empty
          <p class="text-gray-500 italic text-center">No sweet food items available</p>
        @endforelse
      </div>
    </div>

    <!-- Drinks Section -->
    <div>
      <h2 class="text-xl font-semibold text-center lg:text-left text-gray-800 mb-4">Drinks</h2>
      <div class="space-y-6">
        @forelse($drinks as $item)
          <div class="menu-item flex flex-col items-center text-center p-4 bg-white shadow rounded-lg">
            @if($item->image)
              <div class="w-24 h-24 mb-2">
                <img 
                  src="{{ $item->image ? (str_starts_with($item->image, 'http') ? $item->image : asset($item->image)) : asset('images/placeholder.png') }}" 
                  alt="{{ $item->item_name }}" 
                  class="w-full h-full object-cover rounded-lg"
                  onerror="this.src='{{ asset('images/placeholder.png') }}'"
                >
              </div>
            @endif
            <div class="menu-item-content">
              <h3 class="font-medium text-lg">{{ $item->item_name }}</h3>
              <p class="text-gray-600 text-sm my-1">{{ $item->description }}</p>
              <p class="font-bold text-[#ff8903]">{{ $item->price }} DZ</p>
            </div>
          </div>
        @empty
          <p class="text-gray-500 italic text-center">No drinks available</p>
        @endforelse
      </div>
    </div>
  </div>
</div>

<style>
.menu-item {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.menu-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.menu-item img {
  transition: transform 0.2s ease;
}

.menu-item:hover img {
  transform: scale(1.05);
}
</style>
@endsection


