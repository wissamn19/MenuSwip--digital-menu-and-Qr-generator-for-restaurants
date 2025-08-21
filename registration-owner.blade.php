<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registration Form</title>
    <link rel="stylesheet" href="{{ asset('css/registration-owner.css')}}">
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
            <a href="{{url('landing-page')}}" class="nav-link">How it works ?</a>
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
                    <div class="form-header__number">1</div>
                    <h2 class="form-header__text">Basic info</h2>
                </div>
                <p class="form-header__description">
                    The following informations are essential to continue your registration on our <br/>platform, make sure that your infos are right for best experience.
                </p>
                <p class="form-header__note">*All fields required unless noted.</p>
            </div>

            <form action="{{ route('store-1')}}" class="form" method="POST">
            @csrf
                <div class="form__group">
                    <label class="form__label" for="fullName">*Full name</label>
                    <input type="text" id="fullName" name="fullName"  class="form__input" required>
                </div>

                <div class="form__group" >
                    <label class="form__label">What's your gender? (optional)</label>
                    <div class="form__radio-group">
                        <div class="radio">
                            <input type="radio" id="female" name="gender" value="Female" class="radio__input">
                            <label for="female" class="radio__label">Female</label>
                        </div>
                        <div class="radio">
                            <input type="radio" id="male" name="gender" value="Male" class="radio__input">
                            <label for="male" class="radio__label">Male</label>
                        </div>
                    </div>
                </div>

                <div class="form__group">
                    <label class="form__label">What's your date of birth?</label>
                    <div name="dob" class="form__date-group">
                        <select name="Month"  class="form__select" required>
                            <option value="" disabled selected>Month</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <select name="date" class="form__select" required>
                            <option value="" disabled selected>Date</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                            
                        </select>
                        <select name="Year" class="form__select" required>
                            <option value="" disabled selected>Year</option>
                            <option value="2004">2004</option>
                            <option value="2003">2003</option>
                            <option value="2002">2002</option>
                            <option value="2001">2001</option>
                            <option value="2000">2000</option>
                            <option value="1999">1999</option>
                            <option value="1998">1998</option>
                            <option value="1997">1997</option>
                            <option value="1996">1996</option>
                            <option value="1995">1995</option>
                            <option value="1994">1994</option>
                            <option value="1993">1993</option>
                            <option value="1992">1992</option>
                            <option value="1991">1991</option>
                            <option value="1990">1990</option>
                            <option value="1989">1989</option>
                            <option value="1988">1988</option>
                            <option value="1987">1987</option>
                            <option value="1986">1986</option>
                            <option value="1985">1985</option>
                            <option value="1984">1984</option>
                            <option value="1983">1983</option>
                            <option value="1982">1982</option>
                            <option value="1981">1981</option>
                            <option value="1980">1980</option>
                            <option value="1979">1979</option>
                            <option value="1978">1978</option>
                            <option value="1977">1977</option>
                            <option value="1976">1976</option>
                            <option value="1975">1975</option>
                            <option value="1974">1974</option>
                            <option value="1973">1973</option>
                            <option value="1972">1972</option>
                            <option value="1971">1971</option>
                            <option value="1970">1970</option>
                            
                            
                             </select>
                    </div>
                </div>
               
                <button type="submit" class="form__button">Next</button>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>


        <img class="deco-image" src="{{ asset('images\white-vegetable-healthy-fresh-natural-10.png')}}" />
        
        <img class="deco-image-1" src="{{ asset('images\white-vegetable-healthy-fresh-natural-10.png')}}" />

      <!--next steps-->

      <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="number-badge">2</div>
                <h2 class="card-title">Restaurant info</h2>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="number-badge">3</div>
                <h2 class="card-title">Login info</h2>
            </div>
        </div>
    </div>
</div>


    
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