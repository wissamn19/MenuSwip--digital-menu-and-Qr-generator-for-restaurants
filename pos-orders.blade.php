<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($restaurant) ? $restaurant->resturantName : 'Restaurant' }} - POS Orders</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/pos-orders.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
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
    <span class="restaurant-name">{{ $restaurant->resturantName ?? 'Your Restaurant' }}</span>
    <span class="restaurant-id">ID: {{ $restaurant->id ?? Auth::owner()->restaurant_id }}</span>

    </div>
@else
    <div class="restaurant-info">
        <span class="restaurant-name">Restaurant Not Found</span>
    </div>
@endif

        
    </nav>
     <main class="main">
        <div class="container">
            <div class="sidebar">
                <a href="/pos/{{ request()->route('owner_id') }}/home" class="sidebar-item">
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
                <a href="/pos/{{ request()->route('owner_id') }}/orders" class="sidebar-item active">
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
    
                <div class="content-area">
                    <div class="page-title">Today's Orders</div>
                    
                    <div class="order-filters">
                        <button class="filter-btn active" data-filter="all">All Orders</button>
                        <button class="filter-btn" data-filter="pending">Pending</button>
                        <button class="filter-btn" data-filter="completed">Completed</button>
                        <button class="filter-btn" data-filter="cancelled">Cancelled</button>
                    </div>
                    
                    @if(isset($todayOrders) && $todayOrders->count() > 0)
                        <div class="order-grid">
                            @foreach($todayOrders as $order)
                                <div class="order-card" data-status="{{ $order->status }}">
                                    <div class="order-header">
                                        <div class="order-number">Order #{{ $order->id }}</div>
                                        <div class="order-status status-{{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </div>
                                    </div>
                                    
                                    <div class="order-body">
                                        <div class="order-info">
                                            <div class="info-row">
                                                <div class="info-label">Time:</div>
                                                <div class="info-value">{{ $order->created_at->format('g:i A') }}</div>
                                            </div>
                                            
                                            @php
                                            
                                     $tableInfo = $order->table_info;
                                       

                                            @endphp
                                            
                                            @if($tableInfo)
                                                @if(isset($tableInfo['table']))
                                                    <div class="info-row">
                                                        <div class="info-label">Table:</div>
                                                        <div class="info-value">{{ $tableInfo['table'] }}</div>
                                                    </div>
                                                @endif
                                                @if(isset($tableInfo['guests']))
                                                    <div class="info-row">
                                                        <div class="info-label">Guests:</div>
                                                        <div class="info-value">{{ $tableInfo['guests'] }}</div>
                                                    </div>
                                                @endif
                                            @endif

                                            <div class="order-status-toggle">
    <div class="status-indicator {{ $orderStatus === 'on' ? 'status-on' : 'status-off' }}">
        <span class="status-label">Orders:</span>
        <span class="status-value">{{ $orderStatus === 'on' ? 'ON' : 'OFF' }}</span>
    </div>
    <button class="toggle-order-status-btn toggle-btn {{ $orderStatus === 'on' ? 'toggle-off' : 'toggle-on' }}" data-owner-id="{{ $owner_id }}">
        {{ $orderStatus === 'on' ? 'Turn OFF' : 'Turn ON' }}
    </button>
