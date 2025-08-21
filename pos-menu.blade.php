<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($restaurant) ? $restaurant->resturantName : 'Restaurant' }} POS-menu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/pos-menu.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css')}}" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script>
         console.log("Menu page loaded");
        // Store the owner ID in a JavaScript variable for use throughout the page
        const currentOwnerId = "{{ request()->route('owner_id') }}";
    </script>
</head>
<body>
      <!-- Navigation -->
      <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logo%201-jLsRbpqjg5wSsL1uBcxfL4T0BJBEcT.png')}}" alt="MenuSwip Logo" class="logo-img">
            <span class="logo-text">MenuSwip</span>
        </div>
        @if(isset($restaurant))
        <div class="restaurant-info">
            <span class="restaurant-name">{{ $restaurant->name ?? 'Your Restaurant' }}</span>
            <div>
                @if($tableNumber)
                <span class="table-badge">Table: {{ $tableNumber }}</span>
                @endif
                @if($guestCount)
                <span class="guest-badge">Guests: {{ $guestCount }}</span>
                @endif
            </div>
        </div>
        @endif
       </nav>
<h1 class="text-center">📋 Menu</h1>
    
    @if(isset($error))
        <div class="text-center text-red-500 text-xl">
            {{ $error }}
        </div>
    @elseif(isset($menuItems) && $menuItems->isEmpty())
        <div class="text-center text-red-500 text-xl">
            No menu items found. Please add items first.
        </div>
    @elseif(!isset($menuItems))
        <div class="text-center text-red-500 text-xl">
            Error: Menu items could not be loaded. Please contact support.
        </div>
    @else
    <main class="main">
    <div class="container">    
<div class="sidebar">
    
<a href="/pos/{{ request()->route('owner_id') }}/home" class="sidebar-item">
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        HOME
    </a>
    <a href="/pos/{{ request()->route('owner_id') }}/menu" class="sidebar-item active">
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        MENU
    </a>
    <a href="/pos/{{ request()->route('owner_id') }}/orders" class="sidebar-item">
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
        </svg>
        ORDERS
    </a>
</div>

        @if(isset($categories) && $categories->count() > 0)
<div class="category">
    <div class="all-btn">
        <a href="/pos/{{ request()->route('owner_id') }}/menu?table={{ $tableNumber }}&guests={{ $guestCount }}" 
           class="px-4 py-2 rounded-full {{ !request()->has('category') ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
            All
        </a>
        @foreach($categories as $category)
        <a href="/pos/{{ request()->route('owner_id') }}/menu?category={{ $category }}&table={{ $tableNumber }}&guests={{ $guestCount }}" 
           class="px-4 py-2 rounded-full {{ request('category') == $category ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
            {{ $category }}
        </a>
        @endforeach
    </div>
