@extends('layouts.main')
@section('title'){{ 'Profile' }}@endsection
@section('header.css')
    <style>

    </style>
@endsection
@section('main.content')
<main>
    <!--====== breadcumb area start ======-->
    <section class="breadcumb-area">
      <div class="container">
        <ul class="d-flex gap-2">
          <li>
            <a href="{{route('index')}}" class="text-ash">Home</a>
          </li>
          <li>
            <a href="#" class="text-ash"><i class="fa-solid fa-angle-right"></i></a>
          </li>
          <li>
            <a href="#" class="text-ash">Profile</a>
          </li>
        </ul>
      </div>
    </section>
    <!--====== breadcumb area end ======-->

    <!--====== profile page content start ======-->
    <section class="profile-page py-4">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <button class="nav-link active mb-2" data-bs-toggle="pill" data-bs-target="#profile" type="button" role="tab" aria-selected="true">My Profile</button>
              <button class="nav-link mb-2" data-bs-toggle="pill" data-bs-target="#editProfile" type="button" role="tab" aria-selected="false">Edit My Profile</button>
              <button class="nav-link mb-2" data-bs-toggle="pill" data-bs-target="#myOrders" type="button" role="tab" aria-selected="false">My Orders</button>
              {{-- <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">              --}}

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
              
              <button class="nav-link mb-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Logout
              </button>
              {{-- </a> --}}
              {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form> --}}
            </div>
          </div>
          <div class="col-md-9">
            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade p-3 p-lg-4 show active" id="profile" role="tabpanel" tabindex="0">
                <h4 class="section-heading mb-4 ps-3">My Profile</h4>
                <table class="table table-bordered">
                  <tr>
                    <td>
                      <p class="text-ash font-500">Name</p>
                    </td>
                    <td>
                      <p>{{ @$customer->user->firstName.' '.@$customer->user->lastName }}</p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p class="text-ash font-500">Contact No.</p>
                    </td>
                    <td>
                      <p>{{ @$customer->user->phone }}</p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p class="text-ash font-500">EMail</p>
                    </td>
                    <td>
                      <p>{{ @$customer->user->email }}</p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p class="text-ash font-500">Address</p>
                    </td>
                    <td>
                      <p>{{ @$customer->address->billingAddress }}</p>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="tab-pane fade p-3 p-lg-4" id="editProfile" role="tabpanel" tabindex="0">
                <h4 class="section-heading mb-4 ps-3">Update Profile</h4>
                <form action="{{ route('myAccountUpdate', Auth::user()->userId) }}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="" class="form-label">First Name</label>
                      <input type="text" class="form-control" name="firstName" placeholder="Your first name" value="{{ @$customer->user->firstName ?? old('firstName') }}" id="">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="" class="form-label">Last Name</label>
                      <input type="text" class="form-control" name="lastName" placeholder="Your last name" value="{{ @$customer->user->lastName ?? old('lastName') }}" id="">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="" class="form-label">EMail</label>
                      <input type="email" class="form-control" name="email" value="{{ @$customer->user->email ?? old('email') }}" placeholder="Your email" id="">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="" class="form-label">Phone Number</label>
                      <input type="text" class="form-control" name="phone" value="{{ @$customer->user->phone ?? old('phone') }}" placeholder="Your phone number" id="">
                    </div>
                    <div class="col-md-12 mb-3">
                      <label for="" class="form-label">Detail Address</label>
                      <textarea rows="4" class="form-control" name="billingAddress" placeholder="Your details address...">{{ @$customer->address->billingAddress ?? old('billingAddress') }}</textarea>
                    </div>
                  </div>
                  <p class="text-end">
                    <button class="btn">Update Profile</button>
                  </p>
                </form>
              </div>
              <div class="tab-pane fade p-3 p-lg-4" id="myOrders" role="tabpanel" tabindex="0">
                <h4 class="section-heading mb-4 ps-3">My Orders</h4>
                <div class="table-responsive">
                  <table class="table order-table">
                    <thead>
                      <tr>                      
                        <th>product details</th>
                        <th>price</th>
                        <th>quantity</th>
                        <th>shipping</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($orders as $order) 
                      @foreach ($order->orderItems as $orderItem) 
                      @if ($orderItem->sku)                      
                      <tr>                       
                        <td>
                          <div class="prod-detals d-flex gap-2 align-items-center">
                            <div>
                              <a href="product-details.html">
                                <img src="{{ url('admin/'. $orderItem->sku->product->featureImage) }}" alt="product" class="img-fluid">
                              </a>
                            </div>                                                     
                            <div>                              
                              <a href="product-details.html">
                                <h6 class="mb-1">{{ $orderItem->sku->product->productName }}</h6>
                              </a>                              

                              @foreach ($orderItem->sku->variationRelation as $skuVariation)
                              @if ($skuVariation->variation && $skuVariation->variation->variationType == 'Color')
                              <p class="text-ash" style="background-color: {{ $skuVariation->variation->variationValue }}">Color:{{$skuVariation->variation->variationValue}}</p>
                              @endif
                              @if ($skuVariation->variation && $skuVariation->variation->variationType == 'Size')
                              <p class="text-ash">Size: {{$skuVariation->variation->variationValue}}</p>
                              @endif
                              @endforeach                           
                            </div>                         
                          </div>
                        </td>
                        <td>
                          @foreach($order->orderItems as $orderItem)
                          ${{$orderItem->price}} 
                          @endforeach
                        </td>
                        <td>
                          @foreach($order->orderItems as $orderItem)
                          {{$orderItem->quantity}}
                          @endforeach
                        </td>
                        <td class="text-ash">${{ $order->deliveryFee ?? 0}}</td>                      
                        <td>
                          {{$order->lastStatus}}
                        </td>
                      </tr>
                      @endif
                      @endforeach
                      @endforeach                   
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--====== profile page content end ======-->
	</main>
  @endsection

@section('footer.js')
    <script>

    </script>
@endsection