</div>
                                        </div>
                                        
                                        <div class="order-items">
                                            @foreach($order->orderItems as $item)
                                                <div class="item-row">
                                                    <div class="item-name">
                                                        <div class="item-quantity">{{ $item->quantity }}</div>
                                                        {{ $item->menuItem->item_name }}
                                                    </div>
                                                    <div class="item-price">DZ{{ number_format($item->price, 2) }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="order-total">
                                            <div>Total:</div>
                                            <div>DZ{{ number_format($order->total_price, 2) }}</div>
                                        </div>
                                    </div>
                                    
                                    @if($order->status == 'pending')
                                        <div class="order-actions">
                                            <div class="action-btn btn-complete" onclick="updateOrderStatus({{ $order->id }}, 'completed')">
                                                Complete
                                            </div>
                                            <div class="action-btn btn-cancel" onclick="updateOrderStatus({{ $order->id }}, 'cancelled')">
                                                Cancel
                                            </div>
                                            <div class="action-btn btn-print" onclick="printReceipt({{ $order->id }})">
                                                Print
                                            </div>
                                        </div>
                                    @else
                                        <div class="order-actions">
                                            <div class="action-btn btn-print" onclick="printReceipt({{ $order->id }})">
                                                Print Receipt
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">📋</div>
                            <div class="empty-title">No orders found for today</div>
                            <div class="empty-text">Orders will appear here once customers place them</div>
                        </div>
                    @endif
                </div>
            </div>
    
        </div>
     
<div id="receiptModal" class="receipt-modal">
    <div class="receipt-modal-content">
        <span class="receipt-modal-close">&times;</span>
        <div class="receipt" id="receiptContent">
            <!-- Receipt content will be loaded here -->
        </div>
    </div>
</div>

<!-- Receipt Template (hidden) -->
<template id="receiptTemplate" hidden>
    <div class="receipt-header">
        <div class="logo">
            <img src="{{ asset('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logo%201-jLsRbpqjg5wSsL1uBcxfL4T0BJBEcT.png')}}" alt="MenuSwip Logo">
        </div>
        <h1 class="restaurant-name">__RESTAURANT_NAME__</h1>
        <p class="restaurant-address">__RESTAURANT_ADDRESS__</p>
        <p class="restaurant-contact">__RESTAURANT_PHONE__</p>
    </div>

    <div class="receipt-info">
        <div class="info-row">
            <span class="label">Receipt #:</span>
            <span class="value">__ORDER_ID__</span>
        </div>
        <div class="info-row">
            <span class="label">Date:</span>
            <span class="value">__ORDER_DATE__</span>
        </div>
        <div class="info-row table-info">
            <span class="label">Table:</span>
            <span class="value">__TABLE_NUMBER__</span>
        </div>
        <div class="info-row guests-info">
            <span class="label">Guests:</span>
            <span class="value">__GUEST_COUNT__</span>
        </div>
    </div>

    <div class="receipt-divider"></div>

    <div class="receipt-items">
        <div class="item-header">
            <span class="item-qty">Qty</span>
            <span class="item-name">Item</span>
            <span class="item-price">Price</span>
        </div>
        <div id="receiptItemsList">
            <!-- Items will be inserted here -->
        </div>
    </div>

    <div class="receipt-divider"></div>

    <div class="receipt-totals">
        <div class="total-row">
            <span class="total-label">Subtotal:</span>
            <span class="total-value">__SUBTOTAL__</span>
        </div>
        <div class="total-row">
            <span class="total-label">Tax (10%):</span>
            <span class="total-value">__TAX_AMOUNT__</span>
        </div>
        <div class="total-row grand-total">
            <span class="total-label">Total:</span>
            <span class="total-value">__GRAND_TOTAL__</span>
        </div>
    </div>

    <div class="receipt-footer">
        <p class="thank-you">Thank you for dining with us!</p>
        <p class="receipt-id">Order ID: __ORDER_ID__</p>
        <p class="receipt-status">Status: __ORDER_STATUS__</p>
        
        <div class="barcode">
            <div class="barcode-line"></div>
            <div class="barcode-number">__BARCODE_NUMBER__</div>
        </div>
        
        <p class="powered-by">Powered by MenuSwip</p>
    </div>
    
    <div class="print-controls">
        <button onclick="printReceipt()" class="print-button">Print Receipt</button>
        <button onclick="closeReceiptModal()" class="close-button">Close</button>
    </div>
</template>

<!-- Receipt Overlay -->
<div id="receiptOverlay" class="receipt-overlay">
    <div class="receipt-container">
        <div class="receipt-header-controls">
            <button id="closeReceiptBtn" class="close-receipt-btn">&times;</button>
        </div>
        <div id="receiptContent" class="receipt">
            <div class="header">
                <h1 class="restaurant-name">{{$restaurant->resturantName ?? 'Restaurant Name' }}</h1>
                <p>{{ $restaurant->location ?? 'Restaurant Address' }}</p>
                
            </div>
            
            <div class="info">
                <div class="info-row">
                    <span>Receipt #:</span>
                    <span id="receipt-order-id"></span>
                </div>
                <div class="info-row">
                    <span>Date:</span>
                    <span id="receipt-date"></span>
                </div>
                <div class="info-row" id="receipt-table-row">
                    <span>Table:</span>
                    <span id="receipt-table"></span>
                </div>
                <div class="info-row" id="receipt-guests-row">
                    <span>Guests:</span>
                    <span id="receipt-guests"></span>
                </div>
            </div>
            
            <div class="divider"></div>
            
            <div class="items">
                <div class="item-header">
                    <span class="item-qty">Qty</span>
                    <span class="item-name">Item</span>
                    <span class="item-price">Price</span>
                </div>
                
                <div id="receipt-items-list">
                    <!-- Items will be populated here -->
                </div>
            </div>
            
            <div class="divider"></div>
            
            <div class="totals">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span id="receipt-subtotal"></span>
                </div>
                <div class="total-row">
                    <span>Tax (10%):</span>
                    <span id="receipt-tax"></span>
                </div>
                <div class="total-row grand-total">
                    <span>Total:</span>
                    <span id="receipt-total"></span>
                </div>
            </div>
            
            <div class="footer">
                <p class="thank-you">Thank you for dining with us!</p>
                <p>Order Status: <span id="receipt-status"></span></p>
                <p>Powered by MenuSwip</p>
            </div>
        </div>
        
        <div class="receipt-actions">
            <button id="printReceiptBtn" class="print-receipt-btn">Print Receipt</button>
        </div>
    </div>
</div>

<script>
       document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const orderCards = document.querySelectorAll('.order-card');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                
                // Show/hide cards based on filter
                orderCards.forEach(card => {
                    if (filter === 'all') {
                        card.style.display = 'block';
                    } else {
                        const status = card.getAttribute('data-status');
                        card.style.display = status === filter ? 'block' : 'none';
                    }
                });
            });
        });
        
        // Set up receipt modal functionality
        setupReceiptModal();
    });
    
    function updateOrderStatus(orderId, status) {
        if (!confirm(`Are you sure you want to mark this order as ${status}?`)) {
            return;
        }
        
        fetch(`/pos/${currentOwnerId}/orders/${orderId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Order status updated successfully');
                window.location.reload();
            } else {
                alert('Error updating order status: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error updating order status: ' + error);
        });
    }
    
    // Original printReceipt function - opens in new window
    function printReceipt(orderId) {
       
        // Print automatically when loaded
        receiptWindow.onload = function() {
            receiptWindow.print();
        };
    }
    
    // Setup receipt modal functionality
    function setupReceiptModal() {
        // Get all print buttons in order cards
        const printButtons = document.querySelectorAll('.btn-print');
        
        // Add click event listener to each print button
        printButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                // Prevent the default action (which would trigger the original printReceipt function)
                e.stopPropagation();
                
                // Get the order ID from the closest order card
                const orderCard = this.closest('.order-card');
                if (orderCard) {
                    const orderNumber = orderCard.querySelector('.order-number').textContent.replace('Order #', '').trim();
                    showReceipt(orderNumber, orderCard);
                }
                
                return false;
            });
        });
        
        // Get the receipt modal elements
        const receiptModal = document.getElementById('receiptModal');
        const closeBtn = document.querySelector('.receipt-modal-close');
        const printBtn = document.getElementById('printReceiptBtn');
        const closeBtnBottom = document.getElementById('closeReceiptBtn');
        
        // Add event listener to close button
        if (closeBtn) {
            closeBtn.addEventListener('click', closeReceiptModal);
        }
        
        // Add event listener to print button
        if (printBtn) {
            printBtn.addEventListener('click', printReceiptContent);
        }
        
        // Add event listener to bottom close button
        if (closeBtnBottom) {
            closeBtnBottom.addEventListener('click', closeReceiptModal);
        }
        
        // Close modal when clicking outside the receipt
        if (receiptModal) {
            receiptModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeReceiptModal();
                }
            });
        }
    }
    
    // Function to show receipt for an order
    function showReceipt(orderId, orderCard) {
        if (!orderCard) {
            // Find the order card if not provided
            const allOrderCards = document.querySelectorAll('.order-card');
            allOrderCards.forEach(card => {
                const orderNumber = card.querySelector('.order-number');
                if (orderNumber && orderNumber.textContent.includes(`Order #${orderId}`)) {
                    orderCard = card;
                }
            });
            
            if (!orderCard) {
                console.error('Order card not found');
                return;
            }
        }
        
        // Get basic order info
        const orderStatus = orderCard.querySelector('.order-status').textContent.trim();
        const orderTime = orderCard.querySelector('.info-row:nth-child(1) .info-value').textContent.trim();
        
        // Get table and guests info if available
        let tableNumber = 'N/A';
        let guestCount = 'N/A';
        
        const tableRow = orderCard.querySelector('.info-row:nth-child(2)');
        if (tableRow && tableRow.querySelector('.info-label').textContent.includes('Table')) {
            tableNumber = tableRow.querySelector('.info-value').textContent.trim();
        }
        
        const guestRow = orderCard.querySelector('.info-row:nth-child(3)');
        if (guestRow && guestRow.querySelector('.info-label').textContent.includes('Guests')) {
            guestCount = guestRow.querySelector('.info-value').textContent.trim();
        }
        
        // Get order items
        const itemRows = orderCard.querySelectorAll('.item-row');
        const orderTotal = orderCard.querySelector('.order-total div:last-child').textContent.trim();
        
        // Calculate totals
        const subtotal = parseFloat(orderTotal.replace('DZ', ''));
        const taxRate = 0.10; // 10% tax
        const taxAmount = subtotal * taxRate;
        const grandTotal = subtotal + taxAmount;
        
        // Populate receipt
        document.getElementById('receipt-order-id').textContent = orderId;
        document.getElementById('receipt-date').textContent = orderTime;
        document.getElementById('receipt-status').textContent = orderStatus;
        
        // Handle table and guests info
        if (tableNumber !== 'N/A') {
            document.getElementById('receipt-table').textContent = tableNumber;
            document.getElementById('receipt-table-row').style.display = 'flex';
        } else {
            document.getElementById('receipt-table-row').style.display = 'none';
        }
        
        if (guestCount !== 'N/A') {
            document.getElementById('receipt-guests').textContent = guestCount;
            document.getElementById('receipt-guests-row').style.display = 'flex';
        } else {
            document.getElementById('receipt-guests-row').style.display = 'none';
        }
        
        // Populate items
        const itemsList = document.getElementById('receipt-items-list');
        itemsList.innerHTML = '';
        
        itemRows.forEach(row => {
            const itemNameElement = row.querySelector('.item-name');
            const itemQuantityElement = row.querySelector('.item-quantity');
            const itemPriceElement = row.querySelector('.item-price');
            
            if (itemNameElement && itemQuantityElement && itemPriceElement) {
                const itemName = itemNameElement.textContent.replace(itemQuantityElement.textContent, '').trim();
                const itemQuantity = itemQuantityElement.textContent.trim();
                const itemPrice = itemPriceElement.textContent.trim();
                
                const itemRow = document.createElement('div');
                itemRow.className = 'item-row';
                itemRow.innerHTML = `
                    <span class="item-qty">${itemQuantity}</span>
                    <span class="item-name">${itemName}</span>
                    <span class="item-price">${itemPrice}</span>
                `;
                
                itemsList.appendChild(itemRow);
            }
        });
        
        // Set totals
        document.getElementById('receipt-subtotal').textContent = 'DZ' + subtotal.toFixed(2);
        document.getElementById('receipt-tax').textContent = 'DZ' + taxAmount.toFixed(2);
        document.getElementById('receipt-total').textContent = 'DZ' + grandTotal.toFixed(2);
        
        // Show receipt modal
        document.getElementById('receiptOverlay').style.display = 'flex';
    }
    
    // Function to close receipt modal
    function closeReceiptModal() {
        document.getElementById('receiptOverlay').style.display = 'none';
    }
    
    // Function to print receipt content
    function printReceiptContent() {
        window.print();
    }
    </script>
       

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Filter functionality
                const filterButtons = document.querySelectorAll('.filter-btn');
                const orderCards = document.querySelectorAll('.order-card');
                
                filterButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Remove active class from all buttons
                        filterButtons.forEach(btn => btn.classList.remove('active'));
                        
                        // Add active class to clicked button
                        this.classList.add('active');
                        
                        const filter = this.getAttribute('data-filter');
                        
                        // Show/hide cards based on filter
                        orderCards.forEach(card => {
                            if (filter === 'all') {
                                card.style.display = 'block';
                            } else {
                                const status = card.getAttribute('data-status');
                                card.style.display = status === filter ? 'block' : 'none';
                            }
                        });
                    });
                });
            });
           // Add event listener for ALL order status toggle buttons using class instead of ID
        const toggleBtns = document.querySelectorAll('.toggle-order-status-btn');
        toggleBtns.forEach(btn => {
            btn.addEventListener('click', toggleOrderStatus);
        });
        
        // Filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const orderCards = document.querySelectorAll('.order-card');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                
                // Show/hide cards based on filter
                orderCards.forEach(card => {
                    if (filter === 'all') {
                        card.style.display = 'block';
                    } else {
                        const status = card.getAttribute('data-status');
                        card.style.display = status === filter ? 'block' : 'none';
                    }
                });
            });
        });
        
        
            
            function updateOrderStatus(orderId, status) {
                if (!confirm(`Are you sure you want to mark this order as ${status}?`)) {
                    return;
                }
                
                fetch(`/pos/${currentOwnerId}/orders/${orderId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Order status updated successfully');
                        window.location.reload();
                    } else {
                        alert('Error updating order status: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error updating order status: ' + error);
                });
            }

            function toggleOrderStatus(event) {
        // Get the button that was clicked
        const toggleBtn = event.currentTarget;
        
        // Get the current status from the button's class
        const currentStatus = toggleBtn.classList.contains('toggle-off') ? 'on' : 'off';
        const newStatus = currentStatus === 'on' ? 'off' : 'on';
        
        console.log('Toggling order status from', currentStatus, 'to', newStatus);
        
        if (!confirm(`Are you sure you want to turn ${newStatus.toUpperCase()} orders?`)) {
            return;
        }
        
        // Show loading state
        toggleBtn.disabled = true;
        toggleBtn.textContent = 'Processing...';
        
        // Get the owner ID from the data attribute
        const ownerId = toggleBtn.getAttribute('data-owner-id') || currentOwnerId;
        
        fetch(`/pos/${ownerId}/order-status/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(`Orders have been turned ${newStatus.toUpperCase()}`);
                window.location.reload();
            } else {
                alert('Error updating order status: ' + (data.message || 'Unknown error'));
                toggleBtn.disabled = false;
                toggleBtn.textContent = currentStatus === 'on' ? 'Turn OFF' : 'Turn ON';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating order status: ' + error.message);
            toggleBtn.disabled = false;
            toggleBtn.textContent = currentStatus === 'on' ? 'Turn OFF' : 'Turn ON';
        });
    }
            
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