</div>
@endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($menuItems as $item)
                <div class="border rounded-lg p-4 shadow hover:shadow-lg transition">
                    @if($item->image)
                        @php
                            // Handle different image path formats like in your working default menu
                            $imagePath = $item->image;
                            
                            // If the image path contains 'storage/', use it as is with asset()
                            if (str_contains($imagePath, 'storage/')) {
                                $imageUrl = asset($imagePath);
                            }
                            // If it's a full URL, use it directly
                            elseif (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                $imageUrl = $imagePath;
                            }
                            // If it starts with 'images/' or similar, use asset()
                            elseif (str_starts_with($imagePath, 'images/') || str_starts_with($imagePath, 'uploads/')) {
                                $imageUrl = asset($imagePath);
                            }
                            // For other cases, try both storage and direct asset paths
                            else {
                                // First try with storage path
                                if (file_exists(public_path('storage/' . $imagePath))) {
                                    $imageUrl = asset('storage/' . $imagePath);
                                } else {
                                    $imageUrl = asset($imagePath);
                                }
                            }
                        @endphp
                        <img 
                            src="{{ $imageUrl }}" 
                            alt="{{ $item->item_name }}" 
                            class="w-full h-40 object-cover rounded"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="w-full h-40 bg-gray-200 rounded flex items-center justify-center text-gray-500" style="display: none;">
                            <div class="text-center">
                                <i class="fas fa-utensils text-2xl mb-2"></i>
                                <p class="text-sm">Image not available</p>
                            </div>
                        </div>
                    @else
                        <div class="w-full h-40 bg-gray-200 rounded flex items-center justify-center text-gray-500">
                            <div class="text-center">
                                <i class="fas fa-utensils text-2xl mb-2"></i>
                                <p class="text-sm">No image available</p>
                            </div>
                        </div>
                    @endif
                    
                    <h2 class="text-xl font-semibold mt-4">{{ $item->item_name }}</h2>
                    <p class="text-gray-600 mt-2">DZ{{ number_format($item->price, 2) }}</p>
                    @if(isset($item->category_id) && $item->category_id)
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mt-2">
                        Category: {{ $item->category_id }}
                    </span>
                    @endif
                    <div class="mt-4">
                        <button onclick="addToCart({{ $item->id }}, '{{ $item->item_name }}', {{ $item->price }})" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded ">
                            ➕ Add to Cart
                        </button>
                        <button onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->item_name) }}', {{ $item->price }}, '{{ addslashes($item->description ?? '') }}', '{{ $item->category_id ?? '' }}', '{{ addslashes($item->image ?? '') }}')" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded">
                            ✏️ Edit
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            <h2 class="text-2xl font-bold mb-4">🛒 Cart</h2>
            <div id="cart" class="bg-gray-100 p-4 rounded-lg">
                <p class="text-gray-500">Cart is empty.</p>
            </div>
            <div class="mt-6 flex space-x-4">
                <button onclick="confirmOrder()" class="bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded disabled:opacity-50" id="checkoutButton" disabled>
                    ✅ Confirm Order
                </button>
                <button onclick="clearCart()" class="bg-red-600 hover:bg-red-700 text-white py-2 px-6 rounded disabled:opacity-50" id="clearButton" disabled>
                    🗑️ Clear Cart
                </button>
            </div>
        </div>
    @endif
</div>

