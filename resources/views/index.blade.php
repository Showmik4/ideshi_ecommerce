
@extends('layouts.main')
@section('title'){{ 'Home' }}@endsection
@section('header.css')
    <style>

    </style>
@endsection
@section('main.content')
<main>
	<!--====== banner Start ======-->
  
  <section class="home-main-banner pt-30 pb-60">
    <div class="container">
      <div class="slider owl-carousel owl-theme">
        @foreach ($top_banners as $top_banner)
        <div class="item">
            <a href="{{route('shop')}}">
              <img src="{{ url('admin/'. $top_banner->imageLink) }}" alt="banner" class="img-fluid" style="width:1270;height:635px">
            </a>
          </div> 
        @endforeach    
      </div>
    </div>
  </section>
	<!--====== banner end ======-->

  <!--====== features start ======-->
  <section class="features-area pt-60 pb-60">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-xl-3 mb-3 mb-xl-0">
          <div class="features-item d-flex align-items-center gap-3">
            <div>
              <div class="img-box">
                <img src="{{ asset('public/assets/images/icons/feature-truck.svg')}}" alt="icon" class="img-fluid">
              </div>
            </div>
            <div>
              <h4 class="mb-0">Free Delivery</h4>
              <p class="text-ash">{{@$setting->free_delivery_area}}</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-3 mb-xl-0">
          <div class="features-item d-flex align-items-center gap-3">
            <div>
              <div class="img-box">
                <img src="{{ asset('public/assets/images/icons/feature-time.svg')}}" alt="icon" class="img-fluid">
              </div>
            </div>
            <div>
              <h4 class="mb-0">{{ @$setting->return_policy}}</h4>
              <p class="text-ash">If goods have problems</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-3 mb-xl-0">
          <div class="features-item d-flex align-items-center gap-3">
            <div>
              <div class="img-box">
                <img src="{{ asset('public/assets/images/icons/feature-wallet.svg')}}" alt="icon" class="img-fluid">
              </div>
            </div>
            <div>
              <h4 class="mb-0">Secure Payment</h4>
              <p class="text-ash">100% secure payment</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-3 mb-xl-0">
          <div class="features-item d-flex align-items-center gap-3">
            <div>
              <div class="img-box">
                <img src="{{asset('public/assets/images/icons/feature-chat.svg')}}" alt="icon" class="img-fluid">
              </div>
            </div>
            <div>
              <h4 class="mb-0">{{ @$setting->payment_hour}}</h4>
              <p class="text-ash">Dedicated support</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--====== features end ======-->
		
  <!--====== banner start ======-->
  <section class="two-banner-right-img-area pt-90 pb-90">
    <div class="container">
      <div class="row" id="">
        @foreach ($sale_banners as $sale_banner)
        <div class="col-md-6 mb-3 mb-md-0 pe-lg-3">
          <div class="banner-2 hover-shadow h-100" style="background: url('{{ asset('admin/' . $sale_banner->imageLink) }}');
              background-position: top center;
              background-repeat: no-repeat;
              background-size: cover;">
            <h5 class="text-white">{{$sale_banner->bannerTitle}}</h5>
            @if(isset($sale_banner->banner_description_1))
            <h3 class="text-white">{{$sale_banner->banner_description_1}}</h3>
            @endif
            @if(isset($sale_banner->banner_description_2))
            <h5 class="text-white">{{$sale_banner->banner_description_2}}</h5>
            @endif
            <p class="mt-4 mt-lg-5">
              <a href="{{$sale_banner->pageLink}}" class="btn btn-transparent text-uppercase">shop now</a>
            </p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  <!--====== banner end ======-->
  
  <!--====== new arrival start ======-->
  <section class="new-arrival-area pb-90">
    <div class="container">
      <h3 class="section-heading mb-4 mb-lg-5 ps-4">New Arrival</h3>
      <div class="product-slider owl-carousel owl-theme">
        @foreach ($newArrival as $new_arrival)
        <div class="item">
            <a href="{{ route('product_details', $new_arrival->productId) }}">
              <img src="{{ url('admin/'. $new_arrival->featureImage) }}" alt="product" class="img-fluid mb-4">
              <h5>{{$new_arrival->productName}}</h5>
            </a>
        </div>
        @endforeach         
      </div>
    </div>
  </section>
  <!--====== new arrival end ======-->

  <!--====== big saving start ======-->

  <section class="new-arrival-area pb-90">
    <div class="container">     
      <h3 class="section-heading mb-4 mb-lg-5 ps-4">Big Saving Zone</h3>
        <div class="row">
        @foreach ($saving_banners as $index => $saving_banner)
                <div class="{{ ($index < 3) ? 'col-md-4' : 'col-md-6' }} mb-3">
                    <div class="home-banner-4 hover-shadow h-100" style="background: url('{{ asset('admin/' . $saving_banner->imageLink) }}');
                        background-position: top center;
                        background-repeat: no-repeat;
                        background-size: cover;">
                        <h3 class="text-white">{{$saving_banner->bannerTitle}}</h3>
                        <p class="text-white mb-1">{{$saving_banner->banner_description_1}}</p>
                        <h5 class="text-white">{{$saving_banner->banner_description_2}}</h5>
                        <p class="text-white ps-5 pt-2"><i class="fa-solid fa-arrow-down"></i></p>
                        <p class="text-white mt-4">
                            <a href="{{$saving_banner->pageLink}}" class="btn btn-transparent text-uppercase">shop now</a>
                        </p>
                    </div>
                </div>
                @if (($index + 1) % 5 == 0 && $index < count($saving_banners) - 1)
                    </div>
                    <div class="row">
                @endif
          @endforeach
      </div>
    </div>
  </section>

  <!--====== big saving end ======-->

  <!--======Promo sale banner start ======-->
  <section class="sale-banner-area">
    <div class="container">
      <div class="row align-items-center">
        @foreach ($promo as $promos)                   
        <div class="col-md-6 ps-md-0 mb-3 mb-md-0">
          <img src="{{ url('admin/'. $promos->imageLink) }}" alt="sale" class="img-fluid w-100">
        </div>
        <div class="col-md-6">
          <div class="text-box pt-3 pt-lg-5 pb-4 pb-lg-5">
            <h1 class="mb-2 mb-md-4">
              <span class="white-label">{{$promos->bannerTitle}}</span><br>
              SALE NOW
            </h1>
            @if(isset($promos->promotion) && $promos->promotion->amount > 0)
            <h4 class="font-500 mb-3">Spend minimal ${{intval($promos->promotion->amount)}} get {{$promos->promotion->percentage}}% off <br>
              voucher code for your next purchase
            </h4>
            <h3>{{ \Carbon\Carbon::parse($promos->promotion->startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($promos->promotion->endDate)->format('d M Y') }}</h3>
            @endif
            <p>*Terms & Conditions apply</p>
            <p class="mt-4 mt-lg-5">
              <a href="{{$promos->pageLink}}" class="btn text-uppercase">shop now</a>
            </p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  <!--======Promo sale banner end ======-->

  <!--====== categories start ======-->
  <section class="home-categories-area pt-70 pb-70">
    <div class="container">
      <h3 class="section-heading mb-4 mb-lg-5 ps-4">Categories For Men</h3>
      <div class="row">
        @foreach ($men_categories as $men_category)
        <div class="col-md-6 col-lg-3 mb-4">
          <div class="cat-item">
            <div class="img-box mb-3">
              <img src="{{ url('admin/'. $men_category->imageLink)}}" alt="category" class="img-fluid">
            </div>
            <div class="d-flex align-items-center">
              <div class="w-75">
                <h5 class="mb-0">{{$men_category->categoryName}}</h5>
                <p>
                  <a class="text-ash" href="{{route('shop', ['categoryId' => $men_category->categoryId])}}">Explore Now!</a>
                </p>
              </div>
              <div class="w-25">
                <p class="text-end">
                  <a href="{{route('shop', ['categoryId' => $men_category->categoryId])}}"><i class="fa-solid fa-arrow-right"></i></a>
                </p>
              </div>
            </div>
          </div>
        </div> 
      @endforeach  
                
      </div>
    </div>
  </section>
  <!--====== categories end ======-->

  <!--====== sale banner 2 start ======-->
  <section class="sale-banner-2-area">
    <div class="container">
      <div class="row align-items-center">
        @foreach ($payday as $paydays)         
          <div class="col-lg-6 pe-md-0 h-100">
          <div class="text-box">
            <h1 class="text-white mb-2 mb-lg-4">
              <span class="white-label">{{Str::limit($paydays->bannerTitle,40)}}</span> <br>
              {{Str::limit($paydays->banner_description_1,15)}}
            </h1>
            <p class="text-white">
              {{Str::limit($paydays->banner_description_2,100)}}
            </p>
            <p class="mt-3">
              <a href="{{$paydays->pageLink}}" class="btn btn-white text-uppercase">shop now</a>
            </p>
          </div>
        </div>
        <div class="col-lg-6 ps-md-0 h-100">
          <div class="img-box">
            <img style="height:640px;width:626px" src="{{ url('admin/'. $paydays->imageLink)}}" alt="" class="img-fluid w-100">
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  <!--====== sale banner 2 end ======-->

  <!--====== categories start ======-->
  <section class="home-categories-area pt-70 pb-70">
    <div class="container">
      <h3 class="section-heading mb-4 mb-lg-5 ps-4">Categories For Women</h3>
      <div class="row">
        @foreach ($women_categories as $women_category)       
        <div class="col-md-6 col-lg-3 mb-4">
          <div class="cat-item">
            <div class="img-box mb-3">
              <img src="{{ url('admin/'. $women_category->imageLink) }}" style=" " alt="category" class="img-fluid">
            </div>
            <div class="d-flex align-items-center">
              <div class="w-75">
                <h5 class="mb-0">{{$women_category->categoryName}}</h5>
                <p>
                  <a class="text-ash" href="{{route('shop', ['categoryId' => $women_category->categoryId])}}">Explore Now!</a>
                </p>
              </div>
              <div class="w-25">
                <p class="text-end">
                  <a href="{{route('shop', ['categoryId' => $women_category->categoryId])}}"><i class="fa-solid fa-arrow-right"></i></a>
                </p>
              </div>
            </div>
          </div>
        </div>
        @endforeach       
      </div>
    </div>
  </section>
  <!--====== categories end ======-->

  <!--====== brand area start ======-->
  <section class="brand-area pt-60 pb-60">
    <div class="container">
      <div class="brand-slider owl-carousel owl-theme">
        @foreach ($brands as $brand)         
        <div class="item text-center">
          <img src="{{ url('admin/'. $brand->brandLogo) }}" alt="brand">
        </div>
        @endforeach
      
      </div>
    </div>
  </section>
  <!--====== brand area end ======-->

  <!--====== subscribe card start ======-->
  <section class="subscribe-card-area pt-100 pb-100">
    <div class="container">
      <div class="wrapper">
        <div class="wrapper-2">
          <div class="row">
            <div class="col-md-6">
              <div class="text-box">
                <h1 class="text-white mb-4">
                  <span class="white-label">SUBSCRIBE</span> <br>
                  OUR NEWS LETTER
                </h1>
                <p class="text-white mb-3 mb-lg-4">
                  Lorem Ipsum is simply dummy text of the printing <br> and typesetting industry.
                </p>
                <form action="">
                  <div class="input-box position-relative">
                    <input type="text" class="form-control" placeholder="Email">
                    <button class="btn position-absolute">Submit</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-md-6">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--====== subscribe card end ======-->
</main>
@endsection
@section('footer.js')
    <script>

    </script>
@endsection