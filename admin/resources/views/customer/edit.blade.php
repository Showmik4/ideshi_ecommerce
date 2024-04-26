@extends('layouts.main')
@section('title'){{ 'Customer Edit' }}@endsection
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
                        <h3>Customer Edit</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Customer</li>
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
                            <form class="form-wizard" action="{{ route('customer.update', $customer->customerId) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="firstName">First Name</label>
                                            <input class="form-control" id="firstName" name="firstName" type="text" placeholder="First Name" value="{{ @$customer->user->firstName }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('firstName') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="lastName">Last Name</label>
                                            <input class="form-control" id="lastName" name="lastName" type="text" placeholder="Last Name" value="{{ @$customer->user->lastName }}">
                                            <span class="text-danger"><b>{{  $errors->first('lastName') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone">Phone</label>
                                            <input class="form-control" id="phone" name="phone" type="text" placeholder="Phone" value="{{ @$customer->phone }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('phone') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email">Email</label>
                                            <input class="form-control" id="email" name="email" type="email" placeholder="Email" value="{{ @$customer->user->email }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('email') }}</b></span>
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label for="customerImage">Customer Image</label>
                                            <input class="form-control" id="customerImage" name="customerImage" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('customerImage') }}</b></span>
                                        </div>
                                        @if(isset($customer->customerImage))
                                        <div class="mb-3">
                                            <img height="100px" width="100px" src="{{ url($customer->customerImage) }}" alt="">
                                        </div>
                                        @endif --}}
                                        <div class="mb-3">
                                            <label for="billingAddress">Billing Address</label>
                                            <textarea class="form-control" name="billingAddress" id="billingAddress" placeholder="Billing Address" required>{{  @$customer->address->billingAddress }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('billingAddress') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="shippingAddress">Shipping Address</label>
                                            <textarea class="form-control" name="shippingAddress" id="shippingAddress" placeholder="Shipping Address">{{ @$customer->address->shippingAddress }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('shippingAddress') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fkShipmentZoneId">Shipment Zone</label>
                                            <select class="form-control" name="fkShipmentZoneId" id="fkShipmentZoneId">
                                                <option value="">Select Shipment Zone</option>
                                                @foreach($shipmentZones as $shipmentZone)
                                                    <option value="{{ $shipmentZone->shipmentZoneId }}" @if($customer->fkShipmentZoneId === $shipmentZone->shipmentZoneId) selected @endif>{{ $shipmentZone->shipmentZoneName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('fkShipmentZoneId') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status">Customer Status</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="">Select Customer Status</option>
                                                <option value="active" @if($customer->status === 'active') selected @endif>Active</option>
                                                <option value="inactive" @if($customer->status === 'inactive') selected @endif>Inactive</option>
                                            </select>
                                            <span class="text-danger"> <b>{{  $errors->first('status') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('customer.show') }}">Cancel</a></button>
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
            CKEDITOR.replace( 'details')
        });
    </script>
@endsection
