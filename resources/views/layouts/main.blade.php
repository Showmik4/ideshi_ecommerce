<!doctype html>
<html>
@include('layouts.partials.header')

<body>
  <!--====== Header Start ======-->
  <header class="py-3 py-lg-4">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6 col-lg-2">
          <div class="logo-box border-end">
            <a href="{{route('index')}}">
              @isset($setting->logoDark)
              <img src="{{ url('admin/'.@$setting->logoDark) }}" alt="logo" class="img-fluid">
              @endisset.
            </a>
          </div>
        </div>
        {{-- <div class="col-6 col-lg-4 d-none d-lg-block">
          <form action="" id="searchform">
            <div class="search-box input-group">
              <input type="text" class="form-control" name="search_text" id="search_text" placeholder="Search"
                onchange="filterChange()">
              <span class="input-group-text bg-black text-white" id="basic-addon2"><i
                  class="fa-solid fa-magnifying-glass"></i></span>
            </div>
          </form>
        </div> --}}
        <div class="col-6 col-lg-4 d-none d-lg-block">
          <form id="searchForm" action="{{ route('shop') }}" method="GET">
            <div class="search-box input-group">
              <input type="text" class="form-control" name="search_text" id="search_text">
              <span class="input-group-text bg-black text-white" id="basic-addon2"><i
                  class="fa-solid fa-magnifying-glass"></i></span>
            </div>
          </form>
        </div>
        <div class="col-6 col-lg-2 d-none d-lg-block">
          <div class="icon-box border-end">
            <div class="d-flex flex-wrap align-items-center gap-2">
              <div>
                <img src="{{asset('public/assets/images/icons/telephone.svg')}}" alt="telephone')}}">
              </div>
              <div>
                <h6 class="mb-0">{{ @$setting->phone}}</h6>
                <p class="text-ash">Call us free</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-2 d-none d-lg-block">
          <div class="icon-box ps-3">
            <div class="d-flex flex-wrap align-items-center gap-2">
              <div>
                <img src="{{asset('public/assets/images/icons/truck.svg')}}" alt="truck">
              </div>
              <div>
                <h6 class="mb-0">FREE SHIPPING</h6>
                <p class="text-ash">{{ @$setting->free_shipping_policy}}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-2">
          <ul class="icon-list d-flex flex-wrap justify-content-end gap-3">
            <li>
              <a href="{{route('account')}}">
                <img src="{{asset('public/assets/images/icons/profile.svg')}}" alt="icon">
              </a>
            </li>
            <li>
              <a href="{{route('product.wishlist')}}">
                <img src="{{asset('public/assets/images/icons/wishlist.svg')}}" alt="icon">
              </a>
            </li>
            <li>
              <a href="{{route('product.view_cart')}}" id="openCartModalButton" class="position-relative">
                <img src="{{asset('public/assets/images/icons/bag.svg')}}" alt="icon">
                <span id="cartQuantityHeader">
                  <span
                    class="cart-no bg-red text-white rounded-circle position-absolute">{{\Cart::getContent()->count()}}</span>
                </span>
                {{-- <span
                  class="cart-no bg-red text-white rounded-circle position-absolute">{{\Cart::getContent()->count()}}</span>
                --}}
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- mobile search -->
      {{-- <div class="d-lg-none pt-3">
        <form action="" class=" ">
          <div class="search-box input-group">
            <input type="search" class="form-control" name="search_text" id="search_text" placeholder="Search">
            <span class="input-group-text bg-black text-white" id="basic-addon2"><i
                class="fa-solid fa-magnifying-glass"></i></span>
            <button type="submit">Search</button>
          </div>
        </form>
      </div> --}}
    </div>
  </header>
  <!--====== Header End ======-->

  @yield('main.content')



  <!--====== footer start ======-->
  @include('layouts.partials.footer')
  <!--====== footer end ======-->
  @include('layouts.partials.cart')
  <!-- JS here -->

  @include('layouts.partials.scripts')
</body>

</html>