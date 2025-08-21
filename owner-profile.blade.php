<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/owner-profile.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body>
   
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('images/logo 1.png')}}" alt="MenuSwip Logo" class="logo-img">
            <span class="logo-text">MenuSwip</span>
        </div>
    </nav>

    <!-- background -->
    <div class="background"></div>

    <!-- Navigation -->
    <div class="navigation">
        <a href="{{ url('registration-owner') }}" class="back-button">
            <i class="fas fa-chevron-left"></i>
            <span>Back</span>
        </a>
        @isset($restaurant)
        <a href="{{ route('pos.home', ['owner_id' => $restaurant->owner_id]) }}" class="edit-profile-btn">Your Point of sale 
        </a>
        @endisset
    </div>

    <form action="{{ isset($restaurant) ? url('restaurant', ['id' => $restaurant->id]) : '#' }}" method="POST" id="restaurant-form" enctype="multipart/form-data">
        @csrf
        @if(isset($restaurant))
            @method('PUT')
        @endif
        
        <div class="content">
            <!-- Restaurant Profile Card -->
            <div class="profile-card">
                <div class="profile-image-container">
                    <div id="profile-image-preview" class="profile-image-placeholder">
                        @if(isset($restaurant) && $restaurant->urlimage)
                            <img src="{{ $restaurant->urlimage }}" alt="{{ $restaurant->restaurantName }}">
                        @else
                            <i class="fas fa-plus"></i>
                            <span>Add image</span>
                            <span class="image-size">230×230px</span>
                        @endif
                    </div>

                    <input type="file" id="urlimage" name="urlimage" accept="image/*" style="display: none;">

                    <!-- Upload Status Message -->
                    <div id="upload-status" class="upload-status"></div>
                </div>

                <!-- Call Button -->
                @isset($restaurant)
                <a href="tel:{{ $restaurant->phonen}}" id="phonen" class="call">
                    <button type="button" class="call-button"><i class="fa-solid fa-phone-volume" style="color: #ffffff;"></i></button>
                </a>
                @endisset
              
                <!-- Working Hours -->
                <div class="working-hours">
                    <p>Working Hours</p>
                    <label for="starttime">From:</label>
                    <input type="time" id="starttime" name="starttime" value="{{ $restaurant->starttime}}" onchange="setMinTime()">
                    
                    <label for="endtime">To:</label>
                    <input type="time" id="endtime" name="endtime" value="{{ $restaurant->endtime}}">
