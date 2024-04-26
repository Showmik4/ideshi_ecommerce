@extends('layouts.main')
@section('title'){{ 'User Profile' }}@endsection
@section('header.css')
    <style>

    </style>
@endsection
@section('main.content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>User Profile</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">User</li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-wizard" action="{{ route('user.updateProfile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <h5>Basic Information</h5>
                                        <hr>
                                        <div class="mb-3">
                                            <label for="firstName">First Name</label>
                                            <input class="form-control" id="firstName" name="firstName" type="text" placeholder="Enter First Name" value="{{ $user->firstName ?? old('firstName') }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('firstName') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="lastName">Last Name</label>
                                            <input class="form-control" id="lastName" name="lastName" type="text" placeholder="Enter Last Name" value="{{ $user->lastName ?? old('lastName') }}">
                                            <span class="text-danger"><b>{{  $errors->first('lastName') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone">Phone</label>
                                            <input class="form-control" id="phone" name="phone" type="text" placeholder="Enter Phone" value="{{ $user->phone ?? old('phone') }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('phone') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email">Email</label>
                                            <input class="form-control" id="email" name="email" type="email" placeholder="Enter Email" value="{{ $user->email ?? old('email') }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('email') }}</b></span>
                                        </div>
                                        <h5>Password Change</h5>
                                        <hr>
                                        <div class="mb-3">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
                                            <span class="text-danger"><b>{{  $errors->first('password') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="new_password">New Password</label>
                                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password">
                                            <span class="text-danger"><b>{{  $errors->first('new_password') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirm_password">Confirm New Password</label>
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm new password">
                                            <span class="text-danger"><b>{{  $errors->first('confirm_password') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('index') }}">Cancel</a></button>
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
