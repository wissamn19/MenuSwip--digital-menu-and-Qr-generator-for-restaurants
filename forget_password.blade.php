<!DOCTYPE html>
<lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>reset your password</title>
    <link rel="stylesheet" href="{{ asset('css/forget_password.css')}}">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css')}}" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
  </style>

</head>



    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            <img src="{{asset ('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logo%201-jLsRbpqjg5wSsL1uBcxfL4T0BJBEcT.png')}}" alt="MenuSwip Logo" class="logo-img">
            <span class="logo-text">MenuSwip</span>
        </div>
 </nav>
<body>
 <div class="background">

    <form action="{{ route ('forgot.password')}}" method="POST">
    @csrf
 <div class="form-container">
    <p class="form-header__description">Reset your password.</p>


    <div class="form__group">
        <label class="form__label">*Your email</label>
        <input type="email" id="Email" name="Email" class="form__input" required>
        <div style="margin-top: 20px"></div>
        <button type="submit" class="form__button">Send</button>
    </div>
     </div>
     

</div>
</form>

 <!-- Modal -->
<div id="resetModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Bonjour,</p>
    <p>Vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le lien ci-dessous :</p>

    @if(session('link'))
  <p><a href="{{ session('link') }}">{{ session('link') }}</a></p>
@endif

    <p>Ce lien est valable 24 heures.</p>
    <p>Merci,<br>L’équipe MenuSwip</p>
  </div>
</div>


  @if(session('status'))
    <script>
      // Afficher le modal si le statut est présent
      window.onload = function() {
        document.getElementById('resetModal').style.display = "block";
      }
    </script>
  @endif

  @if($errors->any())
    <div style="color: red; margin-bottom: 15px;">
      {{ $errors->first('Email') }}
    </div>
  @endif

  <script>
    // Fermer le modal quand on clique sur la croix
    var modal = document.getElementById("resetModal");
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
      modal.style.display = "none";
    }
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>

        <img class="deco-image" src="{{asset('images\white-vegetable-healthy-fresh-natural-10.png')}}" />
        
        <img class="deco-image-1" src="{{asset('images\white-vegetable-healthy-fresh-natural-10.png')}}" />

    </body>

  <!--footer section-->
<footer class="footer">
    <div class="footer__container">
        <!-- Left Column -->
        <div class="footer__brand">
            <div class="footer__logo">
            <img src="{{ asset('images/logo 1.png') }}" alt="MenuSwip Logo" class="footer__logo-img">
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
