@extends('layouts.main')
@section('title'){{ 'Setting Create' }}@endsection
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
                        <h3>Setting Create</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Setting</li>
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
                            <form class="form-wizard" action="{{ route('setting.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="companyName">Company Name</label>
                                            <input class="form-control" id="companyName" name="companyName" type="text" placeholder="Company Name" value="{{ old('companyName') }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('companyName') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email">Company Email</label>
                                            <input class="form-control" id="email" name="email" type="email" placeholder="Company Email" value="{{ old('email') }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('email') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="logo">Logo</label>
                                            <input class="form-control" id="logo" name="logo" type="file" required>
                                            <span class="text-danger"><b>{{ $errors->first('logo') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="logoDark">Logo Dark</label>
                                            <input class="form-control" id="logoDark" name="logoDark" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('logoDark') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="address">Company Address</label>
                                            <input class="form-control" id="address" name="address" type="text" placeholder="Company Address" value="{{ old('address') }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('address') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="googleMapLink">Google Map Link</label>
                                            <input class="form-control" id="googleMapLink" name="googleMapLink" type="text" placeholder="Google Map Link" value="{{ old('googleMapLink') }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('googleMapLink') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone">Company Phone</label>
                                            <input class="form-control" id="phone" name="phone" type="text" placeholder="Company Phone" value="{{ old('phone') }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('phone') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="facebook">Facebook</label>
                                            <input class="form-control" id="facebook" name="facebook" type="text" placeholder="Facebook" value="{{ old('facebook') }}">
                                            <span class="text-danger"><b>{{  $errors->first('facebook') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="twitter">Twitter</label>
                                            <input class="form-control" id="twitter" name="twitter" type="text" placeholder="Twitter" value="{{ old('twitter') }}">
                                            <span class="text-danger"><b>{{  $errors->first('twitter') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="instagram">Instagram</label>
                                            <input class="form-control" id="instagram" name="instagram" type="text" placeholder="Instagram" value="{{ old('instagram') }}">
                                            <span class="text-danger"><b>{{  $errors->first('instagram') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="contactText1">Contact Text 1</label>
                                            <textarea class="form-control" id="contactText1" name="contactText1" placeholder="Contact Text 1">{{ old('contactText1') }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('contactText1') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="contactText2">Contact Text 2</label>
                                            <textarea class="form-control" id="contactText2" name="contactText2" placeholder="Contact Text 2">{{ old('contactText2') }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('contactText2') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="openingHoursText1">Opening Hours Text 1</label>
                                            <input class="form-control" id="openingHoursText1" name="openingHoursText1" type="text" placeholder="Opening Hours Text 1" value="{{ old('openingHoursText1') }}">
                                            <span class="text-danger"><b>{{  $errors->first('openingHoursText1') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="openingHoursText2">Opening Hours Text 2</label>
                                            <input class="form-control" id="openingHoursText2" name="openingHoursText2" type="text" placeholder="Opening Hours Text 2" value="{{ old('openingHoursText2') }}">
                                            <span class="text-danger"><b>{{  $errors->first('openingHoursText2') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="careerText">Career Text</label>
                                            <textarea class="form-control" id="careerText" name="careerText" placeholder="Career Text">{{ old('careerText') }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('careerText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="aboutImage">About Image</label>
                                            <input class="form-control" id="aboutImage" name="aboutImage" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('aboutImage') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="aboutTitle">About Title</label>
                                            <textarea class="form-control" id="aboutTitle" name="aboutTitle" placeholder="About Title">{{ old('aboutTitle') }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('aboutTitle') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="aboutTop">About Top</label>
                                            <textarea class="form-control" id="aboutTop" name="aboutTop" placeholder="About Top">{{ old('aboutTop') }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('aboutTop') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="aboutLeftText">About Left Text</label>
                                            <textarea class="form-control" id="aboutLeftText" name="aboutLeftText" placeholder="About Left Text">{{ old('aboutLeftText') }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('aboutLeftText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="aboutRightText">About Right Text</label>
                                            <textarea class="form-control" id="aboutRightText" name="aboutRightText" placeholder="About Right Text">{{ old('aboutRightText') }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('aboutRightText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeCategoryText">Home Category Text</label>
                                            <textarea class="form-control" id="homeCategoryText" name="homeCategoryText" placeholder="Home Category Text">{{ old('homeCategoryText') }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('homeCategoryText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeNewProductText">Home New Product Text</label>
                                            <input class="form-control" id="homeNewProductText" name="homeNewProductText" type="text" placeholder="Home New Product Text" value="{{ old('homeNewProductText') }}">
                                            <span class="text-danger"><b>{{  $errors->first('homeNewProductText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeNewProductImage">Home New Product Image</label>
                                            <input class="form-control" id="homeNewProductImage" name="homeNewProductImage" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('homeNewProductImage') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeMostPopularText">Home Most Popular Text</label>
                                            <input class="form-control" id="homeMostPopularText" name="homeMostPopularText" type="text" placeholder="Home Most Popular Text" value="{{ old('homeMostPopularText') }}">
                                            <span class="text-danger"><b>{{  $errors->first('homeMostPopularText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeMostPopularImage">Home Most Popular Image</label>
                                            <input class="form-control" id="homeMostPopularImage" name="homeMostPopularImage" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('homeMostPopularImage') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeBestValueText">Home Best Value Text</label>
                                            <input class="form-control" id="homeBestValueText" name="homeBestValueText" type="text" placeholder="Home Best Value Text" value="{{ old('homeBestValueText') }}">
                                            <span class="text-danger"><b>{{  $errors->first('homeBestValueText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeBestValueImage">Home Best Value Image</label>
                                            <input class="form-control" id="homeBestValueImage" name="homeBestValueImage" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('homeBestValueImage') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeAboutUsText">Home About Us Text</label>
                                            <textarea class="form-control" id="homeAboutUsText" name="homeAboutUsText" placeholder="Home About Us Text">{{ old('homeAboutUsText') }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('homeAboutUsText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeAboutUsImage">Home About Us Image</label>
                                            <input class="form-control" id="homeAboutUsImage" name="homeAboutUsImage" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('homeAboutUsImage') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="newProductText">New Product Text</label>
                                            <textarea class="form-control" id="newProductText" name="newProductText" placeholder="New Product Text">{{ old('newProductText') }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('newProductText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeShowroomText">Home Showroom Text</label>
                                            <textarea class="form-control" id="homeShowroomText" name="homeShowroomText" placeholder="Home Showroom Text">{{ old('homeShowroomText') }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('homeShowroomText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeShowroomImage">Home Showroom Image</label>
                                            <input class="form-control" id="homeShowroomImage" name="homeShowroomImage" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('homeShowroomImage') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('setting.show') }}">Cancel</a></button>
                                            <button class="btn btn-primary" type="submit">Create</button>
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
@section('footer.js')
    <script>
        $(document).ready( function () {
            CKEDITOR.replace( 'contactText1');
            CKEDITOR.replace( 'contactText2');
            CKEDITOR.replace( 'careerText');
            CKEDITOR.replace( 'aboutTitle');
            CKEDITOR.replace( 'aboutTop');
            CKEDITOR.replace( 'aboutLeftText');
            CKEDITOR.replace( 'aboutRightText');
            CKEDITOR.replace( 'homeCategoryText');
            CKEDITOR.replace( 'homeAboutUsText');
            CKEDITOR.replace( 'newProductText');
            CKEDITOR.replace( 'homeShowroomText');
        });
    </script>
@endsection
