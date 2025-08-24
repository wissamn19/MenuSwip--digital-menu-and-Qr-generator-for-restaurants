<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($restaurant) ? $restaurant->resturantName : 'Restaurant' }} - POS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/pos-home.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css')}}" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
<body>
    <!-- Debug information -->
    <div class="debug-info">
        <strong>Debug:</strong> 
        Owner ID from route: {{ request()->route('owner_id') ?? 'Not available' }}
    </div>
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if(isset($error))
    <div class="alert alert-danger">{{ $error }}</div>
@endif
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logo%201-jLsRbpqjg5wSsL1uBcxfL4T0BJBEcT.png')}}" alt="MenuSwip Logo" class="logo-img">
            <span class="logo-text">MenuSwip</span>
        </div>
        @if(isset($restaurant))
        <div class="restaurant-info">
            <span class="restaurant-name">{{ $restaurant->name ?? 'Your Restaurant' }}</span>
            <span class="restaurant-id">ID: {{ $restaurant->id ?? Auth::owner()->restaurant_id }}</span>
        </div>
        @endif
    </nav>

    <main class="main">
        <div class="container">
            <div class="sidebar">
                <a href="/pos/{{ request()->route('owner_id') }}/home" class="sidebar-item active">
                    <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    HOME
                </a>

                <a href="/pos/{{ request()->route('owner_id') }}/menu" class="sidebar-item">
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
    
            <div class="main-content">
                <div class="header">
                    <div class="header-right">
                        <div class="date-display">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor" style="width: 20px; height: 20px; display: inline-block; margin-right: 5px; vertical-align: text-bottom;">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            {{ date('F jS Y, g:i A') }}
                        </div>
                    </div>
                </div>
    
                <div class="content">
                    <div class="content-area">
                        <div class="page-title">TABLE LIST</div>
                        
                        @if(isset($tablesByFloor) && $tablesByFloor->count() > 0)
                            <div class="tabs">
                                @foreach($tablesByFloor as $floor => $tables)
                                    <div class="tab {{ $loop->first ? 'active' : '' }}" data-floor="{{ $floor }}">{{ $floor }}</div>
                                @endforeach
                            </div>
                            
                            @foreach($tablesByFloor as $floor => $tables)
                                <div class="table-grid {{ $loop->first ? 'active' : 'hidden' }}" data-floor="{{ $floor }}">
                                    @foreach($tables as $table)
                                        <div class="table-item {{ $loop->first && $loop->parent->first ? 'active' : '' }}" 
                                             data-table="{{ $table['table_number'] }}"
                                             data-capacity="{{ $table['capacity'] }}">
                                            <svg class="table-svg" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="100" cy="100" r="70" stroke="currentColor" stroke-width="2" fill="transparent"/>
                                                <path d="M30 30 L70 70" stroke="currentColor" stroke-width="2"/>
                                                <path d="M170 30 L130 70" stroke="currentColor" stroke-width="2"/>
                                                <path d="M30 170 L70 130" stroke="currentColor" stroke-width="2"/>
                                                <path d="M170 170 L130 130" stroke="currentColor" stroke-width="2"/>
                                                <rect x="35" y="35" width="20" height="20" rx="2" stroke="currentColor" stroke-width="2" fill="transparent"/>
                                                <rect x="145" y="35" width="20" height="20" rx="2" stroke="currentColor" stroke-width="2" fill="transparent"/>
                                                <rect x="35" y="145" width="20" height="20" rx="2" stroke="currentColor" stroke-width="2" fill="transparent"/>
                                                <rect x="145" y="145" width="20" height="20" rx="2" stroke="currentColor" stroke-width="2" fill="transparent"/>
                                            </svg>
                                            <div class="table-number">T{{ $table['table_number'] }}</div>
                                            <div class="table-capacity">{{ $table['capacity'] }} seats</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @else
                            <div class="table-grid">
                                @for ($i = 1; $i <= 6; $i++)
                                <div class="table-item {{ $i == 1 ? 'active' : '' }}" data-table="{{ $i }}" data-capacity="4">
                                    <svg class="table-svg" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="100" cy="100" r="70" stroke="currentColor" stroke-width="2" fill="transparent"/>
                                        <path d="M30 30 L70 70" stroke="currentColor" stroke-width="2"/>
                                        <path d="M170 30 L130 70" stroke="currentColor" stroke-width="2"/>
                                        <path d="M30 170 L70 130" stroke="currentColor" stroke-width="2"/>
                                        <path d="M170 170 L130 130" stroke="currentColor" stroke-width="2"/>
                                        <rect x="35" y="35" width="20" height="20" rx="2" stroke="currentColor" stroke-width="2" fill="transparent"/>
                                        <rect x="145" y="35" width="20" height="20" rx="2" stroke="currentColor" stroke-width="2" fill="transparent"/>
                                        <rect x="35" y="145" width="20" height="20" rx="2" stroke="currentColor" stroke-width="2" fill="transparent"/>
                                        <rect x="145" y="145" width="20" height="20" rx="2" stroke="currentColor" stroke-width="2" fill="transparent"/>
                                    </svg>
                                    <div class="table-number">T{{ $i }}</div>
                                    <div class="table-capacity">4 seats</div>
                                </div>
                                @endfor
                            </div>
                        @endif
                        
                        <div class="bottom-bar">
                            <div class="table-info">
                                <div style="margin-bottom: 5px;">
                                    <span class="info-label">TABLE:</span>
                                    <span class="info-value" id="selected-table">1</span>
                                </div>
                                <div class="guest-control">
                                    <span class="info-label">GUESTS:</span>
                                    <button id="decrease-guests" class="guest-btn">-</button>
                                    <span class="info-value" id="guest-count">2</span>
                                    <button id="increase-guests" class="guest-btn">+</button>
                                </div>
                            </div>
                            <a href="{{ route('pos.menu', ['owner_id' => $owner_id]) }}" class="btn" id="continue-btn">SELECT AND CONTINUE</a>

                        </div>
                    </div>
    
                    <div class="order-sidebar">
                        <div class="empty-order">
                            <div class="empty-icon">🍽️</div>
                            <div style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">NO PRODUCTS IN THIS MOMENT ADDED</div>
                            <div>Select a table to start ordering</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tableItems = document.querySelectorAll('.table-item');
                const selectedTableEl = document.getElementById('selected-table');
                const guestCountEl = document.getElementById('guest-count');
                const continueBtn = document.getElementById('continue-btn');
                const decreaseGuestsBtn = document.getElementById('decrease-guests');
                const increaseGuestsBtn = document.getElementById('increase-guests');
                const tabs = document.querySelectorAll('.tab');
                const tableGrids = document.querySelectorAll('.table-grid');
                
                // Handle floor tabs
                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        // Remove active class from all tabs
                        tabs.forEach(t => t.classList.remove('active'));
                        
                        // Add active class to clicked tab
                        this.classList.add('active');
                        
                        // Hide all table grids
                        tableGrids.forEach(grid => {
                            grid.classList.add('hidden');
                            grid.classList.remove('active');
                        });
                        
                        // Show the corresponding table grid
                        const floor = this.getAttribute('data-floor');
                        const targetGrid = document.querySelector(`.table-grid[data-floor="${floor}"]`);
                        if (targetGrid) {
                            targetGrid.classList.remove('hidden');
                            targetGrid.classList.add('active');
                        }
                    });
                });
                
                // Handle table selection
                tableItems.forEach(item => {
                    item.addEventListener('click', function() {
                        // Remove active class from all tables
                        tableItems.forEach(t => t.classList.remove('active'));
                        
                        // Add active class to clicked table
                        this.classList.add('active');
                        
                        // Update selected table display
                        const tableNumber = this.getAttribute('data-table');
                        selectedTableEl.textContent = tableNumber;
                        
                        // Update guest count based on table capacity
                        const capacity = parseInt(this.getAttribute('data-capacity') || 4);
                        guestCountEl.textContent = Math.min(capacity, 2); // Default to 2 or max capacity
                    });
                });
                
                // Handle guest count adjustment
                decreaseGuestsBtn.addEventListener('click', function() {
                    let count = parseInt(guestCountEl.textContent);
                    if (count > 1) {
                        guestCountEl.textContent = count - 1;
                    }
                });
                
                increaseGuestsBtn.addEventListener('click', function() {
                    let count = parseInt(guestCountEl.textContent);
                    const activeTable = document.querySelector('.table-item.active');
                    const capacity = activeTable ? parseInt(activeTable.getAttribute('data-capacity') || 4) : 4;
                    
                    if (count < capacity) {
                        guestCountEl.textContent = count + 1;
                    }
                });
                
                // Handle continue button
                continueBtn.addEventListener('click', function() {
                    const tableNumber = selectedTableEl.textContent;
                    const guestCount = guestCountEl.textContent;
                    const ownerId = "{{ request()->route('owner_id') }}";
                    
                    // Use hardcoded URL instead of route helper
                    window.location.href = `/pos/${ownerId}/menu?table=${tableNumber}&guests=${guestCount}`;
                });
            });
        </script>


<!--footer section-->

<footer class="footer">
    <div class="footer__container">
        <!-- Left Column -->
        <div class="footer__brand">
            <div class="footer__logo">
                <img src="{{ asset('images\logo 1.png')}}" alt="MenuSwip Logo" class="footer__logo-img">
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
                         
</body>
</html>