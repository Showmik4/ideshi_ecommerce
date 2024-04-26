<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    @if(isset($setting->logoDark))   
    <link rel="icon" href="{{ $setting->logo}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ $setting->logo }}" type="image/x-icon">
    @else
    <link rel="icon" href="{{ url('public/assets/images/logo.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ url('public/assets/images/logo.png') }}" type="image/x-icon">
    @endif
    @if(\Request::route()->getName() === 'index')
        <title>Dashboard | Ideshi</title>
    @elseif(\Request::route()->getName() === 'login')
        <title>Login | Ideshi</title>
    @else
        <title>@yield('title') | Ideshi</title>
    @endif
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <!-- <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.css"> -->

    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/vendors/feather-icon.css') }}">

    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/vendors/animate.css') }}">
{{--    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/vendors/chartist.css') }}">--}}
    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/vendors/date-picker.css') }}">
    <!-- Plugins css Ends-->

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ url('public/assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/custom.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/vendors/datatables.css') }}">
    <!-- toastr -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @yield('header.css')
</head>
<!-- END: Head-->
