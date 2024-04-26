<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>iDeshi | Register</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
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
<body id="register-background"> 
    <section class="vh-100 gradient-custom1">
        <div class="container py-5 h-100">
          <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7">
              <div class="card bg-dark card-registration" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                    <p class="text-center mb-2">
						<a href="{{ url('/') }}"><img src="{{ url('admin/'.@$setting->logoDark) }}" alt="logo" class="img-fluid"></a>
					</p>
                  <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 text-center">Registration Form</h3>
                  <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 mb-4">      
                        <div class="form-outline">
                          <input type="text" id="firstName" name="firstName" class="form-control form-control-lg" name="firstName" value="{{ old('firstName') }}" required/>                            
                          <label class="form-label" for="firstName">First Name</label>
                          <div>
                            <span class="text-danger mb-2"><b>{{ $errors->first('firstName') }}</b></span>
                          </div>
                        </div>      
                      </div>
                    <div class="col-md-6 mb-4">      
                        <div class="form-outline">
                          <input type="text" id="lastName" class="form-control form-control-lg" name="lastName" value="{{ old('lastName') }}" required/>                         
                          <label class="form-label" for="lastName">Last Name</label>
                          <div>
                            <span class="text-danger"><b>{{ $errors->first('lastName') }}</b></span>  
                          </div>
                        </div>      
                      </div>
                    </div>  

                    <div class="row">
                      <div class="col-md-6 mb-4 pb-2">      
                        <div class="form-outline">
                          <input type="email" id="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" required />
                          <label class="form-label" for="emailAddress">Email</label>
                          <div>
                            <span class="text-danger mb-2"><b>{{ $errors->first('email') }}</b></span>  
                          </div>                          
                        </div>
      
                      </div>
                      <div class="col-md-6 mb-4 pb-2">      
                        <div class="form-outline">
                          <input type="tel" id="phone" name="phone" class="form-control form-control-lg" value="{{ old('phone') }}" required/>                    
                          <label class="form-label" for="phoneNumber">Phone Number</label>
                          <div>
                            <span class="text-danger mb-2"><b>{{ $errors->first('phone') }}</b></span>  
                          </div>      
                        </div>      
                      </div>
                    </div>  

                    <div class="row">
                        <div class="col-md-6 mb-4 pb-2">      
                          <div class="form-outline">
                            <input type="password" id="password" class="form-control form-control-lg" name="password" value="{{ old('password') }}" required />                            
                            <label class="form-label" for="emailAddress">Password</label>
                            <div>
                                <span class="text-danger mb-2"><b>{{ $errors->first('password') }}</b></span>
                            </div>                           

                          </div>        
                        </div>
                        <div class="col-md-6 mb-4 pb-2">      
                          <div class="form-outline">
                            <input type="password" id="confirm_password" name="password_confirmation" class="form-control form-control-lg" value="{{ old('password') }}" required/>
                             
                            <label class="form-label" for="phoneNumber">Confirm Password</label>
                            <div>
                                <span class="text-danger mb-2"><b>{{ $errors->first('password_confirmation') }}</b></span>
                            </div>                            
                          </div>      
                        </div>
                    </div>
     
                    <div class="mt-4 pt-2" style="text-align: center">
                      <input class="btn btn-primary btn-lg" type="submit" value="Submit"/>
                    </div> 
                    <div class="mt-4 pt-2" style="text-align: center">
                        <label>Back to Login<a href="{{route('login')}}" class="text-primary"> Login</a></label>
                      </div>
                    
                  </form>
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