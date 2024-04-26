<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>iDeshi | Home</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/assets/images/favicon.png')}}">
	<!-- CSS here -->
	<!-- Bootstrap css -->
	<link rel="stylesheet" href="{{ asset('public/assets/plugins/bootstrap-5.2.0/css/bootstrap.min.css')}}">	
	<!-- Font-awesome CSS -->
	<link rel="stylesheet" href="{{ asset('public/assets/css/font-awesome-6.2.css')}}">
	<!-- Bootstrap icons CSS -->
	<!-- <link rel="stylesheet" href="public/assets/css/bootstrap-icons.css"> -->
	<!-- Owl carousel -->
	<link rel="stylesheet" href="{{ asset('public/assets/plugins/owl-carousel/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{ asset('public/assets/plugins/owl-carousel/owl.theme.default.css')}}">
	<!-- Magnific popup -->
	<!-- <link rel="stylesheet" href="public/assets/plugins/magnific-popup/magnific-popup.css"> -->
	<!-- Utilities CSS -->
	<link rel="stylesheet" href="{{ asset('public/assets/css/utilities.css')}}">
	<!-- Common CSS -->
	<link rel="stylesheet" href="{{ asset('public/assets/css/common.css')}}">
	<!-- Style CSS -->
	<link rel="stylesheet" href="{{ asset('public/assets/css/style.css')}}">
	<!-- Responsive CSS -->
	<link rel="stylesheet" href="{{ asset('public/assets/css/responsive.css')}}">
</head>
<body id="login-background">   
	<section class="vh-100 gradient-custom">
		<div class="container py-5 h-100">
		  <div class="row d-flex justify-content-center align-items-center h-100">
			<div class="col-12 col-md-8 col-lg-6 col-xl-5">
			  <div class="card bg-dark text-white" style="border-radius: 1rem;">
				<div class="card-body p-5 text-center">
				<form action="{{ route('login') }}" method="POST">
					@csrf
				  <div class="mb-md-5 mt-md-4 pb-5">
					<p class="text-center mb-2">
						<a href="{{ url('/') }}"><img src="{{ url('admin/'.@$setting->logoDark) }}" alt="logo" class="img-fluid"></a>
					</p>
					<h3 class="fw-bold mb-2 text-uppercase">Login</h3>
					<p class="text-white-50 mb-5">Please enter your login and password!</p>
	  
					<div class="form-outline form-white mb-4">
					  <input type="email" id="typeEmailX" name="email" class="form-control form-control-lg" placeholder="Enter Email"/>
					  <label class="form-label" for="typeEmailX">Email</label>
					  <div>
						<span class="text-danger"><b>{{ $errors->first('email') }}</b></span>
					  </div>
					 
					</div>
	  
					<div class="form-outline form-white mb-4">
					  <input type="password" id="typePasswordX" name="password" class="form-control form-control-lg" placeholder="Enter Password"/>
					  <label class="form-label" for="typePasswordX">Password</label>
					  <div>
						<span class="text-danger"><b>{{ $errors->first('password') }}</b></span>
					  </div>					  
					</div>
	  
					{{-- <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p> --}}
	  
					<button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
	  
					{{-- <div class="d-flex justify-content-center text-center mt-4 pt-1">
					  <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
					  <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
					  <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
					</div>	   --}}
				  </div>
				</form>	  
				  <div>
					<p class="mb-0">Don't have an account? <a href="{{route('register')}}" class="text-white-50 fw-bold">Sign Up</a>
					</p>
				  </div>
	  
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </section>

	<!-- JS here -->

	<!-- Modernizr js -->
	<script src="{{ asset('public/assets/js/modernizr-3.5.0.min.js')}}"></script>
	<!-- jquery -->
	<script src="{{ asset('public/assets/js/jquery-3.2.1.min.js')}}"></script>
	<!-- Bootstrap -->
	<script src="{{ asset('public/assets/plugins/bootstrap-5.2.0/js/bootstrap.bundle.min.js')}}"></script>
	{{-- <script src="{{ asset('public/assets/plugins/bootstrap-5.2.0/js/bootstrap.min.js')}}"></script> --}}
	<!-- Owl carousel -->
	<script src="{{ asset('public/assets/plugins/owl-carousel/owl.carousel.min.js')}}"></script>
	<!-- Magnafic popup image/video -->
	<!-- <script src="public/assets/plugins/magnific-popup/magnific-popup.js"></script> -->
	<!-- Counter up -->
	<script src="{{ asset('public/assets/js/waypoints.js')}}"></script>
	<script src="{{ asset('public/assets/js/counterup.js')}}"></script>
	<!-- Custom js -->
	<script src="{{ asset('public/assets/js/all.js')}}"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>
</html>