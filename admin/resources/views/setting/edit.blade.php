@extends('layouts.main')
@section('title'){{ 'Setting Edit' }}@endsection
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
                        <h3>Setting Edit</h3>
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
                            <form class="form-wizard" action="{{ route('setting.update', $setting->settingId) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="companyName">Company Name</label>
                                            <input class="form-control" id="companyName" name="companyName" type="text" placeholder="Company Name" value="{{ @$setting->companyName }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('companyName') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email">Company Email</label>
                                            <input class="form-control" id="email" name="email" type="email" placeholder="Company Email" value="{{ @$setting->email }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('email') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="logo">Logo White</label>
                                            <input class="form-control" id="logo" name="logo" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('logo') }}</b></span>
                                        </div>
                                        @if(isset($setting->logo))
                                        <div class="mb-3">
                                            <img height="100px" width="100px" src="{{ url(@$setting->logo) }}" alt="">
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <label for="logoDark">Logo Dark</label>
                                            <input class="form-control" id="logoDark" name="logoDark" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('logoDark') }}</b></span>
                                        </div>
                                        @if(isset($setting->logoDark))
                                            <div class="mb-3">
                                                <img height="100px" width="100px" src="{{ url(@$setting->logoDark) }}" alt="">
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <label for="address">Company Address</label>
                                            <input class="form-control" id="address" name="address" type="text" placeholder="Company Address" value="{{ @$setting->address }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('address') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="googleMapLink">Google Map Link</label>
                                            <input class="form-control" id="googleMapLink" name="googleMapLink" type="text" placeholder="Google Map Link" value="{{ @$setting->googleMapLink }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('googleMapLink') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone">Company Phone</label>
                                            <input class="form-control" id="phone" name="phone" type="text" placeholder="Company Phone" value="{{ @$setting->phone }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('phone') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="facebook">Facebook</label>
                                            <input class="form-control" id="facebook" name="facebook" type="text" placeholder="Facebook" value="{{ @$setting->facebook }}">
                                            <span class="text-danger"><b>{{  $errors->first('facebook') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="twitter">Twitter</label>
                                            <input class="form-control" id="twitter" name="twitter" type="text" placeholder="Twitter" value="{{ @$setting->twitter }}">
                                            <span class="text-danger"><b>{{  $errors->first('twitter') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="instagram">Instagram</label>
                                            <input class="form-control" id="instagram" name="instagram" type="text" placeholder="Instagram" value="{{ @$setting->instagram }}">
                                            <span class="text-danger"><b>{{  $errors->first('instagram') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="contactText1">Contact Text 1</label>
                                            <textarea class="form-control" id="contactText1" name="contactText1" placeholder="contactText1">{!! @$setting->contactText1 !!}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('contactText1') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Footer Text</label>
                                            <textarea class="form-control" id="" name="contactText2" placeholder="Contact Text 2">{!! @$setting->contactText2 !!}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('contactText2') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="openingHoursText1">Opening Hours Text 1</label>
                                            <input class="form-control" id="openingHoursText1" name="openingHoursText1" type="text" placeholder="Opening Hours Text 1" value="{{ @$setting->openingHoursText1 }}">
                                            <span class="text-danger"><b>{{  $errors->first('openingHoursText1') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="openingHoursText2">Opening Hours Text 2</label>
                                            <input class="form-control" id="openingHoursText2" name="openingHoursText2" type="text" placeholder="Opening Hours Text 2" value="{{ @$setting->openingHoursText2 }}">
                                            <span class="text-danger"><b>{{  $errors->first('openingHoursText2') }}</b></span>
                                        </div> 
                                        
                                        <div class="mb-3">
                                            <label for="FreeDeliveryArea">Free Delivery Area</label>
                                            <input class="form-control" id="" name="free_delivery_area" type="text" placeholder="Free Delivery Area" value="{{ @$setting->free_delivery_area }}">
                                            <span class="text-danger"><b>{{  $errors->first('free_delivery_area') }}</b></span>
                                        </div> 

                                        <div class="mb-3">
                                            <label for="returnPolicy">Return Policy</label>
                                            <input class="form-control" id="" name="return_policy" type="text" placeholder="Return Policy" value="{{ @$setting->return_policy }}">
                                            <span class="text-danger"><b>{{  $errors->first('return_policy') }}</b></span>
                                        </div> 

                                        
                                        <div class="mb-3">
                                            <label for="paymentHour">Payment Hour</label>
                                            <input class="form-control" id="" name="payment_hour" type="text" placeholder="Payment Hour" value="{{ @$setting->payment_hour}}">
                                            <span class="text-danger"><b>{{ $errors->first('payment_hour') }}</b></span>
                                        </div> 

                                        <div class="mb-3">
                                            <label for="freeDeliveryArea">Free Shipping Policy</label>
                                            <input class="form-control" id="" name="free_shipping_policy" type="text" placeholder="Free Shipping Policy" value="{{ @$setting->free_shipping_policy}}">
                                            <span class="text-danger"><b>{{ $errors->first('free_shipping_policy') }}</b></span>
                                        </div> 

                                        <div class="mb-3">
                                            <label for="shippingCost">Shipping Cost</label>
                                            <input class="form-control" id="" name="shipping_cost" type="number" placeholder="Shipping Cost" value="{{ @$setting->shipping_cost}}">
                                            <span class="text-danger"><b>{{ $errors->first('setting->shipping_cost') }}</b></span>
                                        </div> 

                                        <div class="mb-3">
                                            <label for="minPriceRange">Min Price Range</label>
                                            <input class="form-control" id="" name="min_price_range" type="number" placeholder="Min Price Range" value="{{ @$setting->min_price_range}}">
                                            <span class="text-danger"><b>{{ $errors->first('min_price_range') }}</b></span>
                                        </div> 

                                        <div class="mb-3">
                                            <label for="maxPriceRange">Max Price Range</label>
                                            <input class="form-control" id="" name="max_price_range" type="number" placeholder="Max Price Range" value="{{ @$setting->max_price_range}}">
                                            <span class="text-danger"><b>{{ $errors->first('max_price_range') }}</b></span>
                                        </div> 
                                      
                                  
                                      
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('setting.show') }}">Cancel</a></button>
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
@section('footer.js')
    <script>
        $(document).ready( function () {
            CKEDITOR.replace( 'contactText1');            
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
