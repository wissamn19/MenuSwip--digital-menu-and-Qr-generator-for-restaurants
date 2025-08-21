<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','MenuSwip')</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="font-sans text-gray-800 bg-white overflow-x-hidden">
  <!-- Responsive Navbar -->
  <nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 md:px-6">
      <div class="flex justify-between items-center py-4">
        <!-- Logo -->
        <div class="flex items-center gap-2">
          <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logo%201-jLsRbpqjg5wSsL1uBcxfL4T0BJBEcT.png" class="w-10 h-10 object-contain" alt="MenuSwip">
          <span class="text-base font-medium text-gray-900">MenuSwip</span>
        </div>
        
        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center gap-8">
          <a href="{{ url('landing-page')}}" class="nav-link">Home</a>
          <a href="{{ url('landing-page')}}" class="nav-link">How it works?</a>
          <a href="{{ url('landing-page')}}" class="nav-link">About Us</a>
          <a href="#contact" class="nav-link">Contact</a>
        </div>
        
        <!-- Desktop Auth Buttons -->
        <div class="hidden md:flex items-center gap-4">
          <a href="{{ url('log-in-owner') }}" class="btn btn-login">
            <i class="fa-solid fa-right-to-bracket"></i> Login
          </a>
          <a href="{{ url('registration-owner') }}" class="btn btn-register">
            <i class="fa-solid fa-user-plus"></i> Registration
          </a>
        </div>
        
        <!-- Mobile Menu Button -->
        <button class="md:hidden flex items-center" id="mobile-menu-button">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
      
      <!-- Mobile Menu (hidden by default) -->
      <div class="md:hidden hidden" id="mobile-menu">
        <div class="flex flex-col gap-4 py-4">
          <a href="{{ url('landing-page')}}" class="nav-link px-4 py-2">Home</a>
          <a href="{{ url('landing-page')}}" class="nav-link px-4 py-2">How it works?</a>
          <a href="{{ url('landing-page')}}" class="nav-link px-4 py-2">About Us</a>
          <a href="#contact" class="nav-link px-4 py-2">Contact</a>
          
          <div class="flex flex-col gap-3 mt-2 px-4">
            <a href="{{ url('log-in-owner') }}" class="btn btn-login justify-center">
              <i class="fa-solid fa-right-to-bracket"></i> Login
            </a>
            <a href="{{ url('registration-owner') }}" class="btn btn-register justify-center">
              <i class="fa-solid fa-user-plus"></i> Registration
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <main class="min-h-screen">
    @yield('content')
  </main>

  <!-- Responsive Footer -->
  <footer class="footer">
    <div class="footer__container">
        <!-- Left Column -->
        <div class="footer__brand">
            <div class="footer__logo">
                <img src="{{ asset('images/logo 1.png')}}" alt="MenuSwip Logo" class="footer__logo-img" onerror="this.src='https://via.placeholder.com/40'; this.onerror=null;">
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
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
      const menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    });
  </script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
