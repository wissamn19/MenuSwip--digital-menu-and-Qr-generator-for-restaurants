<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Log in</title>
    <link rel="stylesheet" href="{{ asset('css/log-in-owner.css')}}">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css')}}" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logo%201-jLsRbpqjg5wSsL1uBcxfL4T0BJBEcT.png')}}" alt="MenuSwip Logo" class="logo-img">
            <span class="logo-text">MenuSwip</span>
        </div>

        <div class="nav-links">
            <a href="{{ url('landing-page')}}" class="nav-link">Home</a>
            <a href="{{ url('landing-page')}}"  class="nav-link">How it works ?</a>
            <a href="{{ url('landing-page')}}"  class="nav-link">About Us</a>
            <a href="{{ url('contact-us')}}"  class="nav-link">Contact</a>
        </div>

        <div class="auth-buttons">
        <a href="{{ url('log-in-owner') }}" class="btn btn-login">
    <i class="fa-solid fa-right-to-bracket icon"></i> Login
</a>
<a href="{{ url('registration-owner') }}" class="btn btn-register">
    <i class="fa-solid fa-user-plus icon"></i> Registration
</a>
        </div>
    </nav>

    <!-- Registration owner -->

    <div class="Registration-owner-background">
        <!-- text and title -->

        <div class="text-form">
            <div class="title"> Log in </div>
            <div class="registration-text"> Welcome back to menuswip!</div>
        </div> 
        
    <!--box form-->

        <div class="form-container">
            <div class="form-header">
                </div>

            <form class="form" action="{{ route('owner.login.submit')}}" method="POST">
            @csrf
            
                <div class="form__group">
                    <label class="form__label" for="fullName">*Your email/phone number</label>
                    <input type="text" id="identifier" name="identifier" class="form__input" required>
                    @error('identifier')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

               

                <div class="form__group">
                    <label class="form__label">*Your password</label>
                    <input type="password" id="password" name="password" class="form__input" required>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
            
                 <!--button-->
                <button type="submit" class="form__button">Log in</button>
            </form>
            <div class="forget-text">
                <a href="{{ route('forgot.password') }}" class="forget-your-password">Forgot your password?</a>
            </div>
        </div>

 </div>
        
   

        <img class="deco-image" src="{{ asset('images\white-vegetable-healthy-fresh-natural-10.png')}}" />
        
        <img class="deco-image-1" src="{{ asset('images\white-vegetable-healthy-fresh-natural-10.png')}}" />

    


    <!--footer section-->
<footer class="footer">
    <div class="footer__container">
        <!-- Left Column -->
        <div class="footer__brand">
            <div class="footer__logo">
                <img src="{{ asset('images\logo 1.png" alt="MenuSwip Logo')}}" class="footer__logo-img">
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