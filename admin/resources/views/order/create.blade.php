@extends('layouts.main')
@section('title')
    {{ 'Orders' }}
@endsection
@section('header.css')
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.css"
    />
    <style>
        .ui-autocomplete {
            z-index: 5000;
            width: 470px !important;
        }
        .select2-search__field:focus {
            outline: none;
        }
        .input-group .input-group-text {
            padding-right: 8px;
            padding-left: 8px;
        }
        .input-group .form-control {
            padding-right: 5px;
            padding-left: 5px;
            text-align: center;
        }

    </style>
@endsection
@section('main.content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Orders</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active">Orders</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <!-- Zero Configuration  Starts-->
                <div class="col-sm-7">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="searchBar">Search Product by Barcode:</label>
                                <input type="text" id="searchBar" class="form-control" placeholder="Enter Barcode" name="searchBar" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="search">Search Product:</label>
                                <input type="text" id="search" class="form-control" placeholder="Enter Product Title/Code" name="search" value="">
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <!-- Customer Search Modal -->
                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#customerSearch">
                                <img src="{{url('public/assets/images/searching-a-person.svg')}}" alt="" style="width: 20px; height: auto;">
                            </button>
                            <div class="modal fade" id="customerSearch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Search Phone:</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group" id="oldCustomer">
                                                <input type="text" class="form-control" id="customer" placeholder="Search here" aria-label="" name="customer">
                                            </div>
                                        </div>
                                        {{-- <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Create Modal -->
                            <button type="button" onclick="customerModal()" class="btn btn-primary" >
                                <i class="fa fa-plus"></i>
                            </button>
                            <div id="customerAdd"></div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group" id="productType"></div>
                        </div>
                    </div>
                    <p id="customerInfo"></p>
                    <hr>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="productTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th style="min-width: 120px;">Qnty.</th>
                                            <th style="text-align: center">Discount</th>
                                            <th>Total.</th>
                                            <th style="text-align: center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        @php $total = 0;@endphp
                                        @if (!\Cart::session(Auth::user()->userId)->isEmpty())
                                            @foreach(\Cart::session(Auth::user()->userId)->getContent()->sort() as $row)
                                            <tr>
                                                <th scope="row">{{$row->id}}</th>
                                                <td>{{$row->name}}</td>
                                                <td>{{$row->price ?? 0}}</td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend cursor-pointer" data-id="{{$row->id}}" id="decrease" onclick="decreaseValue(this)">
                                                            <span class="input-group-text"><i class="fa fa-minus"></i></span>
                                                        </div>
                                                          <input type="text" class="form-control" aria-label="" id="number{{$row->id}}" name="rateperhour" value="{{$row->quantity}}" readonly>
                                                        <div class="input-group-append cursor-pointer" data-id="{{$row->id}}" id="increase" onclick="increaseValue(this)">
                                                            <span class="input-group-text"><i class="fa fa-plus"></i></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><input type="text" data-id="{{$row->id}}" id="discount{{$row->id}}" onfocusout="discountPrice(this)" class="form-control"
                                                    name="discount" value="{{$row->attributes->discount}}"></td>
                                                <td>{{$subtotal =$row->quantity*$row->price - $row->attributes->discount ??'0'}}</td>
                                                <td style="text-align: center">
                                                    {{-- <button type="button" class="btn btn-warning btn-sm"><i class="ft-edit-3"></i></button> --}}
                                                    <button type="button" onclick="removeItem({{$row->id}})" class="btn btn-danger"><i id="delIcon{{$row->id}}" class="fa fa-trash"></i><span id="delSpinner{{$row->id}}" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none"></span></button>
                                                </td>
                                            </tr>
                                            @php $total = $total+ $subtotal;@endphp
                                            @endforeach
                                        @else
                                            <tr id="initial">
                                                <td style="text-align: center" colspan="7">No product has been added</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <button onclick="clearCart()" type="button"  class="btn btn-danger m-1"><i id="delIcon" class="ft-trash-2"></i><span id="delSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none"></span>Reset cart</button>
                            <div style="text-align: right;">
                                <span><b >Total:</b></span>
                                <span id="orderTotal">{{$total}}</span>
                            </div>
                             <!-- payment info. -->
                             <form id="orderForm">
                                @csrf
                                <input type="hidden" class="form-control" id="customerId" placeholder="Search here" aria-label="" name="customerId">
                             <h4 class="form-section mt-2">
                                 <i class="ft-flag"></i>Payment Info</h4>
                             <div class="row">
                                 <div class="col-md-4">
                                     <!-- <div class="form-group">
                                         <label for="companyinput1">Payment Type</label>
                                         <select class="form-control" name="payment_type" id="payment_type" >
                                             <option value="">Select</option>
                                             <option value="advance">Advance</option>
                                             <option value="normal">Normal</option>
                                         </select>
                                     </div> -->

                                     <div class="form-group">
                                         <label for="companyinput1">Payment Type</label>
                                         <div class="row">
                                             <div class="col-4">
                                                 <fieldset>
                                                     <input type="radio" name="payment_type" id="payment_type" value="normal" onchange="paymentTypeChange(this);" checked>
                                                     <label for="input-radio-11">Normal</label>
                                                 </fieldset>
                                             </div>
                                             <div class="col-4">
                                                 <fieldset>
                                                     <input type="radio" name="payment_type" id="payment_type" value="partial" onchange="paymentTypeChange(this);">
                                                     <label for="input-radio-12">Partial</label>
                                                 </fieldset>
                                             </div>
                                             <div class="col-4">
                                                 <fieldset>
                                                     <input type="radio" name="payment_type" id="payment_type" value="due" onchange="paymentTypeChange(this);">
                                                     <label for="input-radio-13">Due</label>
                                                 </fieldset>
                                             </div>
                                         </div>
                                     </div>

                                 </div>
                                 <div class="col-md-4">
                                     <div class="form-group">
                                         <label for="companyinput1">Payment Method</label>
                                         <select class="form-control" name="payment_method" id="payment_method">
                                             <option value="">Select</option>
                                             <option value="cash" selected>Cash</option>
                                             <option value="mobileTransfer">Mobile Transfer</option>
                                             <option value="card">Card</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-md-4">
                                     <div class="form-group">
                                         <label for="companyinput1">Paid amount</label>
                                         <input type="text" id="paid_amount" class="form-control"
                                             placeholder="Purchase price" onfocusout="orderDue(this)" onclick="orderTotal(this)" name="paid_amount">
                                     </div>
                                 </div>
                             </div>
                             <div class="row">

                                 <div class="col-md-4" id="collectAmount" style="display: none">
                                     <div class="form-group">
                                         <label for="companyinput1">Collect amount</label>
                                         <input type="text" id="collect_amount" class="form-control"
                                             placeholder="Collect amount" onfocusout="returnAmount(this)" name="collect_amount">
                                     </div>
                                 </div>
                                 <div class="col-md-4" id="returnAmount" style="display: none">
                                     <div class="form-group">
                                         <label for="companyinput1">Return amount</label>
                                         <input type="text" id="return_amount" class="form-control"
                                             placeholder="Collect amount" name="return_amount" readonly>
                                     </div>
                                 </div>
                                 <div class="col-md-4" id="memebership" style="display: none">
                                     <div class="form-group">
                                         <label for="companyinput1" id="pointLabel">Point()</label>
                                         <input type="number" id="point" class="form-control"
                                             placeholder="point" name="point">
                                     </div>
                                 </div>
                             </div>
                        </div>
                        <button type="button" onclick="orderSubmit()" class="btn btn-primary">
                            <i class="la la-check-square-o"></i>Submit
                        </button>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Search Product</h4>
                        </div>

                        <div class="card-content collapse show">
                            <div class="card-body pt-0 pb-1">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <select class="select2-size-lg form-control" id="category" onchange="categoryProduct(this)">
                                            <optgroup label="All category">
                                                <option value="" readonly>Select</option>
                                                @foreach ($category as $item)
                                                    <option value="{{$item->categoryId}}">{{$item->categoryName}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <select class="select2 form-control" id="default-select" onchange="brandProduct(this)">
                                            <optgroup label="All brand">
                                                <option value="" readonly>Select</option>
                                                @foreach ($brand as $item)
                                                    <option value="{{$item->brandId}}">{{$item->brandName}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="show-search-product-card p-2 rounded" id="productCard" style="display: none; padding-top: 1rem !important;">
                        <div class="d-flex justify-content-center mb-2">
                            <div class="spinner-grow text-primary" style="display: none" id="deliverySpin" role="status">
                            </div>
                        </div>
                        <div class="row" id="productList">
                        </div>
                    </div>
                </div>
                <!-- Zero Configuration  Ends-->
            </div>
        </div>
        <!-- Container-fluid Ends-->

    </div>
@endsection

@section('footer.js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
<script>
$(function () {
    $("#search").autocomplete({
            source: function (request, data) {
                $.ajax({
                    url: "{{ route('product.search') }}",
                    method: "post",
                    data: {
                        _token: "{{csrf_token()}}",
                        productIdOrName: request.term,
                    },
                    success: function (products) {
                        if (!products.product.length) {
                            var result = [{
                                label: "No matches found",
                                value: "no",
                            }, ];
                            data(result);
                        } else {
                            result = $.map(products.product, function (obj) {
                                return {
                                    label: obj.productName,
                                    value: obj.productName,
                                    allData: obj,
                                };
                            });
                            data(result);
                        }
                    },
                });
            },
            select: function (event, product) {
                if (product.item.allData.type === 'single') {
                    singleProduct(product.item.allData.sku[0].skuId, product.item.allData.productName)
                }
                else {
                    variationSelect(product)
                }
            },
        })
        .data("ui-autocomplete")._renderItem = function (ul, item) {
            try {
                return $("<li class='list-group-item col-md-6 text-primary'></li>")
                    .attr("data-value", item.value)
                    .append(
                        `<a><img class="mr-3" style="width:25px;height:25px;" onerror="this.src='{{url('public/featureImage/default.jpg')}}/'" src="{{url('public/featureImage')}}/${typeof item.allData.featureImage !== "undefined" ? item.allData.featureImage : "default.jpg"}">${item.label}</a>`
                    )
                    .appendTo(ul);
            } catch (err) {
                return $("<li class='list-group-item'></li>")
                    .attr("data-value", item.value)
                    .append(`${item.label}`)
                    .appendTo(ul);
            }
        };
    });

    //Customer Phone Search
    $("#customer").autocomplete({
        source:function(request,data) {
            $.ajax({
                url: "{{ route('user.customer.search') }}",
                method: 'post',
                data: {
                    '_token': '{{csrf_token()}}',
                    'phoneNumber': request.term,
                },
                success: function (product) {
                    // console.log(product);
                    if (!product.length) {
                        var result = [
                        {
                            label: "No matches found",
                            value: "no",
                        },
                        ];
                        data(result);
                    }
                    else {
                        result = $.map(product, function (obj) {
                        return {
                            label:obj.phone,
                            value:obj.phone,
                            id:obj.customerId,
                        };
                        });
                        data(result);
                    }
                },
            });
        },
        select:function(e,data){
            customerDetails(data)
        }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {

        try {
            return $("<li class='list-group-item'></li>")
            .attr( "data-value",item.label )
            .append(`<a>${item.label}</a>`)
            .appendTo(ul)
        } catch (error) {
            return $("<li class='list-group-item'></li>")
            .attr( "data-value", item.label )
            .append(`<a>"No items found"</a>`)
            .appendTo(ul)
        }

    };

    /**
    * Function that takes variation product
    * @param    {Object} takes products with sku
    * @return   {html ,div,select} which will show a modal with variation list of that product
    */
    function variationSelect(product){
        var variationValue = []
        var variation = product.item.allData.sku.map((prod) => {
            if (Object.keys(prod.variation_relation).length != 0) {
                $.each(prod.variation_relation, (key, value) => {
                    if (typeof (value.variation_detailsdata) != 'undefined') {
                        if (value.variation_detailsdata.variationType == 'Color') {

                            variationValue[value.skuId] = colorName[value.variation_detailsdata.variationValue.toUpperCase()]
                        } else {
                            variationValue[value.skuId] = value.variation_detailsdata.variationValue
                        }
                    }
                })
            }
        })
        if (variationValue.length) {
            var html = `<option value="" readonly>Select</option>`;
            variationValue.forEach((value, index) => {
                html += `<option value="${index}">${value}</option>`
            })
            $('#variationBody').html('');
            $('#variationBody').html(`<select class="form-control" name="variation" data-productName="${product.item.allData.productName}" onchange="variationProduct(this)" id="variation">${html}</select>`)
            $('#variation').modal('toggle')
        }
    }

    /**
    * Function that takes variation product
    * @param    {Object} takes products with sku
    * @return   {html ,div,select} which will show a modal with variation list of that product
    */
    function variationSelectRight(product,barcode='empty'){
        let products
        if(barcode == 'empty'){
            products = JSON.parse(product);
        }
        else{
             products = product
        }
        console.log(products);
        var variationValue = []
        var variation = products.sku.map((prod) => {
            console.log(prod);
            if (Object.keys(prod.variation_relation).length != 0) {
                $.each(prod.variation_relation,(key,value) => {
                    if (typeof (value.variation_detailsdata) != 'undefined') {
                        if (value.variation_detailsdata.variationType == 'Color') {

                            variationValue[value.skuId] = colorName[value.variation_detailsdata.variationValue.toUpperCase()]
                        } else {
                            variationValue[value.skuId] = value.variation_detailsdata.variationValue
                        }
                    }
                })
            }
        })
        if (variationValue.length) {
            var html = `<option value="" readonly>Select</option>`;
            variationValue.forEach((value, index) => {
                html += `<option value="${index}">${value}</option>`
            })
            $('#variationBody').html('');
            $('#variationBody').html(`<select class="form-control" name="variation" data-productName="${products.productName}" onchange="variationProduct(this)" id="variation">${html}</select>`)
            $('#variation').modal('toggle')
        }

        else{
            toastr.error('I do not think that word means what you think it means.', 'But its system error!&#128520;')
        }
    }

    /**
    * Function that add product to cart
    * @param    {Integer} takes products sku
    * @return   {html ,div,select} which will show new cart in the page
    */
    function variationProduct(e){
        $('#productType').hide()
        let sku =$(e).val();
        $('#initial').hide()
        let productName=$(e).attr('data-productName')
        $.ajax({
            url: "{{ route('order.batch') }}",
            method: "post",
            data: {
                _token: "{{csrf_token()}}",
                'sku': sku,
                'product':productName,
            },
            success: function (data) {
                toastr.success('Product added successfully')
                $('#tableBody').html('')
                $('#tableBody').append(data.cart)
                $('#orderTotal').html(data.total)
                $('#paid_amount').val(data.total)
                $('#variation').modal('toggle')
                /*  let existProduct=$(`#${sku}`);
                console.log(existProduct);
                console.log(existProduct.length);
                if (data.length!=0) {
                    if(existProduct.length > 0)
                    {
                        let currentValue=$("tr#"+sku+"> td.quantity>#quantity").val()
                        console.log($("tr#"+sku+"> td.quantity>#quantity"))
                    }
                    else{
                        let tableBody=`<tr id="${sku}">
                                            <th scope="row">${sku}</th>
                                            <td>${productName}</td>
                                            <td>${data.salePrice==null ?"No price available" : data.salePrice}</td>
                                            <td class="quantity"><input type="text" id="quantity" class="form-control"
                                                name="quantity" value="1"></td>
                                            <td><input type="text" id="discount" class="form-control"
                                                name="discount"></td>
                                            <td style="text-align: center">
                                                <button type="button"
                                                    class="btn btn-danger btn-sm"><i class="ft-trash-2"></i></button>
                                            </td>
                                        </tr>`
                        $('#tableBody').append(tableBody)
                    }
                }
                else{
                // $('#tableBody').html('<td colspan="6">No purchase Yet</td>')
                }
                */

            },
            error:(data)=>{
                console.log(data);
                toastr.error(`${data.responseJSON.message}&#128148;`)
                $('#variation').modal('toggle')
            }

        });
    }

    /**
    * Function that finds a customer by ID
    * @param    {Integer} takes customer ID
    * @return   {html ,div} which will show retrived customer's data
    */
    function customerDetails(data){
        $.ajax({
            type: "post",
            url: "{{route('user.customer.data')}}",
            data: {
                _token: "{{csrf_token()}}",
                customerName: data.item.id,
            },
            success:(res)=>
            {
                let { user,address,memebership,point} = res
                $('#customer').val(`${user.firstName} (${res.phone})`)
                $('#customerId').val(`${res.customerId}`)
                $('#memebership').show()
                $('#pointLabel').text(`Point(${point})`)
                $('#point').focusout(function () {
                    let maxLength = $(this).val();
                    if (maxLength > point && maxLength !=='') {
                        // alert(`Reddem point can not be more than ${point}`);
                        toastr.error(`Reddem point can not be more than ${point}`)
                        return false;
                    }
                });
                $('#customerSearch').modal('toggle');
                $('#customerInfo').html(`
                    <div class="flex row">
                        <div class="col-6">
                       <p> <strong id="customerName">Customer name:</strong> ${user.firstName} </p> <p> <strong>Phone:</strong>${res.phone} </p>  <p><strong>Address:</strong>${address.shippingAddress || 'Not available'}</p></div>
                       <div class="col-6">
                        <button type="button" class="btn btn-primary btn-sm" onclick="editCustomer(${JSON.stringify(user).split('"').join("&quot;")},${JSON.stringify(address).split('"').join("&quot;")})" >EditCustomer</button>
                        </div>
                </div>`)
            }
        });
    }

    function singleProduct(data,productName=null){
        $('#productType').hide()
        let sku = data;
        $.ajax({
            url: "{{ route('order.batch') }}",
            method: "post",
            async: false,
            data: {
                _token: "{{csrf_token()}}",
                sku,
                'product':productName,
            },
            success: function (data) {
                toastr.success('Product added successfully')
                $('#tableBody').html('')
                $('#tableBody').append(data.cart)
                $('#orderTotal').html(data.total)
                $('#paid_amount').val(data.total)

            },
            error:(data)=>{
                console.log(data);
                toastr.error(`${data.responseJSON.message}&#128148;`)
            }
        });
    }

    function removeItem(rowId){
        $(`#delSpinner${rowId}`).show()
        $(`#delIcon${rowId}`).hide()
        $.ajax({
            url: "{{ route('order.remove.item') }}",
            method: "post",
            data: {
                _token: "{{csrf_token()}}",
                rowId,
            },
            success: function (data) {
                console.log(data);
                $('#tableBody').html('')
                $('#tableBody').append(data.cart)
                $('#orderTotal').html(data.total)
                $('#paid_amount').val(data.total)
                toastr.success('Item removed');

                }

        });
    }

    function deliveryFee(data){
        let charge=$('option:selected', data).attr('charge')
        $('#delivery_charge').val(charge)
    }

    function increaseValue(e) {
        let id=$(e).attr('data-id');
        var value = parseInt($(`#number${id}`).val(), 10);
        value = isNaN(value) ? 0 : value;
        value++;
        $(`#number${id}`).val(value);

        //Conditions
        // let id=$(`#discount${id}`).attr('data-id');
        let value2=$(`#discount${id}`).val();
        let discount=parseInt(value2)/value;
        console.log('s',value2);
        console.log('e',discount);
        $.ajax({
            type: "POST",
            url: '{{route('order.update.quantity')}}',
            data: {
                    'id':id,
                    'quantity':value,
                    _token: "{{csrf_token()}}",
                    'type':'inc',
                    'amount':discount,
                },
            success: function (data) {
                if(data.notAvailable==true){
                    toastr.error('maximum amount reached')
                }
                $('#tableBody').html('')
                $('#tableBody').append(data.cart)
                $('#orderTotal').html(data.total)
                $('#paid_amount').val(data.total)

            }
        });
    }

    function decreaseValue(e) {
        let id=$(e).attr('data-id');
        var value =  parseInt($(`#number${id}`).val(), 10);
        value = isNaN(value) ? 0 : value;
        value < 1 ? value = 1 : '';
        value--;
        $(`#number${id}`).val(value);

        let value2=$(`#discount${id}`).val();
        let discount=parseInt(value2)/value;
        $.ajax({
            type: "POST",
            url: '{{route('order.update.quantity')}}',
            data: {
                    'id':id,
                    'quantity':value,
                    _token: "{{csrf_token()}}",
                    'type':'dec',
                    'amount':isNaN(discount) ? 0 : discount,
                },
            success: function (data) {
                $('#tableBody').html('')
                $('#tableBody').append(data.cart)
                $('#orderTotal').html(data.total)
                $('#paid_amount').val(data.total)
            }
        });
    }

    function discountPrice(e){
        let id=$(e).attr('data-id');
        let value=$(e).val();
        let quantity=$(`#number${id}`).val()
        // alert(quantity);
        let discount=parseInt(value)/parseInt(quantity);
        console.log(discount);
        $.ajax({
            type: "POST",
            url: '{{route('order.discount')}}',
            data: {
                    'id':id,
                    'amount':discount,
                    'discount':value,
                    _token: "{{csrf_token()}}",
                },
            success: function (data) {
                console.log(data);
                $('#tableBody').html('')
                $('#tableBody').append(data.cart)
                $('#orderTotal').html(data.total)
                $('#paid_amount').val(data.total)

            }
        });
    }

    function newCustomer(){
        $.ajax({
            url: "{{route('user.customer.store')}}",
            method: 'post',
            cache: false,
            processData: false,
            contentType: false,
            data:new FormData($('#newCustomerSave')[0]),
            success: function (response) {
                console.log(response);
                toastr.success('Customer added successfully')
                $('#exampleModal').modal('hide')
                $('#newCustomerSave').trigger('reset')
                let { user,address } = response
                $('#customerId').val(`${response.customerId}`)
                $('#customerInfo').html(`
                    <div class="flex row">
                        <div class="col-6">
                       <p> <strong id="customerName">Customer name:</strong> ${user.firstName} </p> <p> <strong>Phone:</strong>${user.phone} </p>  <p><strong>Address:</strong>${address.shippingAddress || 'Not available'}</p></div>
                       <div class="col-6">
                        <button type="button" class="btn btn-primary btn-sm" onclick="editCustomer(${JSON.stringify(user).split('"').join("&quot;")},${JSON.stringify(address).split('"').join("&quot;")})" >EditCustomer</button>
                        </div>
                </div>`)
            },
            error: function (err) {
                if (err.status === 422) {
                    $("#newCustomerSave").find("small").remove();
                    $.each(err.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        var errorMSG = error[0].replace('[]', '');
                        el.after($('<small style="color: red;font-weight: bold;">' + errorMSG + '</small>'));
                    });
                }
            }
        });
    }

    function customerModal() {
        $('#customerAdd').append(
            `<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New customer</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="newCustomerSave">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform1">First name:</label>
                                            <input type="text" id="firstName" class="form-control" placeholder="Info here" name="firstName">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform2">Last name:</label>
                                            <input type="text" id="lastName" class="form-control" placeholder="Info here" name="lastName">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform3">Email</label>
                                            <input type="text" id="email" class="form-control" placeholder="Info here" name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform4">Phone</label>
                                            <input type="text" id="phone" class="form-control" placeholder="Info here" name="phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform1">Optional phone</label>
                                            <input type="text" id="optional_phone" class="form-control" placeholder="Info here" name="optional_phone">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform2">Billing address</label>
                                            <input type="text" id="billingAddress" class="form-control" placeholder="Info here" name="billingAddress">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform3">Shipping address</label>
                                            <input type="text" id="shippingAddress" class="form-control" placeholder="Info here" name="shippingAddress">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" onclick="newCustomer()" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>`
        )
        $('#exampleModal').modal('show')
    }

    function shopSale(data) {
        if(data=='online')
        {
            $('#totalDelivery').show()
        }
        else{
            $('#totalDelivery').hide()
        }
    }

    function orderSubmit() {
        if($('#customerName').length == 0 && $('#payment_type:checked').val() =='due'){
                toastr.error('To make due payment user has to be customer')
        }
        else
        {
            $.ajax({
            url: "{{route('order.insert')}}",
            method: 'post',
            cache: false,
            processData: false,
            contentType: false,
            data:
                new FormData($('#orderForm')[0]),
            success: function (response) {
                console.log(response);
                $('#orderForm').trigger("reset");
                $(".app-content").find("small").remove();
                $('#search').val("");
                $('#orderTotal').html("")
                $('#tableBody').html(`<tr id="initial">
                    <td style="text-align: center" colspan="7">No product has been added</td>
                </tr>`)
                toastr.success('Order added successfully')
            },
            error: function (err) {
                if (err.status === 422) {
                    $("#orderForm").find("small").remove();
                    $.each(err.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        var errorMSG = error[0].replace('[]', '');
                        el.after($('<small style="color: red;font-weight: bold;">' + errorMSG + '</small>'));
                    });
                }
            }
            });
        }

    }

    function orderDue(e) {
        let paid=parseInt($(e).val());
        let total=parseInt($('#orderTotal').html())
        if(total != NaN){
            $('#due_amount').val(total-paid)
        }
    }

    function categoryProduct(data) {
        $('#deliverySpin').show()
        $('#productList').hide()
        $('#productCard').show()
        $.ajax({
            url: "{{ route('product.search') }}",
            method: "post",
            data: {
                _token: "{{csrf_token()}}",
                category: $(data).val(),
            },
            success: function (response) {
                console.log('sds',response.product);
                $('#deliverySpin').hide()
                $('#productList').show()
                $('#productList').html('')
                if(response.product.length>0){
                    response.product.forEach((value) =>{
                        console.log(value);
                    $('#productList').append(`
                    <a href="#" onclick="${value.type =="single" ?`singleProduct('${value.sku[0].skuId}','${value.productName}')` : `variationSelectRight('${JSON.stringify(value).split('"').join("&quot;")}')`}" <div class="col-lg-3 col-6 mb-2 px-1 pb-0">
                            <div class="card text-center p-1 pb-0 h-100 mb-0" style="border: 1px solid #eee; padding-bottom: 0 !important;">
                                <img onerror="this.src='{{url('public/featureImage/default.jpg')}}'" src="{{url('public/featureImage')}}/${value.featureImage == null ? 'default.jpg' : `${value.featureImage}`}" alt="" style="max-width: 120px; height: auto;">
                                <div class="card-body p-0">
                                    <h6 class="mb-0" style="font-size: 13px;">${value.productName}</h6>
                                    <p class="card-text">
                                        <small class="text-muted">(${value.productId})</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        </a>`)
                    })
                }

            }
        });
    }

    function brandProduct(data) {
        console.log($(data).val());
        $('#deliverySpin').show()
        $('#productList').hide()
        $('#productCard').show()
        $.ajax({
            url: "{{ route('product.search') }}",
            method: "post",
            data: {
                _token: "{{csrf_token()}}",
                brand: $(data).val(),
            },
            success: function (response) {
                console.log(response.product.length);
                $('#deliverySpin').hide()
                $('#productList').show()
                $('#productList').html('')
                if(response.product.length>0){
                    response.product.forEach(value=>{
                        $('#productList').append(`
                        <a href="#" onclick="${value.type =="single" ?`singleProduct('${value.sku[0].skuId}','${value.productName}')` : `variationSelectRight('${JSON.stringify(value).split('"').join("&quot;")}')`}" <div class="col-lg-3 col-6 mb-2 px-1 pb-0">
                            <div class="card text-center p-1 pb-0 h-100 mb-0" style="border: 1px solid #eee; padding-bottom: 0 !important;">
                                <img onerror="this.src='{{url('public/featureImage/default.jpg')}}'" src="{{url('public/featureImage')}}/${value.featureImage == null ? 'default.jpg' : `${value.featureImage}`}" alt="" style="max-width: 120px; height: auto;">
                                <div class="card-body p-0">
                                    <h6 class="mb-0" style="font-size: 13px;">${value.productName}</h6>
                                    <p class="card-text">
                                        <small class="text-muted">(${value.productId})</small>
                                    </p>
                                </div>
                            </div>
                            </div>
                        </a>`)
                    })
                }
            }
        });
    }

    function clearCart() {
        $('#delSpinner').show()
        $(`#delIcon`).hide()
        $.ajax({
            url: "{{ route('order.remove.item') }}",
            method: "post",
            data: {
                _token: "{{csrf_token()}}",
            },
            success: function (data) {
                    console.log(data);
                    $('#tableBody').html('')
                    $('#tableBody').append(data.cart)
                    $('#orderTotal').html(data.total)
                    $('#paid_amount').val(data.total)
                    $(`#delSpinner`).hide()
                    $(`#delIcon`).show()
                }

        });
    }

    $("#searchBar").onEnter(function() {
        $.ajax({
            url: "{{ route('product.search') }}",
            method: "post",
            data: {
                _token: "{{csrf_token()}}",
                barCode: $('#searchBar').val(),
            },
            success: function (response) {
                console.log('s');
                $('#searchBar').val(`${response.product.productName}`)
                if(response.product.type == "variation"){
                    variationSelectRight(response.product,1)
                }
                else{
                     singleProduct(response.product.sku[0].skuId,response.product.productName)
                }
            },
            error:(response)=>{
                toastr.error(`${response.responseJSON.message}&#128148;`)
            }
        });
    });

    function paymentTypeChange(data) {
       if($(data).val() == 'due'){
           $('#paid_amount').prop('disabled',true)
            $('#collectAmount').hide()
            $('#returnAmount').hide();


       }
       else if($(data).val() == 'partial'){
            $('#paid_amount').prop('disabled',false)
            if($('#customerName').length == 0){
                toastr.error('To make partial payment user has to be customer')
        }

        }

        else{
            $('#paid_amount').prop('disabled',false)
        }
    }

    function orderTotal(data) {
        let total = $('#orderTotal').html()
        if(!isNaN(total)){
            $(data).val(total);
        }
        $('#collectAmount').show()

    }

    function returnAmount(data) {
        let returnAmount= parseInt($(data).val())-parseInt($('#paid_amount').val())
        console.log(returnAmount);
        if(!isNaN(returnAmount) && returnAmount >= 0){
            $('#returnAmount').show();
            $('#return_amount').val(returnAmount);
            toastr.warning(`Please return this amount ${returnAmount}`)
        }
        else{
            $('#returnAmount').hide();
        }
    }

    function editCustomer(user,address) {
        $('#customerAdd').append(
            `<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New customer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="newCustomerSave">
                                @csrf
                                <input type="hidden" name="id" value="${user.userId}">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform1">First name:</label>
                                            <input type="text" id="firstName" class="form-control" placeholder="Info here" name="firstName" value="${user.firstName}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform2">Last name:</label>
                                            <input type="text" id="lastName" class="form-control" placeholder="Info here" name="lastName" value="${user.lastName}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform3">Email</label>
                                            <input type="text" id="email" class="form-control" placeholder="Info here" name="email" value="${user.email}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform4">Phone</label>
                                            <input type="text" id="phone" class="form-control" placeholder="Info here" name="phone" value="${user.phone}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform1">Optional phone</label>
                                            <input type="text" id="optional_phone" class="form-control" placeholder="Info here" name="optional_phone">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform2">Billing address</label>
                                            <input type="text" id="billingAddress" class="form-control" placeholder="Info here" name="billingAddress" value="${address.billingAddress}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left" for="deliveryform3">Shipping address</label>
                                            <input type="text" id="shippingAddress" class="form-control" placeholder="Info here" name="shippingAddress" value="${address.shippingAddress || ""}">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button"  onclick="newCustomer()" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>`
        )
        $('#exampleModal').modal('show')
    }
</script>
@endsection
