@extends('layouts.main')
@section('title')
    {{ 'Order details' }}
@endsection
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
                        <h3>Order details</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
                       
                            <li class="breadcrumb-item active">Order details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mb-1">
                  <div class="card">
                    <div class="card-content">
                        <div class="card-body order-details-card">
                          <!-- top row -->
                          <div class="row align-items-center mb-3">
                            <div class="col-sm-5 mb-1">
                              <h4 class="card-title order-details-heading mb-0">Order #{{$order->orderId}} details</h4>
                            </div>
                            <div class="col-sm-4 mb-1">
                              <button class="btn btn-primary btn-min-width" onclick="orderStatus({{$order->orderId}})">Change Status</button>
                            </div>
                            <div class="col-sm-3 mb-1 text-sm-right">
                              {{-- <a href="{{route('order.download',$order->orderId)}}" class="btn btn-info btn-min-width">Invoice</a> --}}
                            </div>
                          </div>
                          <!-- change status modal -->
                          <div id="statusModal"></div>
                          <div id="paymentModal"></div>
                          <div id="returnModal"></div>
                          <!-- order info -->
                          <div class="row">
                            <div class="col-md-4 mb-1">
                              <h5 class="mb-1"><b>General</b></h5>
                              <p class="details-text">
                                <b>Customer:</b> {{$order->customer->user->firstName ?? "Not availble"}} <br>
                                <b>Phone:</b> {{$order->customer->phone ?? "Not availble"}} <br>
                                <b>Date created:</b> {{$order->created_at}} <br>
                                <b>Date edited:</b> {{$order->updated_at}}  <br>
                                {{-- <b>Date printed:</b> No <br> --}}
                                <b>Sale type:</b> {{$order->sale_type}} <br>
                                {{-- <b>Problem category:</b> Reject <br>
                                <b>Problem reason:</b> 766 --}}
                              </p>
                            </div>
                            <div class="col-md-4 mb-1">
                              <h5 class="mb-1"><b>Shipping</b></h5>
                              <p class="details-text">
                                <b>Delivey Time:</b> {{$order->deliveryTime ?? "Not availble"}} <br>
                                <b>Location:</b> {{$order->delivery->location ?? "Not availble"}} <br>
                                <b>Delivery Service:</b> {{$order->delivery->companyName ?? "Not availble"}} <br>
                                {{-- <b>Courier tracking number:</b> No <br> --}}
                                <b>Billing Address:</b> {{$order->customer->address->billingAddress ?? "Not available"}} <br>
                                <b>Shipping Address:</b> {{$order->customer->address->shippingAddress ?? "Not available"}}
                              </p>
                            </div>
                            <div class="col-md-4 mb-1">
                              <h5 class="mb-1"><b>Note</b></h5>
                              <p class="details-text">{{$order->note ?? "Not available"}}</p>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                  <!-- total table -->
                  @if(!empty($order->orderedProduct))
                      <div class="card">
                      <div class="card-content collapse show">
                          <div class="card-body">
                              <div class="product-detail-table table-responsive">
                              <table class="table">
                                  <thead>
                                  <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">Product Name</th>
                                      <th scope="col">Product Code</th>
                                      <th scope="col">Product Image</th>
                                      <th scope="col">Variation/Type</th>
                                      <th scope="col">Quantity</th>                                     
                                      <th scope="col">Unit Cost</th>
                                      <th scope="col">Discount</th>
                                      <th scope="col">Total</th>
                                      @if(in_array($currentStatus = @$order->orderStatusLogs->where('status','!=',NULL)->last()->status,['Delivered','Return','Complete']))
                                        <th scope="col">Action</th>
                                      @endif
                                  </tr>
                                  </thead>
                                  <tbody>
                                    {{-- @dd($order); --}}
                                  @if($order->orderedProduct->count() > 0) 
                                  @foreach ($order->orderedProduct as $key => $item)
                                      <tr>
                                          <td scope="row">{{++$key}}</td>
                                          <td>{{$item->sku->product->productName}}</td>
                                          <td>{{$item->sku->product->productCode}}</td>
                                          <td><img src="{{url($item->sku->product->featureImage)}}" border="0" onclick="zoomImage(this)" width="60" class="img-rounded " align="center" /></td>
                                          <td>{{$item->sku->product->type}}</td>
                                          <td>{{$item->quantity}}</td>                                          
                                          <td>{{$item->price}}</td>                                          
                                          <td>{{$item->discount?? 0 }}</td>
                                          <td>{{$item->price * $item->quantity}}</td>
                                          @if(in_array($currentStatus,['Delivered','Return','Complete']))
                                              <td >
                                                  <a href="#" onclick="returnProduct({{$item->order_itemId}})" title="Return"><i class="fa fa-minus"></i></a>
                                              </td>
                                          @endif
                                      </tr>  
                                  @endforeach
                                  @else
                                   <h3>No Product added </h3>
                                  @endif
                                  <tr>
                                      <td colspan="9" class="text-right"> <b>Delivery Fee</b> </td>
                                      <td>{{$order->deliveryFee ?? 0}}</td>
                                  </tr>
                                  <tr>
                                      <td colspan="9" class="text-right"> <b>Total</b> </td>
                                      <td>{{$order->orderTotal}}</td>
                                  </tr>
                                  {{-- <tr>
                                      <td colspan="7" class="text-right"> <b>Order Total</b> </td>
                                      <td>{{$order->orderTotal+$order->deliveryFee}}</td>
                                  </tr> --}}
                                  </tbody>
                              </table>
                              </div>
                          </div>
                      </div>
                      </div>
                  @endif
                  <!-- transaction card -->
                  <div class="card">
                    <div class="card-content">
                        <div class="card-body order-details-card">
                          <!-- top row -->
                          <div class="row align-items-center mb-3">
                            <div class="col-md-4 mb-1">
                              <h4 class="card-title order-details-heading mb-0">Transaction</h4>
                            </div>
                            <div class="col-md-4 mb-1">
                              <h4 class="text-warning">Due: {{$order->orderTotal - $order->paidAmount()}}</h4>
                            </div>
                            <div class="col-md-4 mb-1 text-sm-right">
                              {{-- <button type="button" class="btn btn-danger btn-min-width">Refund</button> --}}
                              <button type="button" class="btn btn-success btn-min-width" onclick="addPayment({{$order->orderId}})">Add Payment</button>
                            </div>
                          </div>
                          <!-- transaction table -->
                          @if(!empty($order->transaction))
                              <div class="product-detail-table table-responsive">
                              <table class="table">
                                  <thead>
                                  <tr>
                                      <th scope="col">ID</th>
                                      <th scope="col">Amount</th>
                                      <th scope="col">Type</th>
                                      <th scope="col">Method</th>
                                      <th scope="col">comment</th>
                                      <th scope="col">Time</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  @foreach ($order->transaction as $key=>$item)
                                      <tr>
                                          <td scope="row">{{++$key}}</td>
                                          <td>{{$item->amount}}</td>
                                          <td>{{$item->payment_type}}</td>
                                          <td>{{$item->method}}</td>
                                          <td>{{$item->advance_note ?? 'Not available'}}</td>
                                          <td>{{$item->created_at}}</td>
                                      </tr>
                                  @endforeach
                                  </tbody>
                                  <tfoot>
                                  <tr colspan="7">
                                      <th class="border-0" >Total</th>
                                      <th class="border-0">{{floatval($order->transaction->sum('amount'))}}</th>
                                  </tr>
                                  </tfoot>
                              </table>
                              </div>
                          @endif
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 mb-1">
                  <div class="card" style="max-height: 342px; overflow-y: scroll">
                    <div class="card-header">
                      <div class="row">
                        <div class="col-6">
                          <h4 class="card-title order-details-heading mb-0">Remarks</h4>
                        </div>
                        <div class="col-6">
                          <h4 class="card-title order-details-heading mb-0 text-right text-primary" id="mainStatus">Status: {{$order->lastStatus->status ?? "Not available"}}</h4>
                        </div>
                      </div>
                    </div>
                    <div class="card-content" >
                          <div class="card-body pt-0 pb-0">
                            @if(count($order->orderStatusLogs)>0)
                              @foreach($order->orderStatusLogs as $log)
                                <h7 class="status text-success">Status - {{Str::ucfirst($log->status) ?? "Not available"}}</h7><br>
                                <h7 class="name text-info">Added by - {{Str::ucfirst($log->author->firstName ?? "admin") }}</h7><br>
                                <h7 >Remark - {{Str::ucfirst($log->note ??"None")}}</h7><br>
                                <h7 class="time text-primary">Time - {{\Carbon\Carbon::parse($log->created_at)->format('l jS \\of F Y h:i:s A')}}</h7>
                                <hr>
                              @endforeach
                            @endif
                          </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <div class="row">
                        <div class="col-6">
                          <h4 class="card-title order-details-heading mb-0">Remarks</h4>
                        </div>
                        <div class="col-6">
                          <h4 class="card-title order-details-heading mb-0 text-right text-primary" id="viewStatus">Status: {{$order->lastStatus->status ?? "Not available"}}</h4>
                        </div>
                      </div>
                    </div>
                    {{-- <div class="card-content" >
                          <div class="card-body pt-0 pb-1">
                            <form action="">
                              <fieldset class="form-group">
                                <textarea class="form-control" id="placeTextarea" rows="3" placeholder="Write note..."></textarea>
                              </fieldset>
                              <div class="text-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                            </form>
                          </div>
                    </div> --}}
                  </div>
                </div>
              </div>
        </div>        
    </div>
