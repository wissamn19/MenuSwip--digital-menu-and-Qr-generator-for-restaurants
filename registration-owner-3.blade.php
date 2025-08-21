<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registration Form- login info</title>
    <link rel="stylesheet" href="{{ asset('css/registration-owner-3.css')}}">
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
            <a href="{{url('landing-page')}}" class="nav-link">Home</a>
            <a href="{{url('landing-page')}}"class="nav-link">How it works ?</a>
            <a href="{{url('landing-page')}}" class="nav-link">About Us</a>
            <a href="{{url('contact-us')}}" class="nav-link">Contact</a>
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
            <div class="title"> Join our family </div>
            <div class="registration-text"> Become one of Menuswip’s family by following <br />the following steps from basic infos to your resturant info ( name , kind and more.........) . </div>
        </div> 
        
        <!--steppers-->

        <div class="stepper">
             <!--step 1 -->
            <div class="frame-1">
                <div class="circle-1">
                    <div class="background">
                    </div>
                    <div class="number-1"> 1 </div>
                </div>
                <div class="basic-info"> Basic info </div>
            </div>
            <div class="stepper-frame-1">
            </div>
             <!--step 2 -->
            <div class="frame-2">
                <div class="circle-2">
                    <div class="background">
                    </div>
                    <div class="number-2"> 2 </div>
                </div>
                <div class="Resturant-info"> Resturant info </div>
            </div>
            <div class="stepper-frame-2">
            </div>
            <!--step 3 -->
            <div class="stepper-frame-3">
            </div>
            <div class="frame-3">
                <div class="circle-3">
                    <div class="background">
                    </div>
                    <div class="number-3"> 3 </div>
                </div>
                <div class="login-info"> Login info </div>
            </div>
             
        </div>


        <!--box form-->

        <div class="form-container">
            <div class="form-header">
                <div class="form-header__title">
                    <div class="form-header__number">3</div>
                    <h2 class="form-header__text"> Login info</h2>
                </div>
                <p class="form-header__description">
                    The following informations are essential to continue your registration on our <br/>platform, make sure that your infos are right for best experience.
                </p>
                <p class="form-header__note">*All fields required unless noted.</p>
            </div>
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('store-3')}}" method="POST">
            @csrf
                <div class="form__group">
                    <label class="form__label" for="fullName">*Your phone number</label>
                    <input type="tel" id="phonen" name="phonen"  class="form__input" required>
                    @error('phonen')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form__group">
                    <label class="form__label">*Your email</label>
                    <input type="email" id="Email" name="Email" class="form__input" required>
                    @error('Email')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form__group">
                    <label class="form__label">*Your password</label>
                    <input type="password" id="password" name="password" class="form__input" required>
                    @error('password')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>
                
            
                 <!--button-->
                <button type="submit" class="form__button" >Complete Registration</button>
            </form>
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