
@extends('layouts.main')
@section('title'){{ 'Checkout' }}@endsection
@section('header.css')
    <style>

    </style>
@endsection
@section('main.content')
<main>
    <!--====== breadcumb area start ======-->
    <section class="breadcumb-area pb-2">
      <div class="container">
        <ul class="d-flex gap-2">
          <li>
            <a href="{{url('/')}}" class="text-ash">Home</a>
          </li>
          <li>
            <a href="#" class="text-ash"><i class="fa-solid fa-angle-right"></i></a>
          </li>
          <li>
            <a href="#" class="text-ash">My Account</a>
          </li>
          <li>
            <a href="#" class="text-ash"><i class="fa-solid fa-angle-right"></i></a>
          </li>
          <li>
            <a href="#" class="text-ash">Checkout</a>
          </li>
        </ul>
      </div>
    </section>
    <!--====== breadcumb area end ======-->

    <!--====== page heading start ======-->
    <section class="pt-2 pt-lg-3">
      <div class="container">
        <h3 class="section-heading mb-4 ps-4">Check Out</h3>
      </div>
    </section>
    <!--====== page heading end ======-->

    <!--====== checkout info start ======-->
    <section class="checkout-info-area pb-4 pb-lg-5">     
      <div class="container">
        <form action="{{ route('product.submit_checkout') }}" method="post">
          @csrf
        <div class="row">
          <div class="col-md-8">
            <div class="personal-info">
              <h5 class="mb-3">Please Fill Out Your Personal Information</h5>
              <div class="personal-info-card mb-3 mb-lg-4">
                <form action="">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="" class="form-label">First Name</label>
                      <input type="text" name="firstName" class="form-control"  placeholder="Your first name" required id="">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="" class="form-label">Last Name</label>
                      <input type="text" name="lastName" class="form-control"  placeholder="Your last name" required id="">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="" class="form-label">EMail</label>
                      <input type="email" name="email" class="form-control"   placeholder="Your email" required id="">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="" class="form-label">Phone Number</label>
                      <input type="text" name="phone" class="form-control"  placeholder="Your phone number" required id="">
                    </div>
                    <div class="col-md-12 mb-3">
                      <label for="" class="form-label">Detail Address</label>
                      <textarea rows="4" class="form-control" name="billingAddress" required va placeholder="Your details address..."></textarea>
                    </div>
                  </div>
               
              </div>
            </div>
         
              <h5 class="mb-1">Payment Method</h5>
              <p class="text-ash">All transactions are secure and encrypted.</p>
              <div class="card-select-box mt-3 mt-lg-4 mb-3 mb-lg-4">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="payment" value="card" id="payment1">
                  <label class="form-check-label" for="payment1">
                    Credit Card
                  </label>
                  <p class="text-ash">We accept all major credit cards.</p>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="payment" value="cash" id="payment2" checked>
                  <label class="form-check-label" for="payment2">
                    Cash on delivery
                  </label>
                  <p class="text-ash">Pay with cash upon delivery.</p>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" value="bank" name="payment" id="payment3">
                  <label class="form-check-label" for="payment3">
                    Bank Transfer
                  </label>
                </div>
              </div>
              <p class="pay-btn">
                <button class="btn">Pay Now</button>
              </p>
         
              <div class="coupon-box col-lg-6 mt-3 mt-lg-4">
                <h5 class="mb-0">Discount Codes</h5>
                <p class="text-ash">Enter your coupon code if you have one</p>
                {{-- <form id="couponForm" action="{{ route('applyCoupon') }}" method="POST" class="mt-3">--}}
                  <div class="input-group">
                      <input type="text" class="form-control" name="promo_code" placeholder="Coupon">
                      <button type="button" class="input-group-text bg-red text-white" id="applyCouponBtn">Apply Coupon</button>
                  </div>
                {{-- </form>--}}
              </div>
            </div>
          <div class="col-md-4 mt-3 mt-md-0">
            <div class="order-summary">
              <h5>Order Summary</h5>
              <hr>
              @php
              $totalRegularPrice = 0;
              @endphp
              <table class="table">
                @foreach(\Cart::getContent() as $cartItem)
                <tr>
                  <td>
                    <div class="prod-detals d-flex gap-2 align-items-center">
                      <div>
                        <a href="product-details.html">
                          <img src="{{ url('admin/'.$cartItem->attributes->image) }}" alt="product" class="img-fluid">
                        </a>
                      </div>
                      <div>
                        <a href="product-details.html">
                          <h6 class="mb-0">{{ $cartItem->name }}</h6>
                        </a>
                        <p class="text-ash">Color: {{$cartItem->attributes->selectedColor}}</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-end text-ash font-500">${{$cartItem->price}}</p>
                  </td>
                  @php                      
                  $totalRegularPrice += $cartItem->attributes->regularPrice * $cartItem->quantity;
                  @endphp
                </tr>
                @endforeach

                @foreach(\Cart::getContent() as $cartItem)
                <tr>
                  <td>Sub Total <span class="text-ash">({{ $cartItem->quantity }} Items)</span></td>
                  <td class="text-end">${{ $cartItem->price * $cartItem->quantity}}</td>
                </tr>
                @endforeach
                <tr>
                  <td>Savings</td>
                  <td class="text-end discount-amount">${{ $totalRegularPrice - \Cart::getSubTotal() }}</td>
                </tr>
                <tr id="zoneCharge">
                  <td>Shipping</td>
                  <td class="text-end amount">${{ @$setting->shipping_cost }}</td>
                  {{-- <td class="text-end amount">@if(Session::has('zoneCharge')) ${{Session::get('zoneCharge')}} @else $0 @endif</td> --}}
                </tr>
                <tr>
                  <td><b>Grand Total</b></td>
                  {{-- @if(Session::has('zoneCharge')) --}}
                  {{-- <td class="text-end"><b>${{ \Cart::getSubTotal()+Session::get('zoneCharge') }}</b></td>
                  @else --}}
                  <input type="text" hidden name="shipping_cost" value="{{ @$setting->shipping_cost }}">
                  @if($setting->shipping_cost)
                  <td class="text-end cart-total"><b>${{ \Cart::getTotal()+ @$setting->shipping_cost }}</b></td>
                  @else
                  <td class="text-end cart-total"><b>${{ \Cart::getTotal() }}</b></td>
                  @endif
                  {{-- @endif --}}
                </tr>

                {{-- <tr class="order-total" id="totalWithZoneCharge">
                  <td>Total</td>
                  @if(Session::has('zoneCharge'))
                      <td class="order-total-amount">${{ \Cart::getSubTotal()+Session::get('zoneCharge') }}</td>
                  @else
                      <td class="order-total-amount">${{ \Cart::getSubTotal() }}</td>
                  @endif
                </tr> --}}
              </table>           
              <p>
                <button type="submit" class="btn btn-red w-100">Confirm Order</button>
              </p>
            </div>
          </div>
        </div>
        </form>
      </div>
    </section>
    <!--====== checkout info end ======-->
	</main>
    @endsection
    @section('footer.js')
    <script>
      
  //    $(document).ready(function() {
  //   $('#applyCouponBtn').on('click', function() {              
  //       var couponCode = $('input[name="promo_code"]').val();  
  //       var initialTotal = parseFloat('{{ \Cart::getTotal() }}');         
  //       $.ajax({
  //           type: 'POST',
  //           url: '{{ route('applyCoupon') }}',
  //           data: {
  //               _token: '{{ csrf_token() }}',
  //               promo_code: couponCode
  //           },
  //           success: function(response) {
  //               console.log('Received response:', response);

                
  //               if (response.success) 
  //               {
                    
  //                 var discountAmount = 0;
  //                 var updatedTotal = 0; 

  //                 if (response.discountType === 'amount') 
  //                 {                      
  //                     discountAmount = response.discountAmount;
  //                     var updatedTotal=initialTotal - discountAmount;
  //                 } 
  //                 else if (response.discountType === 'percentage') 
  //                 {
  //                     discountAmount = response.discountAmount;
                      
  //                     var updatedTotal = initialTotal - initialTotal*(discountAmount/100);
  //                 }            
                                    
  //                 $('.discount-amount').text('$' + discountAmount.toFixed(2));
  //                 $('.cart-total').text('$' + updatedTotal.toFixed(2));
  //               }
  //           },
  //           error: function(error) {
  //               console.error('Error:', error);
  //           }
  //       });
  //   });
  // });

    </script>    
  @endsection  
  
 