</div>
            </div>

            <!-- Restaurant Details -->
            <div class="restaurant-details">
                <h1><strong>{{ $restaurant->resturantName }}</strong></h1>

                <div class="info-section">
                    <div class="info-item">
                        <h3>Location</h3>
                        <p><strong>{{ $restaurant->location }}</strong></p>
                    </div>
                    <div class="info-item">
                        <h3>State</h3>
                        <p><strong>{{ $restaurant->state}}</strong></p>
                    </div>
                </div>

                <!-- Map -->
                <div class="map">
                    <div id="restaurant-map" style="height: 300px; width: 100%;"></div>
                </div>

                <!-- Specialities -->
                <div class="specialities">
                    <h2>Specialities</h2>
                    <div class="tags">
                    @if(isset($restaurant->type))
                        <span class="tag"><strong>{{ $restaurant->type }}</strong></span>
                    @endif
                    </div>
                </div>

                <!-- Create Menu Button -->
                <div class="create-menu">
                    @isset($restaurant)
                    <a href="{{ route('menu.type1', ['restaurant' => $restaurant->id]) }}" class="create-menu-btn">Create Your Menu</a>
                    @else
                    <a href="{{ url('owner-profile') }}"class="create-menu-btn ">Create Your Menu</a>
                    @endisset
                </div>
            </div>
        </div>
    </form>

    <img class="deco-image" src="{{ asset('images/white-vegetable-healthy-fresh-natural-10.png')}}" />
    <img class="deco-image-1" src="{{ asset('images/white-vegetable-healthy-fresh-natural-10.png')}}" />

    <!--footer section-->
    <footer class="footer">
        <!-- Footer content remains unchanged -->
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

    <script>
        function setMinTime() {
            let fromTime = document.getElementById("starttime").value;
            document.getElementById("endtime").min = fromTime;
        }
        
        document.addEventListener("DOMContentLoaded", () => {
            // Set CSRF token for all AJAX requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Image upload functionality
            const profileImagePreview = document.getElementById("profile-image-preview");
            const profileImageInput = document.getElementById("urlimage");
            const uploadStatus = document.getElementById("upload-status");
            
            // Initialize min time on page load
            setMinTime();

            // Handle file selection
            if (profileImagePreview && profileImageInput) {
                profileImagePreview.addEventListener("click", () => {
                    profileImageInput.click();
                });

                profileImageInput.addEventListener("change", (event) => {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            profileImagePreview.innerHTML = "";
                            const img = document.createElement("img");
                            img.src = e.target.result;
                            img.alt = "Restaurant Profile";
                            profileImagePreview.appendChild(img);
                            uploadImage(file);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Function to upload the image
            function uploadImage(file) {
                const formData = new FormData();
                formData.append("urlimage", file);
                formData.append("_token", csrfToken);
                
                @if(isset($restaurant))
                formData.append("restaurant_id", "{{ $restaurant->id }}");
                @endif
                
                uploadStatus.textContent = "Uploading...";
                uploadStatus.className = "upload-status";

                // Use direct URL instead of named route
                fetch("/restaurant/upload-image", {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        uploadStatus.textContent = data.message;
                        uploadStatus.className = "upload-status success";
                        
                        // Update the image source with the new URL from the server
                        if (data.file_path) {
                            const img = profileImagePreview.querySelector('img');
                            if (img) {
                                img.src = data.file_path;
                            }
                        }
                    } else {
                        uploadStatus.textContent = data.message || "Upload failed";
                        uploadStatus.className = "upload-status error";
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    uploadStatus.textContent = "An error occurred during upload";
                    uploadStatus.className = "upload-status error";
                });
            }

            // Map initialization
            try {
                const mapContainer = document.getElementById('restaurant-map');
                
                @if(isset($restaurant->location, $restaurant->state))
                const location = "{{ $restaurant->location }}";
                const state = "{{ $restaurant->state }}";
                const query = `${location}, ${state}`;
                
                // Show loading indicator
                mapContainer.innerHTML = '<div id="map-loading" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(255,255,255,0.7);display:flex;justify-content:center;align-items:center;z-index:1000;">Loading map...</div>';
                
                // Initialize map
                const map = L.map('restaurant-map').setView([0, 0], 2);
                
                // Add tile layer (OpenStreetMap)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                
                // Fetch coordinates from Nominatim
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Remove loading indicator
                        const loadingElement = document.getElementById('map-loading');
                        if (loadingElement) loadingElement.remove();
                        
                        if (data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            map.setView([lat, lon], 15);
                            L.marker([lat, lon]).addTo(map)
                                .bindPopup(query)
                                .openPopup();
                        } else {
                            console.error("Location not found");
                            mapContainer.innerHTML = '<div style="display:flex;justify-content:center;align-items:center;height:100%;">Location not found on map</div>';
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching map data:", error);
                        mapContainer.innerHTML = '<div style="display:flex;justify-content:center;align-items:center;height:100%;">Error loading map</div>';
                    });
                @else
                mapContainer.innerHTML = '<div style="display:flex;justify-content:center;align-items:center;height:100%;">No location information available</div>';
                @endif
            } catch (error) {
                console.error("Error initializing map:", error);
                document.getElementById('restaurant-map').innerHTML = '<div style="display:flex;justify-content:center;align-items:center;height:100%;">Error loading map</div>';
            }
        });
    </script>
</body>
</html>