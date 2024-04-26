@extends('layouts.main')
@section('title'){{ 'Cart' }}@endsection
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
          <a href="#" class="text-ash">Add to Cart</a>
        </li>
      </ul>
    </div>
  </section>
  <!--====== breadcumb area end ======-->

  <!--====== cart table start ======-->
  <section class="cart-table mt-3" id="cart-body">
    <div class="container">
        <div class="table-responsive" id="">
            <table class="table">
                <thead>
                    <tr>
                        <th>product details</th>
                        <th>price</th>
                        <th>quantity</th>  
                        <th>shipping</th>                                            
                        <th>subtotal</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                  @php
                  $totalRegularPrice = 0;
                  @endphp
                    @foreach (\Cart::getContent() as $cartItem)               
                    <tr id="cart-row">
                        <td>
                            <div class="prod-detals d-flex gap-2 align-items-center">
                                <div>
                                    <a href="product-details.html">
                                        <img src="{{ url('admin/'.$cartItem->attributes->image) }}" alt="product" class="img-fluid">
                                    </a>
                                </div>
                                <div>
                                    <a href="product-details.html">
                                        <h6 class="mb-1">{{ $cartItem->name }}</h6>
                                    </a>
                                    <p class="text-ash" style="background-color:{{$cartItem->attributes->selectedColor}}">Color:{{$cartItem->attributes->selectedColor}}</p>
                                    <p class="text-ash" >Size:{{$cartItem->attributes->selectedSize}}</p>
                                </div>
                            </div>
                        </td>
                        @php                      
                        $totalRegularPrice += $cartItem->attributes->regularPrice * $cartItem->quantity;
                        @endphp
                        <td>$ {{$cartItem->price}}</td>
                        <td>
                          <div class="quantity">
                            <a href="#" class="quantity__minus" onclick="decreaseQuantity('{{$cartItem->id}}', event)"><span>-</span></a>
                            <input name="quantity" type="text" id="quantity_{{$cartItem->id}}" class="quantity__input" value="{{$cartItem->quantity}}">
                            <a href="#" class="quantity__plus" onclick="increaseQuantity('{{$cartItem->id}}', event)"><span>+</span></a>
                          </div>                        
                        </td>
                        {{-- <td class="text-ash">$5.00</td> --}}
                        <td id="">
                          {{-- @foreach($shippingZones as $shippingZone)
                          <div class="input-group">
                              <input type="radio" id="shipmentZone_{{$shippingZone->shipmentZoneId}}" onchange="zone({{ $shippingZone->shipmentZoneId }})" name="shipmentZone" @if(Session::get('zoneChargeId') == $shippingZone->shipmentZoneId) checked @endif>
                              <label for="shipmentZone_{{$shippingZone->shipmentZoneId}}">{{ $shippingZone->shipmentZoneName }}: {{ @$shippingZone->charge->deliveryFeeInside }}</label>
                          </div>
                          @endforeach --}}
                          {{-- {{Session::get('zoneCharge')}} --}}
                          @if($setting->shipping_cost)
                          ${{ @$setting->shipping_cost }}
                          @endif
                        </td>
                       
                        <td><span id="subtotal_{{$cartItem->id}}">$ {{ $cartItem->price*$cartItem->quantity }}</span></td>
                        <td>
                            {{-- <a href="javascript:void(0)" onclick="removeCartItem('{{$cartItem->id}}')"><i class="fa-solid fa-trash-can delete-icon"></i></a> --}}
                            <a href="{{ route('product.remove_CartItem', ['id' => $cartItem->id]) }}"><i class="fa-solid fa-trash-can delete-icon"></i></a>
                        </td>
                      
                    </tr>
                    @endforeach   
                    @if(\Cart::getContent()->count()<= 0)
                    <tr>
                       <td colspan="6" class="text-center">Cart is empty</td>
                    </tr>
                    @endif    
                </tbody>
            </table>
        </div>
    </div>
</section>

  <!--====== cart table end ======-->

  <!--====== cart total start ======-->
  <section class="cart-total-area py-3" id="">
    <div class="container" id="cartFooter">
      <div class="row justify-content-end">
        <div class="col-md-5 col-lg-3">
          <table class="table table-borderless" id="cart-footer">
            <tr>
              <td>Sub Total</td>
              <td id="subTotalFooter">$ {{ \Cart::getSubTotal() }}</td>
            </tr>
            <tr>
              <td>Shipping</td>
              <td>${{ @$setting->shipping_cost }}</td>
              {{-- <td>
              @foreach($shippingZones as $shippingZone)
              <div class="input-group">
                  <input type="radio" id="shipmentZone_{{$shippingZone->shipmentZoneId}}" onchange="zone({{ $shippingZone->shipmentZoneId }})" name="shipmentZone" @if(Session::get('zoneChargeId') == $shippingZone->shipmentZoneId) checked @endif>
                  <label for="shipmentZone_{{$shippingZone->shipmentZoneId}}">{{ $shippingZone->shipmentZoneName }}: {{ @$shippingZone->charge->deliveryFeeInside }}</label>
              </div>
              @endforeach
              </td>              --}}
            </tr>
            {{-- <tr>
              <td>Discount</td>
              <td id="total-discount">{{$totalDiscount}}</td>
            </tr> --}}
            <tr>
              <td>Savings</td>
              <td>$ {{ $totalRegularPrice - \Cart::getSubTotal() }}</td>
            </tr>
            <tr id="totalWithZoneCharge">
              <td><b>Grand Total</b></td>
              {{-- @if(Session::has('zoneCharge')) --}}
              {{-- <td id="grandTotalFooter" class="order-total-amount"><b>{{ \Cart::getSubTotal()+Session::get('zoneCharge') }}</b></td> --}}
              {{-- @else --}}
              @if($setting->shipping_cost)
              <td id="grandTotalFooter" class="order-total-amount"><b>$ {{ \Cart::getSubTotal()+ @$setting->shipping_cost}}</b></td>
              @else
              <td id="grandTotalFooter" class="order-total-amount"><b>$ {{ \Cart::getSubTotal() }}</b></td>
              @endif

              {{-- @endif --}}
            </tr>
          </table>
          <hr>
          <p class="text-center">
            <a href="{{route('product.checkout')}}" class="btn">Proceed To Checkout</a>
          </p>
        </div>
      </div>
    </div>
  </section>
  <!--====== cart total end ======-->
</main>
@endsection
@section('footer.js')
    <script>

    </script>
@endsection