<!-- Edit Menu Item Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2 class="text-xl font-bold mb-4">Edit Menu Item</h2>
        <form id="editItemForm">
            <input type="hidden" id="edit-item-id">
            
            <div class="form-group">
                <label for="edit-item-name" class="form-label">Item Name</label>
                <input type="text" id="edit-item-name" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="edit-item-price" class="form-label">Price (DZ)</label>
                <input type="number" id="edit-item-price" class="form-input" step="0.01" min="0" required>
            </div>
            
            <div class="form-group">
                <label for="edit-item-description" class="form-label">Description</label>
                <textarea id="edit-item-description" class="form-input" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label for="edit-item-category" class="form-label">Category</label>
                <input type="text" id="edit-item-category" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="edit-item-image" class="form-label">Image URL</label>
                <input type="text" id="edit-item-image" class="form-input">
            </div>
            
            <div class="btn-row">
                <button type="button" onclick="closeEditModal()" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let cart = [];
    const tableNumber = "{{ $tableNumber ?? 'N/A' }}";
    const guestCount = "{{ $guestCount ?? 'N/A' }}";

    function addToCart(id, name, price) {
        const existing = cart.find(item => item.id === id);
        if (existing) {
            existing.quantity += 1;
        } else {
            cart.push({ id, name, price, quantity: 1 });
        }
        renderCart();
    }

    function removeFromCart(id) {
        const index = cart.findIndex(item => item.id === id);
        if (index !== -1) {
            if (cart[index].quantity > 1) {
                cart[index].quantity -= 1;
            } else {
                cart.splice(index, 1);
            }
        }
        renderCart();
    }

    function clearCart() {
        cart = [];
        renderCart();
    }

    function renderCart() {
        const cartDiv = document.getElementById('cart');
        const clearButton = document.getElementById('clearButton');
        
        if (cart.length === 0) {
            cartDiv.innerHTML = '<p class="text-gray-500">Cart is empty.</p>';
            document.getElementById('checkoutButton').disabled = true;
            clearButton.disabled = true;
            return;
        }

        let html = '<ul class="space-y-2">';
        let total = 0;

        cart.forEach(item => {
            total += item.price * item.quantity;
            html += `<li class="flex justify-between items-center">
                        <div class="flex items-center">
                            <button onclick="removeFromCart(${item.id})" class="text-red-500 mr-2">➖</button>
                            <span>${item.name} x${item.quantity}</span>
                        </div>
                        <span>DZ${(item.price * item.quantity).toFixed(2)}</span>
                    </li>`;
        });

        html += `</ul><div class="mt-4 font-bold text-xl">Total: DZ${total.toFixed(2)}</div>`;
        cartDiv.innerHTML = html;
        document.getElementById('checkoutButton').disabled = false;
        clearButton.disabled = false;
    }

    function confirmOrder() {
        fetch(`/pos/${currentOwnerId}/confirm-order`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ 
                cart: cart,
                table: tableNumber,
                guests: guestCount
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`✅ Order placed successfully! Order #${data.order_number}`);
                cart = [];
                renderCart();
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            alert('Error placing order: ' + error);
        });
    }
        // Edit Menu Item Functions
        function openEditModal(id, name, price, description, category, image) {
        document.getElementById('edit-item-id').value = id;
        document.getElementById('edit-item-name').value = name;
        document.getElementById('edit-item-price').value = price;
        document.getElementById('edit-item-description').value = description;
        document.getElementById('edit-item-category').value = category;
        document.getElementById('edit-item-image').value = image;
        
        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target == modal) {
            closeEditModal();
        }
    }

    // Handle form submission
    document.getElementById('editItemForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const itemId = document.getElementById('edit-item-id').value;
        const itemData = {
            item_name: document.getElementById('edit-item-name').value,
            price: document.getElementById('edit-item-price').value,
            description: document.getElementById('edit-item-description').value,
            category_id: document.getElementById('edit-item-category').value,
            image: document.getElementById('edit-item-image').value
        };
        
        updateMenuItem(itemId, itemData);
    });

    function updateMenuItem(itemId, itemData) {
        fetch(`/pos/${currentOwnerId}/menu/${itemId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(itemData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Menu item updated successfully!');
                closeEditModal();
                // Reload the page to show the updated item
                window.location.reload();
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            alert('Error updating menu item: ' + error);
        });
    }
</script>
<!--footer section-->

<footer class="footer">
    <div class="footer__container">
        <!-- Left Column -->
        <div class="footer__brand">
            <div class="footer__logo">
                <img src="{{ asset('images/logo 1.png')}}" alt="MenuSwip Logo" class="footer__logo-img">
                <span class="footer__logo-text">MenuSwip</span>
            </div>
            <p class="footer__tagline">
                Join MenuSwip today and provide your customers with a seamless digital experience. 
                It's fast, easy, and cost-effective.
            </p>
            <div class="footer__social">
                <a href="#" class="footer__social-link">
                   <i class="fa-brands fa-facebook-f" style="color: #000000;"></i>
                </a>
                <a href="#" class="footer__social-link">
                    <i class="fa-brands fa-twitter" style="color: #000000;"></i>
                </a>
                <a href="#" class="footer__social-link">
                    <i class="fa-brands fa-instagram" style="color: #000000;"></i>
                </a>
                <a href="#" class="footer__social-link">
                    <i class="fa-brands fa-linkedin-in" style="color: #000000;"></i>
                </a>
            </div>
        </div>

        <!-- Middle Column -->
        <div class="footer__links">
            <h3 class="footer__heading">User Link</h3>
            <nav class="footer__nav">
                <a href="#" class="footer__nav-link">About Us</a>
                <a href="#" class="footer__nav-link">Contact Us</a>
                <a href="#" class="footer__nav-link">Order Delivery</a>
                <a href="#" class="footer__nav-link">Payment & Tax</a>
                <a href="#" class="footer__nav-link">Terms of Services</a>
            </nav>
        </div>

        <!-- Right Column -->
        <div class="footer__contact">
            <h3 class="footer__heading">Contact Us</h3>
            <address class="footer__address">
                DZ, BBA, 19088, 36.0923, 5.6833, Peoples Democratic<br>
                Republic of Algeria<br>
                +213 00-00-00-00
            </address>
            <div class="footer__subscribe">
                <input type="email" placeholder="Email" class="footer__input">
                <button class="footer__subscribe-btn">Subscribe</button>
            </div>
        </div>
    </div>

    <!-- Fine line divider -->

    <div class="footer__divider"></div>

    <!-- Bottom Bar -->
    <div class="footer__bottom">
        <div class="footer__container">
            <p class="footer__copyright">©2025 , All right reserved</p>
            
        </div>
       
    </div>
    <div class="footer__policies">
        <a href="#" class="footer__policy-link">Privacy Policy</a>
        <a href="#" class="footer__policy-link">Terms of Use</a>
    </div>
</footer>
</main>
</body>
</html>
