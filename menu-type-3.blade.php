<!DOCTYPE html>
<main lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>create your menu</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/menu-type-3.css')}}">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css')}}" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logo%201-jLsRbpqjg5wSsL1uBcxfL4T0BJBEcT.png')}}" alt="MenuSwip Logo" class="logo-img">
            <span class="logo-text">MenuSwip</span>
        </div>

       </nav>

       <main class="main">
        <div class="container">
            <!-- Title -->
            <div class="drinks-title">Drinks</div>

            <!-- Form for drink items -->
            
            <form action="{{ route('menu.storeType3', ['restaurant' => $restaurant_id]) }}" method="POST" enctype="multipart/form-data" id="drink-items-form">
               
                @csrf
            <input type="hidden" name="restaurant_id" value="{{ $restaurant_id }}">
            
                <!-- Drink cards container -->
                <div id="drink-cards-container">
                    <!-- Initial drink card -->
                    <div class="drink-card" data-index="0">
                    <div class="image-upload">
        <input type="file" name="image[0]" class="file-input" accept="image/*" style="display: none;">
        <div class="upload-area">
            <i class="fas fa-plus"></i>
            <p class="upload-text">Add image</p>
        </div>
    </div>
    
    <div class="drink-details">
        <div class="form-group">
            <label>Add drink name</label>
            <input type="text" name="item_name[0]" class="input-field" required>
        </div>
        
        <div class="form-group">
            <label>Add a description</label>
            <textarea name="description[0]" class="textarea-field"></textarea>
        </div>
        
        <div class="price-section">
            <label>Add price</label>
            <input type="text" name="price[0]" class="input-field" required>
        </div>
    </div>
</div>
                <!-- Add Card Button -->
                <div class="add-card-container">
                    <button type="button" id="add-card-btn" class="btn btn-add">
                        <i class="fas fa-plus"></i> Add Another Drink
                    </button>
                </div>
                
       <!-- Navigation Buttons -->
                <div class="navigation-container">
                <a href="{{ route('menu.type2', ['restaurant' => $restaurant_id]) }}" class="btn btn-back">Back to sweety food </a>
                <button type="submit" class="btn btn-next"> Save and get your  QR code</button>
                
                </div>
            </form>
        </div>
    </main>

   <!-- Drink Card Template (hidden) -->
<template id="drink-card-template">
    <div class="drink-card" data-index="{index}">
        <div class="image-upload">
            <input type="file" name="image[{index}]" class="file-input" accept="image/*" style="display: none;">
            <div class="upload-area">
                <i class="fas fa-plus"></i>
                <p class="upload-text">Add image</p>
            </div>
        </div>
        
        <div class="drink-details">
            <div class="form-group">
                <label>Add drink name</label>
                <input type="text" name="item_name[{index}]" class="input-field" required>
            </div>
            
            <div class="form-group">
                <label>Add a description</label>
                <textarea name="description[{index}]" class="textarea-field"></textarea>
            </div>
            
            <div class="price-section">
                <label>Add price</label>
                <input type="text" name="price[{index}]" class="input-field" required>
            </div>
        </div>
        
        <!-- Remove Card Button -->
        <button type="button" class="remove-card-btn">
            <i class="fas fa-times"></i>
        </button>
      </div>
      </template>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    // Initialize the first card
    initializeCard(document.querySelector('.drink-card'));
    
    // Add Card Button
    const addCardBtn = document.getElementById('add-card-btn');
    addCardBtn.addEventListener('click', addNewCard);
    
    // Function to add a new card
    function addNewCard() {
        // Get the current number of cards
        const cardsContainer = document.getElementById('drink-cards-container');
        const cardCount = cardsContainer.querySelectorAll('.drink-card').length;
        
        // Create a new card element based on the first one
        const firstCard = document.querySelector('.drink-card');
        const newCard = firstCard.cloneNode(true);
        newCard.dataset.index = cardCount;
        
        // Clear input values in the new card
        newCard.querySelectorAll('input[type="text"], textarea').forEach(input => {
            input.value = '';
        });
        
        // Reset image upload area
        const uploadArea = newCard.querySelector('.upload-area');
        uploadArea.innerHTML = `
            <i class="fas fa-plus"></i>
            <p class="upload-text">Add image</p>
        `;
        
        // Add remove button to the new card
        if (!newCard.querySelector('.remove-card-btn')) {
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-card-btn';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            newCard.appendChild(removeBtn);
        }
        
        // Add the new card to the container
        cardsContainer.appendChild(newCard);
        
        // Initialize the new card
        initializeCard(newCard);
        
        // Scroll to the new card
        newCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    
    // Function to initialize a card
    function initializeCard(card) {
        // Get elements
        const fileInput = card.querySelector('.file-input');
        const uploadArea = card.querySelector('.upload-area');
        
        // Make upload area clickable
        uploadArea.addEventListener('click', function() {
            fileInput.click();
        });
        
        // Handle file selection
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                
                // Check file type
                if (!file.type.match('image.*')) {
                    showNotification('Please select an image file', 'error');
                    return;
                }
                
                // Check file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showNotification('Image size should be less than 5MB', 'error');
                    return;
                }
                
                // Create image preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Clear the upload area
                    uploadArea.innerHTML = '';
                    
                    // Create and append the image
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '12px';
                    uploadArea.appendChild(img);
                    
                    // Add remove image button if it doesn't exist
                    if (!card.querySelector('.remove-image-btn')) {
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'remove-image-btn';
                        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                        
                        card.querySelector('.image-upload').appendChild(removeBtn);
                        
                        // Handle remove button click
                        removeBtn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            
                            // Clear the file input
                            fileInput.value = '';
                            
                            // Reset the upload area
                            uploadArea.innerHTML = `
                                <i class="fas fa-plus"></i>
                                <p class="upload-text">Add image</p>
                            `;
                            
                            // Remove the button
                            this.remove();
                        });
                    }
                    
                    // Upload the image
                    uploadImage(file, card.dataset.index, card);
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Handle remove card button if it exists
        const removeCardBtn = card.querySelector('.remove-card-btn');
        if (removeCardBtn) {
            removeCardBtn.addEventListener('click', function() {
                card.remove();
            });
        }
    }
    
    // Function to upload image to server
    // 2. Then modify the JavaScript function that handles image upload:
function uploadImage(file, index, card) {
    const formData = new FormData();
    formData.append('food_image', file);
    formData.append('index', index);
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    formData.append('restaurant_id', document.querySelector('input[name="restaurant_id"]').value);
    
    // Show loading indicator
    const imageUpload = card.querySelector('.image-upload');
    const loadingIndicator = document.createElement('div');
    loadingIndicator.className = 'loading-indicator';
    loadingIndicator.style.position = 'absolute';
    loadingIndicator.style.top = '50%';
    loadingIndicator.style.left = '50%';
    loadingIndicator.style.transform = 'translate(-50%, -50%)';
    loadingIndicator.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
    loadingIndicator.style.color = 'white';
    loadingIndicator.style.padding = '8px 16px';
    loadingIndicator.style.borderRadius = '4px';
    loadingIndicator.style.zIndex = '10';
    loadingIndicator.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
    
    imageUpload.appendChild(loadingIndicator);
    
    // Get the upload URL from the form data attribute
    const uploadUrl = document.getElementById('drink-items-form').getAttribute('data-upload-url');
    
    if (!uploadUrl) {
        // If no upload URL is specified, just store the file in the form
        // and it will be submitted with the form
        loadingIndicator.remove();
        showNotification('Image ready for upload', 'success');
        return;
    }
    
    // Send the image to the server using your existing upload endpoint
    fetch(uploadUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Remove loading indicator
        loadingIndicator.remove();
        
        if (data.success) {
            // Create a hidden input to store the image path
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `food_image_path[${index}]`;
            hiddenInput.value = data.path || data.image_path; // Handle different response formats
            card.appendChild(hiddenInput);
            
            showNotification('Image uploaded successfully', 'success');
        } else {
            // Show error notification
            showNotification(data.message || 'Failed to upload image', 'error');
        }
    })
    .catch(error => {
        // Remove loading indicator
        loadingIndicator.remove();
        
        // Show error notification
        showNotification('Error during upload. Image will be uploaded when form is submitted.', 'info');
        console.error('Error:', error);
    });
}
    
    // Function to show notifications
    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        
        // Add icon based on notification type
        const icon = document.createElement('i');
        if (type === 'success') {
            icon.className = 'fas fa-check-circle';
        } else {
            icon.className = 'fas fa-exclamation-circle';
        }
        notification.appendChild(icon);
        
        // Add message text
        const text = document.createTextNode(' ' + message);
        notification.appendChild(text);
        
        // Add to document
        document.body.appendChild(notification);
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.5s';
            
            setTimeout(() => {
                notification.remove();
            }, 500);
        }, 3000);
    }
    
    // Form validation before submission
    document.getElementById('drink-items-form').addEventListener('submit', function(e) {
        const cards = document.querySelectorAll('.drink-card');
        let isValid = false;
        
        // Check if at least one card has name and price
        cards.forEach(card => {
            const nameInput = card.querySelector('input[name^="item_name"]');
            const priceInput = card.querySelector('input[name^="price"]');
            
            if (nameInput && nameInput.value.trim() && priceInput && priceInput.value.trim()) {
                isValid = true;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            showNotification('Please add at least one drink item with name and price', 'error');
        }
     });
     });
    
    </script>
    

    
        

         <img class="deco-image" src="{{ asset('images\white-vegetable-healthy-fresh-natural-10.png')}}" />
        
            <img class="deco-image-1" src="{{ asset('images\white-vegetable-healthy-fresh-natural-10.png')}}" />

</main>  

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