@endsection

@section('footer.js')
<script>
 function orderStatus(data){
            $.ajax({
                type: "POST",
                url: '{{route('order.orderStatus')}}',
                data:{
                    'id':data,
                    '_token':"{{csrf_token()}}",
                    },
                success: function (response) {
                    $('#statusModal').html(response)
                    $('#statusChangeModal').modal('toggle');
                }
            });
        }
  function addPayment(data){
    console.log(data);
    $.ajax({
          url: '{{ route('transaction.payment') }}',
          method: 'post',
          data: {
              '_token': '{{csrf_token()}}',
              'orderId': data,
          },
          success: function (data) {
            // console.log(data);
            $('#paymentModal').html(data);
            $('#payment-Modal').modal('toggle');
          }
        });
  }

  function zoomImage(e) {
            var s = $(e).attr('id');
            console.log(e);
            // $(e).animate({'width':'200px'});
            // $(e).css({'cursor':'zoom-out'});
            if ($(e).width() != 200) {
                $(e).animate({
                    'width': '200px'
                });
                $(e).css({
                    'cursor': 'zoom-out'
                });
            } else {
                $(e).animate({
                    'width': '60px'
                });
                $(e).css({
                    'cursor': 'zoom-in'
                });
            }
        }

  function returnProduct(orderItemId){
            $.ajax({
                url: '{{ route('order.returnModal') }}',
                method: 'post',
                data: {
                    '_token': '{{csrf_token()}}',
                    'orderItemId': orderItemId
                },
                success: function (data) {
                    $('#returnModal').html(data);
                    $('#return-Modal').modal();
                }
            });
  }    
        
</script>
@endsection
