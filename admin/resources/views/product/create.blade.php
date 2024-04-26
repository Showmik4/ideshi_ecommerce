@extends('layouts.main')
@section('title'){{ 'Product Create' }}@endsection
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
                        <h3>Product Create</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Product</li>
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
                            <form class="form-wizard" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="productName">Product Name</label>
                                            <input class="form-control" id="productName" name="productName" type="text" placeholder="Product Name" value="{{ old('productName') }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('productName') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="productCode">Product Code</label>
                                            <input class="form-control" id="productCode" name="productCode" type="text" placeholder="Product Code" value="{{ old('productCode') }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('productCode') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input class="form-control" id="slug" name="slug" type="text" placeholder="Slug" value="{{ old('slug') }}">
                                            <span class="text-danger"><b>{{  $errors->first('slug') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tag">Tag</label>
                                            <input class="form-control" id="tag" name="tag" type="text" placeholder="Tag" value="{{ old('tag') }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('tag') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fkCategoryId">Category</label>
                                            <select class="form-control" name="fkCategoryId" id="fkCategoryId" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->categoryId }}">{{ $category->categoryName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('fkCategoryId') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fkBrandId">Brand</label>
                                            <select class="form-control" name="fkBrandId" id="fkBrandId" required>
                                                <option value="">Select Brand</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->brandId }}">{{ $brand->brandName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('fkBrandId') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fkUnitId">Unit</label>
                                            <select class="form-control" name="fkUnitId" id="fkUnitId" required>
                                                <option value="">Select Unit</option>
                                                @foreach($units as $unit)
                                                    <option value="{{ $unit->unitId }}">{{ $unit->unitName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('fkUnitId') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="type">Product Type</label>
                                            <select class="form-control" name="type" id="type" required>
                                                <option value="">Select Product Type</option>
                                                <option value="single">Single</option>
                                                <option value="variation">Variation</option>
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('type') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="featureImage">Feature Image</label>
                                            <input class="form-control" id="featureImage" name="featureImage" type="file" required>
                                            <span class="text-danger"><b>{{ $errors->first('featureImage') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="shortDescription">Short Description</label>
                                            <textarea class="form-control" name="shortDescription" id="shortDescription" placeholder="Short Description" required>{{ old('shortDescription') }}</textarea>
                                            <span class="text-danger"><b>{{ $errors->first('shortDescription') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="longDescription">Long Description</label>
                                            <textarea class="form-control" name="longDescription" id="longDescription" placeholder="Long Description">{{ old('longDescription') }}</textarea>
                                            <span class="text-danger"><b>{{ $errors->first('longDescription') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fabricDetails">Fabric Details</label>
                                            <textarea class="form-control" name="fabricDetails" id="fabricDetails" placeholder="Fabric Details">{{ old('fabricDetails') }}</textarea>
                                            <span class="text-danger"><b>{{ $errors->first('fabricDetails') }}</b></span>
                                        </div>  
                                        <div class="mb-3">
                                            <label for="patternDetails">Pattern</label>
                                            <textarea class="form-control" name="pattern" id="" placeholder="Pattern Details">{{ old('pattern') }}</textarea>
                                            <span class="text-danger"><b>{{ $errors->first('pattern') }}</b></span>
                                        </div>                    
                                        <div class="mb-3">
                                            <label for="fit">Fit</label>                                           
                                            <select name="fit" class="form-control">
                                                <option value="">Select Product Fit</option>
                                                <option value="Slim Fit">Slim Fit</option>
                                                <option value="Regular Fit">Regular Regular</option>                                               
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('fit') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nace">Neck</label>
                                            <textarea class="form-control" name="nace" id="" placeholder="Neck Details"></textarea>
                                            <span class="text-danger"><b>{{ $errors->first('nace') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sleeve">Sleeve</label>
                                            <select name="sleeve" class="form-control">
                                                <option value="">Select Product Sleeves</option>
                                                <option value="Half-sleeves">Half</option>
                                                <option value="Full-sleeves">Full</option>                                               
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('sleeve') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="style">Style</label>
                                            <textarea class="form-control" name="style" id="" placeholder="Style Details">{{ old('style') }}</textarea>
                                            <span class="text-danger"><b>{{ $errors->first('style') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="newArrived">New Arrived</label>
                                            <input type="checkbox" id="newArrived" name="newArrived" value="1">
                                            <span class="text-danger"><b>{{ $errors->first('newArrived') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="isRecommended">Is Recommended</label>
                                            <input type="checkbox" id="isRecommended" name="isRecommended" value="1">
                                            <span class="text-danger"><b>{{ $errors->first('isRecommended') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status">Product Status</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="">Select Product Status</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('status') }}</b></span>
                                        </div>

                                        <div id="singleForm">
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <label for="barcodeSingle">Barcode</label>
                                                        <input class="form-control" id="barcodeSingle" name="barcode" type="text" placeholder="Barcode" value="{{ old('barcode') }}">
                                                        <span class="text-danger"><b>{{  $errors->first('barcode') }}</b></span>
                                                    </div>
                                                    <div class="col-md-2" style="margin-top: 30px">
                                                        <button class="btn btn-primary" id="generateBarcodeSingle">Generate</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="regularPrice">Stock Quantity</label>
                                                <input class="form-control" id="sQuantity" name="sQuantity" type="number" min="1" placeholder="Regular Price" value="{{ old('sQuantity') }}">
                                                <span class="text-danger"><b>{{  $errors->first('sQuantity') }}</b></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="regularPrice">Regular Price</label>
                                                <input class="form-control regularPrice" id="regularPrice" name="regularPrice" type="number" min="1" step="0.01" placeholder="Regular Price" value="{{ old('regularPrice') }}">
                                                <span class="text-danger"><b>{{  $errors->first('regularPrice') }}</b></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="discountType">Discount Type</label>
                                                <select class="form-control discountType" name="discountType" id="discountType">
                                                    <option value="">Select Discount Type</option>
                                                    <option value="flat">Flat</option>
                                                    <option value="percent">Percent</option>
                                                </select>
                                                <span class="text-danger"><b>{{ $errors->first('discountType') }}</b></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="discount">Discount</label>
                                                <input class="form-control discount" id="discount" name="discount" type="number" min="1" step="0.01" placeholder="Discount" value="{{ old('discount') }}">
                                                <span class="text-danger"><b>{{  $errors->first('discount') }}</b></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="salePrice">Sale Price</label>
                                                <input class="form-control salePrice" id="salePrice" name="salePrice" type="number" min="1" step="0.01" placeholder="Sale Price" value="{{ old('salePrice') }}">
                                                <span class="text-danger"><b>{{  $errors->first('salePrice') }}</b></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="stockAlert">Stock Alert</label>
                                                <input class="form-control" id="stockAlert" name="stockAlert" type="number" min="1" placeholder="Stock Alert" value="{{ old('stockAlert') }}">
                                                <span class="text-danger"><b>{{  $errors->first('stockAlert') }}</b></span>
                                            </div>
                                            <div class="mb-3 px-2">
                                                <div class="row multiple-image">
                                                <label for="image">Product Images (can attach more than one)</label>
                                                <input class="form-control"  name="image[]" type="file" multiple>
                                                <span class="text-danger"><b>{{ $errors->first('image') }}</b></span>
                                                <div class="col-md-12 text-center add_remove_button mb-3 mt-2">
                                                    <button class="btn btn-primary" id="add-button">+</button>
                                                    <button class="btn btn-danger" id="remove-button">-</button>
                                                </div>    
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('product.show') }}">Cancel</a></button>
                                            <button class="btn btn-primary" type="submit">Create</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div id="variationForm">
                                <br>
                                <h4>Variation Create</h4>
                                <br>
                                <form class="form-wizard" enctype="multipart/form-data" id="variationStore">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <label for="variationType1">Variation Type 1</label>
                                                    <select class="form-control" name="variationType1" id="variationType1">
                                                        <option value="" selected>Select Variation Type 1</option>
                                                        @foreach($variations->unique('variationType') as $variationType)
                                                            <option value="{{ $variationType->variationType }}">{{ $variationType->variationType }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="ajaxErrorSpan mb-2 text-danger" id="variationType1Error"></span>
                                                </div>
                                                <div class="mb-3" id="variationValueDiv1">
                                                    <label for="variationValue1">Variation Value 1</label>
                                                    <select name="variationValue1" id="variationValue1" class="form-control">
                                                        <option value="" selected>Select Variation Value 1</option>
                                                    </select>
                                                    <span class="ajaxErrorSpan mb-2 text-danger" id="variationValue1Error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="variationType2">Variation Type 2</label>
                                                    <select class="form-control" name="variationType2" id="variationType2">
                                                        <option value="" selected>Select Variation Type 2</option>
                                                        @foreach($variations->unique('variationType') as $variationType)
                                                            <option value="{{ $variationType->variationType }}">{{ $variationType->variationType }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="ajaxErrorSpan text-danger" id="variationType2Error"></span>
                                                </div>
                                                <div class="mb-3" id="variationValueDiv2">
                                                    <label for="variationValue2">Variation Value 2</label>
                                                    <select name="variationValue2" id="variationValue2" class="form-control">
                                                        <option value="" selected>Select Variation Value 2</option>
                                                    </select>
                                                    <span class="ajaxErrorSpan text-danger" id="variationValue2Error"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <label for="barcodeVariation">Barcode</label>
                                                            <input class="form-control" id="barcodeVariation" name="barcode" type="text" placeholder="Barcode" value="{{ old('barcode') }}" required>
                                                            <span class="ajaxErrorSpan text-danger" id="barcodeError"></span>
                                                        </div>
                                                        <div class="col-md-2" style="margin-top: 30px">
                                                            <button class="btn btn-primary" id="generateBarcodeVariation">Generate</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="sQuantityVar">Stock Quantity</label>
                                                    <input class="form-control" id="sQuantityVar" name="sQuantityVar" type="number" min="1" step="0.01" placeholder="Stock Quantity" value="{{ old('sQuantityVar') }}" required>
                                                    <span class="ajaxErrorSpan text-danger" id="sQuantityVarError"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="regularPrice">Regular Price</label>
                                                    <input class="form-control variantRegularPrice" id="regularPrice" name="regularPrice" type="number" min="1" step="0.01" placeholder="Regular Price" value="{{ old('regularPrice') }}" required>
                                                    <span class="ajaxErrorSpan text-danger" id="regularPriceError"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="discountType">Discount Type</label>
                                                    <select class="form-control variantDiscountType" name="discountType" id="discountType">
                                                        <option value="">Select Discount Type</option>
                                                        <option value="flat">Flat</option>
                                                        <option value="percent">Percent</option>
                                                    </select>
                                                    <span class="ajaxErrorSpan text-danger" id="discountTypeError"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="discount">Discount</label>
                                                    <input class="form-control variantDiscount" id="discount" name="discount" type="number" min="" step="0.01" placeholder="Discount" value="{{ old('discount') }}">
                                                    <span class="ajaxErrorSpan text-danger" id="discountError"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="salePrice">Sale Price</label>
                                                    <input class="form-control variantSalePrice" id="salePrice" name="salePrice" type="number" min="" step="0.01" placeholder="Sale Price" value="{{ old('salePrice') }}">
                                                    <span class="ajaxErrorSpan text-danger" id="salePriceError"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="stockAlert">Stock Alert</label>
                                                    <input class="form-control" id="stockAlert" name="stockAlert" type="number" min="1" placeholder="Stock Alert" value="{{ old('stockAlert') }}" required>
                                                    <span class="ajaxErrorSpan text-danger" id="stockAlertError"></span>
                                                </div>
                                                {{-- <div class="mb-3">
                                                    <label for="variationImage">Product Images (can attach more than one)</label>
                                                    <input class="form-control" id="variationImage" name="variationImage[]" type="file" multiple>
                                                    <span class="ajaxErrorSpan text-danger" id="variationImageError"></span>
                                                </div> --}}
                                                <div class="mb-3 px-2">
                                                    <div class="row multiple-variant-image">
                                                    <label for="image">Product Images (can attach more than one)</label>
                                                    <input class="form-control" id="variationImage" name="variationImage[]" type="file" multiple>
                                                    <span class="ajaxErrorSpan text-danger" id="variationImageError"></span>
                                                    <div class="col-md-12 text-center add_remove_variant_button mb-3 mt-2">
                                                        <button class="btn btn-primary" id="add-variant-button">+</button>
                                                        <button class="btn btn-danger" id="remove-variant--button">-</button>
                                                    </div>    
                                                    </div>
                                                </div>

                                                <div class="text-end btn-mb">
                                                    <button class="btn btn-info" type="submit">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--Temp Variation Table-->
                            <div id="variationList"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer.js')
    <script>
        $('#singleForm').hide()
        $('#variationForm').hide()

        $('#generateBarcodeSingle').on('click', function (e) 
        {
            e.preventDefault()
            $('#barcodeSingle').val('')
            let val1 = Math.floor(100000 + Math.random() * 999999);
            let val2 = Math.floor(10000 + Math.random() * 99999);
            $('#barcodeSingle').val('7 '+val1+' '+val2);
        })

        $('#generateBarcodeVariation').on('click', function (e) {
            e.preventDefault()
            $('#barcodeVariation').val('')
            let val1 = Math.floor(100000 + Math.random() * 999999);
            let val2 = Math.floor(10000 + Math.random() * 99999);
            $('#barcodeVariation').val('7 '+val1+' '+val2);
        })

        //Product Type (single/variation) Select
        $("#type").change(function(){
            let productType = this.value;
            if (productType === 'variation') {
                $("#singleForm").hide();
                $("#variationForm").show();
            } else if (productType === 'single') 
            {
                $("#singleForm").show();
                $("#variationForm").hide();
            } else {
                $("#variationForm").hide();
                $("#singleForm").hide();
            }
        });

        // 1st Variation Type Change
        $("#variationType1").change(function(){
            let variationType = this.value;
            $.ajax({
                type: "POST",
                url: "{{route('product.variationTypeChange')}}",
                data: {_token: "{{ csrf_token() }}", 'variationType': variationType},
                success: function (data){
                    $('#variationValue1').empty()
                    $('#variationValue1').append(`
                        <option value="">Select Variation Value 1</option>
                    `)
                    data.variations.forEach(function (item, index, arr){
                        if(item.variationType === 'color' || item.variationType === 'Color') {
                            $('#variationValue1').append('<option value="'+item.variationId+'" style="background-color: '+item.variationValue+'">'+item.variationValue+'</option>')
                        } else {
                            $('#variationValue1').append('<option value="'+item.variationId+'">'+item.variationValue+'</option>')
                        }
                    })
                }
            });
        });

        // 2nd Variation Type Change
        $("#variationType2").change(function(){
            let variationType = this.value;
            $.ajax({
                type: "POST",
                url: "{{route('product.variationTypeChange')}}",
                data: {_token: "{{ csrf_token() }}", 'variationType': variationType},
                success: function (data){
                    $('#variationValue2').empty()
                    $('#variationValue2').append(`
                        <option value="">Select Variation Value 1</option>
                    `)
                    data.variations.forEach(function (item, index, arr){
                        if(item.variationType === 'color' || item.variationType === 'Color') {
                            $('#variationValue2').append('<option value="'+item.variationId+'" style="background-color: '+item.variationValue+'">'+item.variationValue+'</option>')
                        } else {
                            $('#variationValue2').append('<option value="'+item.variationId+'">'+item.variationValue+'</option>')
                        }
                    })
                }
            });
        });

        // Variation Store
        $( "#variationStore" ).on( "submit", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{route('product.variationStore')}}",
                data: new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $("#variationList").html(data.html);
                    $("#variationStore").trigger('reset');
                    $('#variationForm').hide()
                },
                error: function(response) {
                    $('#barcodeError').empty().text(response.responseJSON.errors.barcode);
                    $('#variationType1Error').empty().text(response.responseJSON.errors.variationType1);
                    $('#variationValue1Error').empty().text(response.responseJSON.errors.variationValue1);
                    $('#variationType2Error').empty().text(response.responseJSON.errors.variationType2);
                    $('#variationValue2Error').empty().text(response.responseJSON.errors.variationValue2);
                    $('#regularPriceError').empty().text(response.responseJSON.errors.regularPrice);
                    $('#discountError').empty().text(response.responseJSON.errors.discount);
                    $('#discountTypeError').empty().text(response.responseJSON.errors.discountType);
                    $('#salePriceError').empty().text(response.responseJSON.errors.salePrice);
                    $('#stockAlertError').empty().text(response.responseJSON.errors.stockAlert);
                    $('#variationImageError').empty().text(response.responseJSON.errors.variationImage);
                }
            });
            e.preventDefault();
        });
    </script>
    <script>
          $(document).ready(function() 
          {
        $('.discountType, .discount, .regularPrice').on('input', function() 
        {
            updateSalePrice();
        });

        function updateSalePrice() 
        {
            var discountType = $('.discountType').val();
            var discount = parseFloat($('.discount').val()) || 0;
            var regularPrice = parseFloat($('.regularPrice').val()) || 0;
            var salePrice = 0;

            if (discountType === 'flat') 
            {
                salePrice = regularPrice - discount;
            } else if (discountType === 'percent') 
            {
                salePrice = regularPrice - (regularPrice * (discount / 100));
            }

            $('.salePrice').val(Math.round(salePrice));
        }
    });
    </script>

    <script>
        $(document).ready(function() 
        {
    $('.variantDiscountType, .variantDiscount, .variantRegularPrice').on('input', function() 
    {
        updateVariantSalePrice();
    });

    function updateVariantSalePrice() 
    {
        var discountType = $('.variantDiscountType').val();
        var discount = parseFloat($('.variantDiscount').val()) || 0;
        var regularPrice = parseFloat($('.variantRegularPrice').val()) || 0;
        var salePrice = 0;

        if (discountType === 'flat') 
        {
            salePrice = regularPrice - discount;
        } else if (discountType === 'percent') 
        {
            salePrice = regularPrice - (regularPrice * (discount / 100));
        }

        $('.variantSalePrice').val(Math.round(salePrice));
    }
    });

    //Add Multi Image
    document.addEventListener("DOMContentLoaded", function () {
        const addButton = document.getElementById("add-button");
        const removeButton = document.getElementById("remove-button");

        addButton.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent form submission
            var newRow = `
            <div class="row multiple-image">
                <label for="image">Product Images (can attach more than one)</label>
                <input class="form-control"  name="image[]" type="file" multiple>           
            </div>
            `;

            var newRowContainer = document.createElement("div");
            newRowContainer.innerHTML = newRow;

            var addButtonContainer = document.querySelector('.add_remove_button');
            addButtonContainer.insertAdjacentElement("beforebegin", newRowContainer);
        });

        removeButton.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent form submission
            var packageItinerariesRow = document.querySelectorAll(".multiple-image");
            if (packageItinerariesRow.length > 0) {               
                packageItinerariesRow[packageItinerariesRow.length - 1].remove();
            }
        });
    });

      //Add Multi variant Image
      document.addEventListener("DOMContentLoaded", function () {
        const addButton = document.getElementById("add-variant-button");
        const removeButton = document.getElementById("remove-variant-button");

        addButton.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent form submission
            var newRow = `
            <div class="row multiple-variant-image">
            <label for="image">Product Images (can attach more than one)</label>
            <input class="form-control" id="variationImage" name="variationImage[]" type="file" multiple>
            <span class="ajaxErrorSpan text-danger" id="variationImageError"></span>            
            </div>
            `;

            var newRowContainer = document.createElement("div");
            newRowContainer.innerHTML = newRow;

            var addButtonContainer = document.querySelector('.add_remove_variant_button');
            addButtonContainer.insertAdjacentElement("beforebegin", newRowContainer);
        });

        removeButton.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent form submission
            var packageItinerariesRow = document.querySelectorAll(".multiple-variant-image");
            if (packageItinerariesRow.length > 0) {               
                packageItinerariesRow[packageItinerariesRow.length - 1].remove();
            }
        });
    });
</script>
@endsection
