<!DOCTYPE html>
<main lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create your menu</title>
    <link rel="stylesheet" href="{{ asset('css/menu-type-2.css')}}">
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
        <h1 class="salty-food">Sweety food</h1>

      <form id="food-items-form" action="{{ route('menu.storeType2', ['restaurant' => $restaurant_id]) }}" method="POST" enctype="multipart/form-data">
       @csrf
      <input type="hidden" name="restaurant_id" value="{{ $restaurant_id }}">
        <!-- rest of your form -->
      @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

             <!-- Food cards container -->
          
         <div id="food-cards-container">
         <!-- Initial food card -->
         <div class="food-card" data-index="0">
            <div class="image-upload">
                <input type="file" name="image[0]" class="file-input" accept="image/*" style="display: none;">
                <div class="upload-area">
                    <i class="fas fa-plus"></i>
                    <p class="upload-text">Add image</p>
                </div>
            </div>
            
            <div class="food-details">
                <div class="form-group">
                    <label>Add food name</label>
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
            
            <!-- Hidden input for image path -->
            <input type="hidden" name="food_image_path[0]" class="image-path-input">
        </div>
        




        <!-- Add Card Button -->
        <div class="add-card-container">
            <button type="button" id="add-card-btn" class="btn btn-add">
                <i class="fas fa-plus"></i> Add Another Dish
            </button>
        </div>
        
        
        <div class="next-type-container">
            <button type="submit" class="btn btn-next">Save Sweet Foods</button>
          
           </div>
          </div>
        </form>

        </div>
    </main>

    <!-- Food Card Template (hidden) -->


<template id="food-card-template">
    <div class="food-card" data-index="{index}">
        <div class="image-upload">
            <input type="file" name="image[{index}]" class="file-input" accept="image/*" style="display: none;">
            <div class="upload-area">
                <i class="fas fa-plus"></i>
                <p class="upload-text">Add image</p>
            </div>
        </div>
        
        <div class="food-details">
            <div class="form-group">
                <label>Add food name</label>
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
        
        
        <input type="hidden" name="food_image_path[{index}]" class="image-path-input">
        
        <!-- Remove Card Button -->
        <button type="button" class="remove-card-btn">
            <i class="fas fa-times"></i>
        </button>
         </div>
      </template>
 <div class="navigation-container">
             <a href="{{ route('menu.type1', ['restaurant' => $restaurant_id]) }}" class="btn btn-primary">Back to salty food</a>
            </div>

        </div>
        
        <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Initialize the first card
    initializeCard(document.querySelector('.food-card'));
    
    // Add Card Button
    const addCardBtn = document.getElementById('add-card-btn');
    addCardBtn.addEventListener('click', addNewCard);
    
    // Function to add a new card
    function addNewCard() {
        // Get the current number of cards
        const cardsContainer = document.getElementById('food-cards-container');
        const cardCount = cardsContainer.querySelectorAll('.food-card').length;
        
        // Create a new card element based on the template
        const template = document.getElementById('food-card-template');
        const templateContent = template.innerHTML;
        
        // Replace {index} placeholders with actual index
        const newCardHTML = templateContent.replace(/{index}/g, cardCount);
        
        // Create element from HTML
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = newCardHTML;
        const newCard = tempDiv.firstElementChild;
        
        // Add the new card to the container before the add button
        const addCardContainer = document.querySelector('.add-card-container');
        cardsContainer.insertBefore(newCard, addCardContainer);
        
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
        const imagePathInput = card.querySelector('.image-path-input');
        
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
                            
                            // Clear the image path
                            if (imagePathInput) {
                                imagePathInput.value = '';
                            }
                            
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
                // Renumber the remaining cards
                renumberCards();
            });
        }
    }
    
    // Function to renumber cards after removal
    function renumberCards() {
        const cards = document.querySelectorAll('.food-card');
        cards.forEach((card, index) => {
            card.dataset.index = index;
            
            // Update input names
            // Name input
            const nameInput = card.querySelector('input[name^="item_name"]');
            if (nameInput) {
                nameInput.name = `item_name[${index}]`;
            }
            
            // Description input
            const descInput = card.querySelector('textarea[name^="description"]');
            if (descInput) {
                descInput.name = `description[${index}]`;
            }
            
            // Price input
            const priceInput = card.querySelector('input[name^="price"]');
            if (priceInput) {
                priceInput.name = `price[${index}]`;
            }
            
            // File input
            const fileInput = card.querySelector('.file-input');
            if (fileInput) {
                fileInput.name = `image[${index}]`;
            }
            
            // Image path input
            const imagePathInput = card.querySelector('.image-path-input');
            if (imagePathInput) {
                imagePathInput.name = `food_image_path[${index}]`;
            }
        });
    }
    
    // Function to upload image to server
    function uploadImage(file, index, card) {
        const formData = new FormData();
        formData.append('food_image', file);
        formData.append('index', index);
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        
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
        
        fetch('{{ route("food-items.upload-image") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Remove loading indicator
            loadingIndicator.remove();
            
            if (data.success) {
                // Store the image path
                const imagePathInput = card.querySelector('.image-path-input');
                if (imagePathInput) {
                    imagePathInput.value = data.image_path;
                }
                
                // Show success notification
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
            showNotification('Error uploading image', 'error');
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
    const form = document.getElementById('food-items-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const cards = document.querySelectorAll('.food-card');
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
                showNotification('Please add at least one food item with name and price', 'error');
            }
        });
    }
});
    </script>
        
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