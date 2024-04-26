<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>iDeshi | Home</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">	
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ @$setting->logo}}">
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
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @yield('header.css')

</head>