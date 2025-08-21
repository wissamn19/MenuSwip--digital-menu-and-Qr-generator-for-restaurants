<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing page </title>
    <link rel="stylesheet" href="{{asset('css/landing-page.css')}}">
    <link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css')}}" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            <img src="{{asset('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logo%201-jLsRbpqjg5wSsL1uBcxfL4T0BJBEcT.png')}}" alt="MenuSwip Logo" class="logo-img">
            <span class="logo-text">MenuSwip</span>
        </div>

        <div class="nav-links">
            <a href="#" class="nav-link">Home</a>
            <a href="#how-it-works" class="nav-link" >How it works ?</a>
            <a href="#about" class="nav-link">About Us</a>
            <a href="{{url('contact-us')}}" class="nav-link">Contact</a>
        </div>

        <div class="auth-buttons">
        <a href="{{ url('log-in-owner') }}" class="btn btn-login">
    <i class="fa-solid fa-right-to-bracket icon"></i> Login
</a>
<a href="{{ url('registration-owner')}}" class="btn btn-register">
    <i class="fa-solid fa-user-plus icon"></i> Registration
</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Ready to Upgrade Your Menu Experience?</h1>
                <p class="hero-description">
                    Join MenuSwip today and provide your customers with a seamless digital experience. 
                    It's fast, easy, and cost-effective.
                </p>
                <a href="{{ url('registration-owner')}}" class="btn btn-cta" >
                <span>Join Us Today</span>
                </a>
            </div>

            <div class="hero-image">
                <div class="image-stack">
                    <img src="{{ asset('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Leonardo_Phoenix_A_sleek_modern_smartphone_with_a_bright_highc_1-removebg-preview%20(1)-H9xArbNM1DW3WPRXlFmCFLx8C4Q09G.png')}}" alt="QR Code Demo" class="qr-image">
                    <img src="{{ asset('images\monika-grabkowska-pCxJvSeSB5A-unsplash (1) 1.png')}}" alt="Salad Plate" class="plate-image">
                    <img src="{{ asset('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/white-vegetable-healthy-fresh-natural-20-BLw0EaVgsz6aewPhC6vYV8QK9gkcU4.png')}}" alt="Fresh Lettuce" class="lettuce-image">
                    <img src="{{ asset('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/white-vegetable-healthy-fresh-natural-20-BLw0EaVgsz6aewPhC6vYV8QK9gkcU4.png')}}" alt="Fresh Lettuce" class="lettuce-image2">
                </div>
                <!-- Decorative elements -->
                <div class="decoration decoration-1">
                    <img src="{{ asset('images/line-40.svg')}}" alt="line1" class="decoration-1">
                </div>
                <div class="decoration decoration-2">
                    <img src="{{ asset('images/line-60.svg')}}" alt="line2" class="decoration-2">
                </div>
                <div class="decoration decoration-3">
                    <img src="{{ asset('images/line-70.svg')}}" alt="line3" class="decoration-3">
                </div>
                <div class="decoration decoration-4">
                    <img src="{{ asset('images/line-50.svg')}}" alt="line4" class="decoration-4">
                </div>

            </div>
        </div>
        
    </main>

               <!-- how it works? -->
    <section id="how-it-works" class="how-it-works">
        <div class="container">
            <h2 class="title">How it works ?</h2>
            
            <div class="steps">
                <!-- Step 1 -->
                <div class="step-card">
                    <span class="step-number">1</span>
                    <div class="step-image">
                        <img src="{{ asset('images\light-item-image-10.png')}}" alt="Create your digital menu" loading="lazy">
                    </div>
                    <h3 class="step-title">Create Your Digital Menu</h3>
                    <p class="step-description">
                        Sign up for MenuSwip and easily create a digital menu for your restaurant. Add menu items, images, prices, and descriptions in minutes.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="step-card">
                    <span class="step-number">2</span>
                    <div class="step-image">
                        <img src="{{ asset('images\Horizontal Image1.png')}}" alt="Generate QR code" loading="lazy">
                    </div>
                    <h3 class="step-title">Generate Your QR Code</h3>
                    <p class="step-description">
                        Generate a unique QR code for your restaurant. Print it and place it on tables so customers can scan to view the menu instantly from their smartphones.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="step-card">
                    <span class="step-number">3</span>
                    <div class="step-image">
                        <img src="{{ asset('images\light-item-alternative1.png')}}" alt="Share online" loading="lazy">
                    </div>
                    <h3 class="step-title">Share it Online</h3>
                    <p class="step-description">
                        Share your digital menu on your website or social media, allowing customers to view your menu before visiting or while placing orders online.
                    </p>
                </div>
            </div>
             </div>
        </section>

           <!-- welcome to our menuswip -->
        <div  class="welcome ">
            <div class="section1">
                <div class="section2">
                    <div class="welcome-to-our"> Welcome to our </div>
                    <div class="menu-swip"> MenuSwip </div>
                </div>
                <div class="menu-swip-text"> MenuSwip was founded with the goal of helping restaurants transition to the digital world. We enable restaurants to offer their customers a seamless experience by providing digital menus through QR codes. We believe that technology should empower restaurant owners to easily manage and update their menus without hassle. </div>
            </div>
              <!--images-->
            <div class="item-image1">
                <img class="image1" src="{{ asset('images\close-up-man-holding-smartphone.jpg')}}" />
            </div>
            <div class="item-image2">
                <img class="image2" src="{{ asset('images\Item Image.png')}}" />
            </div>
            <div class="horizontal-image">
                <img class="horizontal-image1" src="{{ asset('images\Horizontal Image1.png')}}" />
            </div>
            <div class="item-image3">
                <img class="image3" src="{{ asset('images\light-item-image-10.png')}}" />
            </div>
            <div class="horizontal-image2">
                <img class="horizontal-image-2" src="{{ asset('images\light-big-horizontal-image-20.png')}}" />
            </div>
            <img class="deco1" alt="garlic image" src="{{ asset('images\_27172380-8-20.png')}}" />
            <img class="deco2" alt="garlic image" src="{{ asset('images\_27172380-8-20.png')}}" />
        </div>

   <!--How Restaurants Benefit?-->

        <div class="Section4">
            <img class="How-Restaurants" src="{{ asset('images\presenter-beard-bow-adult-uniform-removebg-preview 1.png')}}" />
            <div class="how-restaurants-benefit"> How Restaurants Benefit? </div>
            <div class="ellipse-143">
            </div>
            <div class="ellipse-148">
            </div>
            <div class="ellipse-152">
            </div>
            <div class="ellipse-145">
            </div>
            <div class="ellipse-149">
            </div>
            <div class="ellipse-146">
            </div>
            <div class="ellipse-150">
            </div>
            <div class="ellipse-147">
            </div>
            <div class="ellipse-151">
            </div>
            <div class="text1"> No more reprinting menus! With MenuSwip, changes are made instantly. Update menu items, prices, and availability in real-time.<br /><br /> 
            </div>
            <svg class="icon1"  xmlns="http://www.w3.org/2000/svg">
                <path d="M16.4722 22.9862C15.4448 22.9896 14.4356 23.2575 13.5417 23.7639C14.8002 20.5063 16.8876 17.6338 19.5972 15.4306C19.7523 15.3029 19.8806 15.146 19.975 14.9687C20.0694 14.7914 20.1279 14.5973 20.1472 14.3974C20.1666 14.1975 20.1464 13.9957 20.0877 13.8036C20.0291 13.6115 19.9332 13.4329 19.8056 13.2778C19.6779 13.1228 19.5209 12.9944 19.3436 12.9001C19.1664 12.8057 18.9722 12.7472 18.7723 12.7278C18.5724 12.7085 18.3707 12.7287 18.1786 12.7873C17.9865 12.8459 17.8078 12.9418 17.6528 13.0695C12.0972 17.5834 9.625 23.8334 9.625 27.7084C9.63457 29.0785 10.0429 30.4162 10.8001 31.5582C11.5572 32.7001 12.6305 33.5969 13.8889 34.1389C14.7033 34.5335 15.5951 34.7422 16.5 34.7501C17.2965 34.7888 18.0925 34.6653 18.8398 34.3872C19.5872 34.1091 20.2703 33.6821 20.8476 33.1321C21.425 32.5821 21.8847 31.9205 22.1988 31.1876C22.5128 30.4546 22.6748 29.6655 22.6748 28.8681C22.6748 28.0707 22.5128 27.2816 22.1988 26.5486C21.8847 25.8157 21.425 25.1542 20.8476 24.6042C20.2703 24.0542 19.5872 23.6272 18.8398 23.349C18.0925 23.0709 17.2965 22.9475 16.5 22.9862H16.4722Z" fill="white" />
                <path d="M31.9449 22.9858C30.9173 22.988 29.9078 23.2559 29.0143 23.7636C30.2724 20.5093 32.3543 17.6378 35.056 15.4302C35.2251 15.3083 35.3675 15.1531 35.4743 14.9742C35.5812 14.7952 35.6503 14.5962 35.6774 14.3895C35.7046 14.1829 35.6891 13.9728 35.632 13.7723C35.5749 13.5718 35.4773 13.3852 35.3454 13.2238C35.2134 13.0624 35.0499 12.9297 34.8647 12.834C34.6796 12.7382 34.4768 12.6813 34.2688 12.6668C34.0609 12.6523 33.8522 12.6805 33.6555 12.7497C33.4589 12.8189 33.2785 12.9276 33.1254 13.0691C27.5699 17.583 25.0977 23.833 25.0977 27.708C25.1042 29.0626 25.5006 30.3867 26.2395 31.5221C26.9784 32.6575 28.0284 33.5562 29.2643 34.1108C30.0993 34.5168 31.0164 34.7259 31.9449 34.7219C32.7414 34.7606 33.5374 34.6372 34.2847 34.359C35.0321 34.0809 35.7151 33.6539 36.2925 33.1039C36.8699 32.5539 37.3296 31.8924 37.6436 31.1594C37.9577 30.4265 38.1197 29.6374 38.1197 28.84C38.1197 28.0425 37.9577 27.2534 37.6436 26.5205C37.3296 25.7875 36.8699 25.126 36.2925 24.576C35.7151 24.026 35.0321 23.599 34.2847 23.3209C33.5374 23.0427 32.7414 22.9193 31.9449 22.958V22.9858Z" fill="white" />
            </svg>
            <svg class="icon2"  xmlns="http://www.w3.org/2000/svg">
                <path d="M16.4722 22.9862C15.4448 22.9896 14.4356 23.2575 13.5417 23.7639C14.8002 20.5063 16.8876 17.6338 19.5972 15.4306C19.7523 15.3029 19.8806 15.146 19.975 14.9687C20.0694 14.7914 20.1279 14.5973 20.1472 14.3974C20.1666 14.1975 20.1464 13.9957 20.0877 13.8036C20.0291 13.6115 19.9332 13.4329 19.8056 13.2778C19.6779 13.1228 19.5209 12.9944 19.3436 12.9001C19.1664 12.8057 18.9722 12.7472 18.7723 12.7278C18.5724 12.7085 18.3707 12.7287 18.1786 12.7873C17.9865 12.8459 17.8078 12.9418 17.6528 13.0695C12.0972 17.5834 9.625 23.8334 9.625 27.7084C9.63457 29.0785 10.0429 30.4162 10.8001 31.5582C11.5572 32.7001 12.6305 33.5969 13.8889 34.1389C14.7033 34.5335 15.5951 34.7422 16.5 34.7501C17.2965 34.7888 18.0925 34.6653 18.8398 34.3872C19.5872 34.1091 20.2703 33.6821 20.8476 33.1321C21.425 32.5821 21.8847 31.9205 22.1988 31.1876C22.5128 30.4546 22.6748 29.6655 22.6748 28.8681C22.6748 28.0707 22.5128 27.2816 22.1988 26.5486C21.8847 25.8157 21.425 25.1542 20.8476 24.6042C20.2703 24.0542 19.5872 23.6272 18.8398 23.349C18.0925 23.0709 17.2965 22.9475 16.5 22.9862H16.4722Z" fill="white" />
                <path d="M31.9449 22.9858C30.9173 22.988 29.9078 23.2559 29.0143 23.7636C30.2724 20.5093 32.3543 17.6378 35.056 15.4302C35.2251 15.3083 35.3675 15.1531 35.4743 14.9742C35.5812 14.7952 35.6503 14.5962 35.6774 14.3895C35.7046 14.1829 35.6891 13.9728 35.632 13.7723C35.5749 13.5718 35.4773 13.3852 35.3454 13.2238C35.2134 13.0624 35.0499 12.9297 34.8647 12.834C34.6796 12.7382 34.4768 12.6813 34.2688 12.6668C34.0609 12.6523 33.8522 12.6805 33.6555 12.7497C33.4589 12.8189 33.2785 12.9276 33.1254 13.0691C27.5699 17.583 25.0977 23.833 25.0977 27.708C25.1042 29.0626 25.5006 30.3867 26.2395 31.5221C26.9784 32.6575 28.0284 33.5562 29.2643 34.1108C30.0993 34.5168 31.0164 34.7259 31.9449 34.7219C32.7414 34.7606 33.5374 34.6372 34.2847 34.359C35.0321 34.0809 35.7151 33.6539 36.2925 33.1039C36.8699 32.5539 37.3296 31.8924 37.6436 31.1594C37.9577 30.4265 38.1197 29.6374 38.1197 28.84C38.1197 28.0425 37.9577 27.2534 37.6436 26.5205C37.3296 25.7875 36.8699 25.126 36.2925 24.576C35.7151 24.026 35.0321 23.599 34.2847 23.3209C33.5374 23.0427 32.7414 22.9193 31.9449 22.958V22.9858Z" fill="white" />
            </svg>
            <svg class="icon3"  xmlns="http://www.w3.org/2000/svg">
                <path d="M16.4722 22.9862C15.4448 22.9896 14.4356 23.2575 13.5417 23.7639C14.8002 20.5063 16.8876 17.6338 19.5972 15.4306C19.7523 15.3029 19.8806 15.146 19.975 14.9687C20.0694 14.7914 20.1279 14.5973 20.1472 14.3974C20.1666 14.1975 20.1464 13.9957 20.0877 13.8036C20.0291 13.6115 19.9332 13.4329 19.8056 13.2778C19.6779 13.1228 19.5209 12.9944 19.3436 12.9001C19.1664 12.8057 18.9722 12.7472 18.7723 12.7278C18.5724 12.7085 18.3707 12.7287 18.1786 12.7873C17.9865 12.8459 17.8078 12.9418 17.6528 13.0695C12.0972 17.5834 9.625 23.8334 9.625 27.7084C9.63457 29.0785 10.0429 30.4162 10.8001 31.5582C11.5572 32.7001 12.6305 33.5969 13.8889 34.1389C14.7033 34.5335 15.5951 34.7422 16.5 34.7501C17.2965 34.7888 18.0925 34.6653 18.8398 34.3872C19.5872 34.1091 20.2703 33.6821 20.8476 33.1321C21.425 32.5821 21.8847 31.9205 22.1988 31.1876C22.5128 30.4546 22.6748 29.6655 22.6748 28.8681C22.6748 28.0707 22.5128 27.2816 22.1988 26.5486C21.8847 25.8157 21.425 25.1542 20.8476 24.6042C20.2703 24.0542 19.5872 23.6272 18.8398 23.349C18.0925 23.0709 17.2965 22.9475 16.5 22.9862H16.4722Z" fill="white" />
                <path d="M31.9449 22.9858C30.9173 22.988 29.9078 23.2559 29.0143 23.7636C30.2724 20.5093 32.3543 17.6378 35.056 15.4302C35.2251 15.3083 35.3675 15.1531 35.4743 14.9742C35.5812 14.7952 35.6503 14.5962 35.6774 14.3895C35.7046 14.1829 35.6891 13.9728 35.632 13.7723C35.5749 13.5718 35.4773 13.3852 35.3454 13.2238C35.2134 13.0624 35.0499 12.9297 34.8647 12.834C34.6796 12.7382 34.4768 12.6813 34.2688 12.6668C34.0609 12.6523 33.8522 12.6805 33.6555 12.7497C33.4589 12.8189 33.2785 12.9276 33.1254 13.0691C27.5699 17.583 25.0977 23.833 25.0977 27.708C25.1042 29.0626 25.5006 30.3867 26.2395 31.5221C26.9784 32.6575 28.0284 33.5562 29.2643 34.1108C30.0993 34.5168 31.0164 34.7259 31.9449 34.7219C32.7414 34.7606 33.5374 34.6372 34.2847 34.359C35.0321 34.0809 35.7151 33.6539 36.2925 33.1039C36.8699 32.5539 37.3296 31.8924 37.6436 31.1594C37.9577 30.4265 38.1197 29.6374 38.1197 28.84C38.1197 28.0425 37.9577 27.2534 37.6436 26.5205C37.3296 25.7875 36.8699 25.126 36.2925 24.576C35.7151 24.026 35.0321 23.599 34.2847 23.3209C33.5374 23.0427 32.7414 22.9193 31.9449 22.958V22.9858Z" fill="white" />
            </svg>
            <img class="lettuce" src="{{ asset('images\white-vegetable-healthy-fresh-natural-10.png')}}" />
            <div class="title1"> Streamline Your Operations </div>
            <div class="title2"> Enhance Customer Experience </div>
            <div class="text2"> Provide a seamless, contactless dining experience by enabling customers to scan QR<br />codes at the table. Let them explore your menu at their own pace on their smartphones. </div>
            <div class="title3"> Save Costs </div>
            <div class="text3"> Eliminate the need for expensive printed menus. Use QR codes and digital platforms<br />to share your menu with customers while reducing overhead costs. </div>
        </div>

        <!--for your customers-->

        <div class="section5">
            <img class="plate" src="{{ asset('images\_22183342-6587525-10.png')}}" />
            <div class="for-your-customers"> For Your Customers </div>
            
            <div class="box1">
                <h3 class="instant-access">Instant Access</h3>
                <p class="text-box1">
                    Your customers can access your <br/>menu immediately by scanning the <br/> QR code with their  phone's camera.<br/>No app downloads, no waiting.
                </p>
            </div>

            <div class="box2">
                <h3 class="easy-browsing">Easy Browsing</h3>
                <p class="text-box2">
                    The digital menu is easy to navigate, allowing customers to browse through categories, read descriptions, and see updated prices.
                </p>
            </div>
            <div class="box3">
                <h3 class="view-menu-anytime"> View Menu Anytime</h3>
                <p class="text-box3">
                    Customers can view your menu<br/> from home or before arriving,<br/> helping them decide whatto order<br/> before even stepping through the door.

                </p>
            </div>

            <!--about us-->
            
            <section id="about" class="section6">
                <div class="background-image">
                    <img src="{{ asset('images\close-up-man-holding-smartphone.jpg')}}" alt="Person scanning QR code menu">
                </div>
                
                <div class="content">
                    <h1>About us</h1>
                    <p>
                        MenuSwip was founded with the goal of helping restaurants transition to
                        the digital world. We enable restaurants to offer their customers a seamless
                        experience by providing digital menus through QR codes. We believe that
                        technology should empower restaurant owners to easily manage and update
                        their menus without hassle.
                    </p>
                    <a  href="{{url('contact-us')}}"  class="contact-button">Contact

                    </a>
                </div>
            </section>

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