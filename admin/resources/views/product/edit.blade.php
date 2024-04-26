@extends('layouts.main')
@section('title'){{ 'Product Edit' }}@endsection
@section('header.css')
    <style>
        .product-img-with-delete {
            position: relative;
            width: 100px;
            height: 100px;
        }
        .product-img-with-delete img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        .product-img-with-delete .hover-icon {
            display: none;
        }
        .product-img-with-delete:hover .hover-icon {
            display: block;
        }
        .product-img-with-delete .hover-icon {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #00000040;
            text-align: center;
            transition: 0.5s;
        }
        .product-img-with-delete .hover-icon i {
            padding-top: 48%;
            color: #fff;
            cursor: pointer;
        }
    </style>
@endsection
@section('main.content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Product Edit</h3>
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
                            <form class="form-wizard" action="{{ route('product.update', $product->productId) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="productName">Product Name</label>
                                            <input class="form-control" id="productName" name="productName" type="text" placeholder="Product Name" value="{{ @$product->productName }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('productName') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="productCode">Product Code</label>
                                            <input class="form-control" id="productCode" name="productCode" type="text" placeholder="Product Code" value="{{ @$product->productCode }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('productCode') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input class="form-control" id="slug" name="slug" type="text" placeholder="Slug" value="{{ @$product->slug }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('slug') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tag">Tag</label>
                                            <input class="form-control" id="tag" name="tag" type="text" placeholder="Tag" value="{{ @$product->tag }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('tag') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fkCategoryId">Category</label>
                                            <select class="form-control" name="fkCategoryId" id="fkCategoryId" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->categoryId }}" @if($category->categoryId === $product->fkCategoryId) selected @endif>{{ $category->categoryName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('fkCategoryId') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fkBrandId">Brand</label>
                                            <select class="form-control" name="fkBrandId" id="fkBrandId" required>
                                                <option value="">Select Brand</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->brandId }}" @if($brand->brandId === $product->fkBrandId) selected @endif>{{ $brand->brandName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('fkBrandId') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fkUnitId">Unit</label>
                                            <select class="form-control" name="fkUnitId" id="fkUnitId" required>
                                                <option value="">Select Unit</option>
                                                @foreach($units as $unit)
                                                    <option value="{{ $unit->unitId }}" @if($unit->unitId === $product->fkUnitId) selected @endif>{{ $unit->unitName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('fkUnitId') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="type">Product Type</label>
                                            <select class="form-control" name="type" id="type" onchange="productTypeChange()" required>
                                                <option value="">Select Product Type</option>
                                                <option value="single" @if($product->type === 'single') selected @endif>Single</option>
                                                <option value="variation" @if($product->type === 'variation') selected @endif>Variation</option>
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('type') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="featureImage">Feature Image</label>
                                            <input class="form-control" id="featureImage" name="featureImage" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('featureImage') }}</b></span>
                                        </div>
                                        @if(isset($product->featureImage))
                                        <div class="mb-3">
                                            <img src="{{ url(@$product->featureImage) }}" height="100px" width="100px" alt="">
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <label for="shortDescription">Short Description</label>
                                            <textarea class="form-control" name="shortDescription" id="shortDescription" placeholder="Short Description" required>{{ @$product->productDetails->shortDescription }}</textarea>
                                            <span class="text-danger"><b>{{ $errors->first('shortDescription') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="longDescription">Long Description</label>
                                            <textarea class="form-control" name="longDescription" id="longDescription" placeholder="Long Description">{{ @$product->productDetails->longDescription }}</textarea>
                                            <span class="text-danger"><b>{{ $errors->first('longDescription') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fabricDetails">Fabric Details</label>
                                            <textarea class="form-control" name="fabricDetails" id="fabricDetails" placeholder="Fabric Details">{{ @$product->productDetails->fabricDetails }}</textarea>
                                            <span class="text-danger"><b>{{ $errors->first('fabricDetails') }}</b></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="pattern">Pattern</label>
                                            <input class="form-control" name="pattern" id="" placeholder="Fabric Details" value="{{@$product->productDetails->pattern}}">
                                            <span class="text-danger"><b>{{ $errors->first('pattern') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fit">Fit</label>                                           
                                            <select name="fit" class="form-control">
                                                <option value="">Select Product Fit</option>
                                                <option value="Slim Fit" @if($product->productDetails->fit === 'Slim Fit') selected @endif>Slim Fit</option>
                                                <option value="Regular Fit" @if($product->productDetails->fit === 'Regular Fit') selected @endif>Regular Regular</option>                                               
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('fit') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="neck">Neck</label>
                                            <input class="form-control" name="neck" id="" value="{{@$product->productDetails->nace}}" placeholder="Nace Details">
                                            <span class="text-danger"><b>{{ $errors->first('neck') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sleeve">Sleeve</label>
                                            <select name="sleeve" class="form-control">
                                                <option value="">Select Product Sleeves</option>
                                                <option value="Half-sleeves" @if(@$product->productDetails->sleeve === 'Half-sleeves') selected @endif>Half</option>
                                                <option value="Full-sleeves" @if(@$product->productDetails->sleeve === 'Full-sleeves') selected @endif>Full</option>                                               
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('sleeve') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="style">Style</label>
                                            <textarea class="form-control" name="style" id="">{{@$product->productDetails->style}}</textarea>
                                            <span class="text-danger"><b>{{ $errors->first('style') }}</b></span>
                                        </div>                                      
                                        <div class="mb-3">
                                            <label for="newArrived">New Arrived</label>
                                            <input type="checkbox" id="newArrived" name="newArrived" value="1" @if(@$product->newArrived === 1) checked @endif>
                                            <span class="text-danger"><b>{{ $errors->first('newArrived') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="isRecommended">Is Recommended</label>
                                            <input type="checkbox" id="isRecommended" name="isRecommended" value="1" @if(@$product->isRecommended === 1) checked @endif>
                                            <span class="text-danger"><b>{{ $errors->first('isRecommended') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status">Product Status</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="">Select Product Status</option>
                                                <option value="active" @if($product->status === 'active') selected @endif>Active</option>
                                                <option value="inactive" @if($product->status === 'inactive') selected @endif>Inactive</option>
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('status') }}</b></span>
                                        </div>

                                        <div id="singleForm">
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <label for="barcodeSingle">Barcode</label>
                                                        <input class="form-control" id="barcodeSingle" name="barcode" type="text" placeholder="Barcode" value="{{ $product->type === 'single' ? @$product->sku->first()->barcode : old('barcode') }}">
                                                        <span class="text-danger"><b>{{  $errors->first('barcode') }}</b></span>
                                                    </div>
                                                    <div class="col-md-2" style="margin-top: 30px">
                                                        <button class="btn btn-primary" id="generateBarcodeSingle">Generate</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="regularPrice">Stock Quantity</label>
                                                <input class="form-control" id="sQuantity" name="sQuantity" type="number" min="" value="{{ @$stock }}">
                                                <span class="text-danger"><b>{{  $errors->first('sQuantity') }}</b></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="regularPrice">Regular Price</label>
                                                <input class="form-control" id="regularPrice" name="regularPrice" type="number" min="1" step="0.01" placeholder="Regular Price" value="{{ $product->type === 'single' ? @$product->sku->first()->regularPrice : old('regularPrice') }}">
                                                <span class="text-danger"><b>{{  $errors->first('regularPrice') }}</b></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="discountType">Discount Type</label>
                                                <select class="form-control" name="discountType" id="discountType">
                                                    <option value="">Select Discount Type</option>
                                                    <option value="flat" @if($product->type === 'single' && $product->sku->first()->discountType === 'flat') selected @endif>Flat</option>
                                                    <option value="percent" @if($product->type === 'single' && $product->sku->first()->discountType === 'percent') selected @endif>Percent</option>
                                                </select>
                                                <span class="text-danger"><b>{{ $errors->first('discountType') }}</b></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="discount">Discount</label>
                                                <input class="form-control" id="discount" name="discount" type="text"  step="0.01" placeholder="Discount" value="{{ $product->type === 'single' ? @$product->sku->first()->discount : old('discount') }}">
                                                <span class="text-danger"><b>{{  $errors->first('discount') }}</b></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="salePrice">Sale Price</label>
                                                <input class="form-control" id="salePrice" name="salePrice" type="text"  step="0.01" placeholder="Sale Price" value="{{ $product->type === 'single' ? @$product->sku->first()->salePrice : old('salePrice') }}">
                                                <span class="text-danger"><b>{{  $errors->first('salePrice') }}</b></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="stockAlert">Stock Alert</label>
                                                <input class="form-control" id="stockAlert" name="stockAlert" type="text" min="1" placeholder="Stock Alert" value="{{ $product->type === 'single' ? @$product->sku->first()->stockAlert : old('stockAlert') }}">
                                                <span class="text-danger"><b>{{  $errors->first('stockAlert') }}</b></span>
                                            </div>
                                            {{-- <div class="mb-3">
                                                <label for="image">Product Images (can attach more than one)</label>
                                                <input class="form-control" id="image" name="image[]" type="file" multiple>
                                                <span class="text-danger"><b>{{ $errors->first('image') }}</b></span>
                                            </div> --}}
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
                                            @if($product->type === 'single' && !empty($product->productImages))
                                                <div class="mb-3" id="ajaxProductImageDiv">
                                                    @foreach($product->productImages as $productImage)
                                                    <div style="padding: 4px;" id="productImageDiv{{ $productImage->productImageId }}">
                                                        <div class="product-img-with-delete">
                                                            <img src="{{ url($productImage->image) }}" height="100px" width="100px" alt="">
                                                            <div class="hover-icon">
                                                                <a title="delete" class="btn btn-danger btn-xs" style="margin-top: 40px" onclick="deleteProductImage({{ $productImage->productImageId }})">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('product.show') }}">Cancel</a></button>
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div id="variationCreateForm">
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
                                                    <input class="form-control" id="sQuantityVar" name="sQuantityVar" type="number" min="1" placeholder="Stock Quantity"  required>
                                                    <span class="ajaxErrorSpan text-danger" id="sQuantityVarError"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="regularPrice">Regular Price</label>
                                                    <input class="form-control" id="regularPrice" name="regularPrice" type="number"  step="0.01" placeholder="Regular Price" value="{{ old('regularPrice') }}" required>
                                                    <span class="ajaxErrorSpan text-danger" id="regularPriceError"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="discountType">Discount Type</label>
                                                    <select class="form-control" name="discountType" id="discountType">
                                                        <option value="">Select Discount Type</option>
                                                        <option value="flat">Flat</option>
                                                        <option value="percent">Percent</option>
                                                    </select>
                                                    <span class="ajaxErrorSpan text-danger" id="discountTypeError"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="discount">Discount</label>
                                                    <input class="form-control" id="discount" name="discount" type="text"  step="0.01" placeholder="Discount" value="{{ old('discount') }}">
                                                    <span class="ajaxErrorSpan text-danger" id="discountError"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="salePrice">Sale Price</label>
                                                    <input class="form-control" id="salePrice" name="salePrice" type="text"  step="0.01" placeholder="Sale Price" value="{{ old('salePrice') }}">
                                                    <span class="ajaxErrorSpan text-danger" id="salePriceError"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="stockAlert">Stock Alert</label>
                                                    <input class="form-control" id="stockAlert" name="stockAlert" type="text" min="1" placeholder="Stock Alert" value="{{ old('stockAlert') }}" required>
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
                            <div id="variationList"></div>                           
                               
                                <div id="variationEditForm"></div>                              
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer.js')
    <script>

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
        
        const loadFile = function(event) {
            var image = document.getElementById('output');
                image.src = URL.createObjectURL(event.target.files[0]);
            };
        let productImageId;
        $("#sub2").hide();
        $("#sub3").hide();
        $("#variationForm").hide();
        $("#variationCreateForm").hide();

        $(document).ready(function (){
            // CKEDITOR.replace('shortDescription');
            CKEDITOR.replace('productDetails');
            CKEDITOR.replace('variationDetails');
            CKEDITOR.replace('variationShortDes');

            @if($product->type === "variation")
            let productId = {{ $product->productId }}
            $("#variationForm").show();
            $("#singleQuantity").hide();
            $("#variationCreateForm").hide();
            $.ajax({
                type: 'POST',
                url: "{{ route('product.variationListShow') }}",
                data: {_token: "{{ csrf_token()}}", 'productId': productId},
                success: function (data) {
                    $("#variationList").html(data);
                }
            });
            @endif
        })

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

         // Parent Category Change
         $(".parentCategory").change(function () {
            $("#sub3").hide();
            $("#sub2").hide();
            var categoryId = this.value;
            $.ajax({
                type: 'POST',
                url: "{{ route('product.find.subCategory') }}",
                data: {'categoryId': categoryId, _token: "{{ csrf_token()}}"},
                success: function (data) {
                    var length = data.subcategories.length;
                    if (length > 0) {
                        $("#sub2").show();
                        console.log(length);
                        $("#subCat").empty();
                        $("#subCat").append('<option value="" selected>Select subCategory</option>')
                        $.each(data.subcategories, function (index, item) {
                            console.log(index, item);
                            $("#subCat").append("<option value= " + item.categoryId + ">" + item.categoryName + "</option>")
                        });
                    } else {
                        $("#sub2").hide();
                        $("#productTypeMain").show();
                    }
                }
            });
        });

        // Sub Category Change
        $(".subCategory").change(function () {
            $("#sub3").hide();
            var categoryId = this.value;
            $.ajax({
                type: 'POST',
                url: "{{ route('product.find.subCategory') }}",
                data: {'categoryId': categoryId, _token: "{{ csrf_token()}}"},
                success: function (data) {
                    var length = data.subcategories.length;
                    if (length > 0) {
                        $("#sub3").show();
                        console.log(length);
                        $("#subSubCat").empty();
                        $("#subSubCat").append('<option value="" selected>Select subSubCategory</option>')
                        $.each(data.subcategories, function (index, item) {
                            console.log(index, item);
                            $("#subSubCat").append("<option value= " + item.categoryId + ">" + item.categoryName + "</option>")
                        });
                    } else {
                        $("#sub3").hide();
                    }
                }
            });
        });

        //Product Type Select
        $("#productType").change(function () {
            var productType = this.value;
            if (productType == 'variation') {
                $("#variationForm").show();
                var $container = $("html,body");
                var $scrollTo = $('#variationForm');
                $container.animate({
                    scrollTop: $scrollTo.offset().top - $container.offset().top + $container.scrollTop(),
                    scrollLeft: 0
                }, 2000);

            } else {
                $("#variationForm").hide();
                $("#submitBtn1").show();
            }
        });

        function deleteProductImage (id) {
            productImageId = id;
            $.ajax({
                type: 'POST',
                url: "{{ route('product.productImage.delete') }}",
                data: {'productImageId': productImageId, _token: "{{ csrf_token()}}"},
                success: function (data) {
                    toastr.success('Image Deleted Successfully');
                    $('#productImageDiv' + id).remove();
                }
            });
        }

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
