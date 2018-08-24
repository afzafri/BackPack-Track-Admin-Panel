<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BackPack Track</title>

  <!-- PLUGINS CSS STYLE -->
  <!-- Bootstrap -->
  <link href="{{ asset('landingpage/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Themefisher Font -->
  <link href="{{ asset('landingpage/plugins/themefisher-font/style.css') }}" rel="stylesheet">
  <!-- Slick Carousel -->
  <link href="{{ asset('landingpage/plugins/slick/slick.css') }}" rel="stylesheet">
  <!-- Slick Carousel Theme -->
  <link href="{{ asset('landingpage/plugins/slick/slick-theme.css') }}" rel="stylesheet">

  <!-- CUSTOM CSS -->
  <link href="{{ asset('landingpage/css/style.css') }}" rel="stylesheet">

  <!-- FAVICON -->
  <link href="{{ asset('landingpage/images/favicon.png') }}" rel="shortcut icon">

</head>

<body class="body-wrapper">


<nav class="navbar main-nav fixed-top navbar-expand-lg">
  <div class="container">
      <a class="navbar-brand" href="homepage.html"><img src="{{ asset('landingpage/images/logo_bp.png') }}" alt="logo"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="tf-ion-android-menu"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link scrollTo" href="#home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link scrollTo" href="#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link scrollTo" href="#feature">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link scrollTo" href="#download">Download</a>
        </li>
        <li class="nav-item">
          <a class="nav-link scrollTo" href="#testimonial">Testimonial</a>
        </li>
        <li class="nav-item">
          <a class="nav-link scrollTo" href="#contact">Contact</a>
        </li>
      </ul>
      </div>
  </div>
</nav>
<!--=====================================
=            Homepage Banner            =
======================================-->

<section class="banner bg-1" id="home">
	<div class="container">
		<div class="row">
			<div class="col-md-8 align-self-center">
				<!-- Contents -->
				<div class="content-block">
					<h1>BackPack Track</h1>
					<h5>Track and Record your trip itinerary and budget on the go</h5>
					<!-- App Badge -->
					<div class="app-badge">
						<ul class="list-inline">
							<li class="list-inline-item">
								<a href="#"><img class="img-fluid" src="{{ asset('landingpage/images/app-badge/google-play.png') }}" alt="google-play"></a>
							</li>
              <li class="list-inline-item">
                <a href="#"><img class="img-fluid" src="{{ asset('landingpage/images/app-badge/app-store.png') }}" alt="app-store"></a>
              </li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<!-- App Image -->
				<div class="image-block">
					<img class="img-fluid" src="{{ asset('landingpage/images/phones/pixel-banner.png') }}" alt="pixel-banner">
				</div>
			</div>
		</div>
	</div>
</section>

<!--====  End of Homepage Banner  ====-->

<!--===========================
=            About            =
============================-->

<section class="about section bg-2" id="about">
	<div class="container">
		<div class="row">
			<div class="col-lg-5 mr-auto">
				<!-- Image Content -->
				<div class="image-block">
					<img src="{{ asset('landingpage/images/phones/pixel-feature.png') }}" alt="pixel-feature" class="img-fluid">
				</div>
			</div>
			<div class="col-lg-6 col-md-10 m-md-auto align-self-center ml-auto">
				<div class="about-block">
					<!-- About 01 -->
					<div class="about-item">
						<div class="icon">
							<i class="tf-ion-ios-paper-outline"></i>
						</div>
						<div class="content">
							<h5>Trip Itinerary Planning and Sharing</h5>
							<p>Help backpackers to record and share their travel trip itineraries that can be used for future trip planning references</p>
						</div>
					</div>
					<!-- About 02 -->
					<div class="about-item active">
						<div class="icon">
							<i class="tf-ion-calculator"></i>
						</div>
						<div class="content">
							<h5>Budget Management</h5>
							<p>Useful for tracking the budget spends during the whole trip</p>
						</div>
					</div>
					<!-- About 03 -->
					<div class="about-item">
						<div class="icon">
							<i class="tf-globe"></i>
						</div>
						<div class="content">
							<h5>Connect with Community</h5>
							<p>Provide a platform for backpacker’s community because it will allow them to connect with each other</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!--====  End of About  ====-->

<!--==============================
=            Features            =
===============================-->

<section class="section feature" id="feature">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title">
					<h2>App Features</h2>
					<p>BackPack Track offers a lot of features that will fulfil every backpacker's needs</p>
				</div>
			</div>
		</div>
		<div class="row bg-elipse">
			<div class="col-lg-4 align-self-center text-center text-lg-right">
				<!-- Feature Item -->
				<div class="feature-item">
					<!-- Icon -->
					<div class="icon">
						<i class="tf-circle-compass"></i>
					</div>
					<!-- Content -->
					<div class="content">
						<h5>Beautiful Interface Design</h5>
						<p>User friendly and intuitive user interface design to ensure the ease of use</p>
					</div>
				</div>
				<!-- Feature Item -->
				<div class="feature-item">
					<!-- Icon -->
					<div class="icon">
						<i class="tf-ion-chatbubble-working"></i>
					</div>
					<!-- Content -->
					<div class="content">
						<h5>Leave comments on itineraries</h5>
						<p>Voice out your oppinions, critiques or experiences with other users</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 text-center">
				<!-- Feature Item -->
				<div class="feature-item mb-0">
					<!-- Icon -->
					<div class="icon">
						<i class="tf-ion-share"></i>
					</div>
					<!-- Content -->
					<div class="content">
						<h5>Itinerary Sharing</h5>
						<p>Share your trip itineraries and experiences with other users across the world</p>
					</div>
				</div>
				<div class="app-screen">
					<img class="img-fluid" src="{{ asset('landingpage/images/phones/pixel-createitinerary.png') }}" alt="backpacktrack">
				</div>
				<!-- Feature Item -->
				<div class="feature-item">
					<!-- Icon -->
					<div class="icon">
						<i class="tf-ion-android-camera"></i>
					</div>
					<!-- Content -->
					<div class="content">
						<h5>Take pictures and view pictures of new places</h5>
						<p>Take pictures of the interesting places visited and share with others</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 text-center text-lg-left align-self-center">
				<!-- Feature Item -->
				<div class="feature-item">
					<!-- Icon -->
					<div class="icon">
						<i class="tf-ion-ios-location"></i>
					</div>
					<!-- Content -->
					<div class="content">
						<h5>Geo Location Technology</h5>
						<p>Use GPS and Geo Location to record accurate place location</p>
					</div>
				</div>
				<!-- Feature Item -->
				<div class="feature-item">
					<!-- Icon -->
					<div class="icon">
						<i class="tf-ion-android-map"></i>
					</div>
					<!-- Content -->
					<div class="content">
						<h5>Discover new interesting locations and places</h5>
						<p>Learn about new interesting places for visiting through the itineraries</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!--====  End of Features  ====-->

<!--=============================================
=            Call to Action Download            =
==============================================-->

<section class="cta-download bg-3 overlay" id="download">
	<div class="container">
		<div class="row">
			<div class="col-lg-5">
				<div class="image-block"><img class="img-fluid" src="{{ asset('landingpage/images/phones/pixel-viewitinerary.png') }}" alt="backpacktrack"></div>
			</div>
			<div class="col-lg-7">
				<div class="content-block">
					<!-- Title -->
					<h2>Free Download Now</h2>
					<!-- Desctcription -->
					<p>Join the fun now and start exploring the world with others!</p>
					<!-- App Badge -->
					<div class="app-badge">
						<ul class="list-inline">
							<li class="list-inline-item">
								<a href="#"><img class="img-fluid" src="{{ asset('landingpage/images/app-badge/google-play.png') }}" alt="google-play"></a>
							</li>
              <li class="list-inline-item">
                <a href="#"><img class="img-fluid" src="{{ asset('landingpage/images/app-badge/app-store.png') }}" alt="app-store"></a>
              </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!--====  End of Call to Action Download  ====-->

<!--=============================
=            Counter            =
==============================-->

<section class="section counter bg-gray">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-6">
				<div class="counter-item">
					<!-- Counter Number -->
					<h3>29k</h3>
					<!-- Counter Name -->
					<p>Download</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="counter-item">
					<!-- Counter Number -->
					<h3>200k</h3>
					<!-- Counter Name -->
					<p>Active Account</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="counter-item">
					<!-- Counter Number -->
					<h3>60k</h3>
					<!-- Counter Name -->
					<p>Happy User</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="counter-item">
					<!-- Counter Number -->
					<h3>300k<sup>+</sup></h3>
					<!-- Counter Name -->
					<p>Download</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!--====  End of Counter  ====-->

<!--=================================
=            Testimonial            =
==================================-->

<section class="section testimonial bg-primary-shape" id="testimonial">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title">
					<h2 class="text-white">Our Happy Customers</h2>
					<p class="text-white">Demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee idea of denouncing pleasure and praising</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 m-auto">
				<!-- Testimonial Carosel -->
<div class="testimonial-slider">
	<!-- testimonial item -->
	<div class="testimonial-item">
		<div class="content">
			<div class="name">
				<h5>Barry Allen</h5>
			</div>
			<div class="pos-in-com">
				<p>Casual Backpackers from <span>Malaysia</span></p>
			</div>
			<div class="speech">
				<p>This apps have helped me to plan my trip itineraries and discover new interesting places! </p>
			</div>
			<ul class="rating list-inline">
				<li class="list-inline-item">
					<i class="tf-ion-android-star"></i>
					<i class="tf-ion-android-star"></i>
					<i class="tf-ion-android-star"></i>
					<i class="tf-ion-android-star"></i>
					<i class="tf-ion-android-star"></i>
				</li>
			</ul>		</div>
		<div class="image">
			<img class="img-fluid" src="{{ asset('landingpage/images/testimonial/review-person-one.png') }}" alt="testimonial-person">
		</div>
	</div>
  <!-- testimonial item -->
  <div class="testimonial-item">
    <div class="content">
      <div class="name">
        <h5>Bruce Wayne</h5>
      </div>
      <div class="pos-in-com">
        <p>Travellers from <span>United State</span></p>
      </div>
      <div class="speech">
        <p>I meet new backpackers and friends through this apps! </p>
      </div>
      <ul class="rating list-inline">
        <li class="list-inline-item">
          <i class="tf-ion-android-star"></i>
          <i class="tf-ion-android-star"></i>
          <i class="tf-ion-android-star"></i>
          <i class="tf-ion-android-star"></i>
          <i class="tf-ion-android-star"></i>
        </li>
      </ul>		</div>
    <div class="image">
      <img class="img-fluid" src="{{ asset('landingpage/images/testimonial/person-two.png') }}" alt="testimonial-person">
    </div>
  </div>
</div>
			</div>
		</div>
	</div>
</section>


<!--====  End of Testimonial  ====-->

<section class="section cta-subscribe" id="contact">
	<div class="container">
		<div class="row bg-elipse-red">
			<div class="col-lg-4">
				<div class="image"><img src="{{ asset('landingpage/images/phones/pixel-budgets.png') }}" alt="backpacktrack-app"></div>
			</div>
			<div class="col-lg-8 align-self-center">
				<div class="content">
					<div class="title">
						<h2>Subscribe Our Newsletter</h2>
					</div>
					<div class="description">
						<p>Subscribe to get exciting deals and news from us in the future</p>
					</div>
					<form action="#">
						<div class="input-group">
						    <input type="text" class="form-control main" placeholder="Enter your email address">
						    <span class="input-group-addon tf-ion-android-send" id="btnGroupAddon"></span>
						  </div>
					</form>
					<div class="subscription-tag text-right">
						<p>Subscribe To Our Newsletter & Stay Updated</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!--============================
=            Footer            =
=============================-->

<footer class="footer-main">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 mr-auto">
          <div class="footer-logo">
            <img src="{{ asset('landingpage/images/logo_bp.png') }}" alt="footer-logo">
          </div>
          <div class="copyright">
            <p>
              @2018 BackPack Track All Rights Reserved  | Afif Zafri
            </p>
          </div>
        </div>
        <div class="col-lg-6 text-lg-right">
          <!-- Social Icons -->
          <ul class="social-icons list-inline">
            <li class="list-inline-item">
              <a href="https://www.facebook.com/afzafri"><i class="tf-ion-social-facebook"></i></a>
            </li>
            <li class="list-inline-item">
              <a href="https://twitter.com/afzafri"><i class="tf-ion-social-twitter"></i></a>
            </li>
            <li class="list-inline-item">
              <a href="https://www.linkedin.com/in/afifzafri/"><i class="tf-ion-social-linkedin"></i></a>
            </li>
            <li class="list-inline-item">
              <a href="https://www.instagram.com/afzafri/"><i class="tf-ion-social-instagram-outline"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
</footer>



  <!-- JAVASCRIPTS -->

  <script src="{{ asset('landingpage/plugins/jquery/jquery.js') }}"></script>
  <script src="{{ asset('landingpage/plugins/popper/popper.min.js') }}"></script>
  <script src="{{ asset('landingpage/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('landingpage/plugins/waypoints/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('landingpage/plugins/slick/slick.min.js') }}"></script>
  <script src="{{ asset('landingpage/plugins/smoothscroll/SmoothScroll.min.js') }}"></script>
  <script src="{{ asset('landingpage/js/custom.js') }}"></script>

</body>

</html>
