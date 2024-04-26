<span class="editTitle"><h4  class="card-title" id="basic-layout-form">Variation Edit</h4></span>
<br>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif 
<form id="variationUpdate" enctype="multipart/form-data">
    @csrf
    <div class="form-body">
        <div class="row">
            @foreach($variationType as $key => $vd)

            <div class="col-md-4 col-lg-4 col-xl-2">
                <div class="form-group">
                    <label>Variation Type</label>
                    <select name="variationType{{$key+1}}" id="variation{{$key+1}}" class="variationType{{$key+1}} form-control">
                        <option value="">Select Type</option>
                        @foreach($variations->unique('variationType') as $variationTyped)
                        <option  @if($vd == ($variationTyped->variationType)) selected @endif value="{{$variationTyped->variationType}}" >{{$variationTyped->variationType}}</option>
                        @endforeach
                        {{-- <option @if(count($variationType) > 0 && $variationType[0] == "Color") selected @endif value="Color">Color</option>
                        <option @if(count($variationType) > 0 && $variationType[0] == "Size") selected @endif value="Size">Size</option>
                        <option @if(count($variationType) > 0 && $variationType[0] == "Other") selected @endif value="Other">Other</option> --}}
                    </select>
                    <input type="hidden" name="skuId" value="{{ $sku->skuId }}">
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xl-2" id="variationChange{{$key+1}}">
                <div class="form-group">
                    <label>Variation Value</label>
                    <select name="variationValue{{$key+1}}" id="variationValue{{$key+1}}" class="variationValue{{$key+1}} form-control">
                        <option value= "{{ count($variationValue) > 0 ?  $variationId[$key] : ''  }}" selected>{{ count($variationValue) > 0 ?  $variationValue[$key] : 'Select Value' }}</option>
                    </select>
                </div>
            </div>
            {{--  <div class="col-md-4 col-lg-4 col-xl-2">
                <div class="form-group">
                    <label>Variation Type</label>
                    <select name="variationType1" id="variation1" class="variationType1 form-control">
                            <option value="">Select Type</option>
                            <option @if(count($variationType) > 0 && $variationType[0] == "Color") selected @endif value="Color">Color</option>
                            <option @if(count($variationType) > 0 && $variationType[0] == "Size") selected @endif value="Size">Size</option>
                            <option @if(count($variationType) > 0 && $variationType[0] == "Other") selected @endif value="Other">Other</option>
                    </select>
                    <input type="hidden" name="skuId" value="{{ $sku->skuId }}">
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xl-2" id="variationChange1">
                <div class="form-group">
                    <label>Variation Value</label>
                    <select name="variationValue1" id="variationValue1" class="variationValue1 form-control">
                            <option value= "{{ count($variationValue) > 0 ?  $variationId[0] : ''  }}" selected>{{ count($variationValue) > 0 ?  $variationValue[0] : 'Select Value' }}</option>
                    </select>
                </div>
            </div>  --}}
            @endforeach
            <!--For Multiple Variation-->
            {{--  @if(count($variationType) > 1)
            <div class="col-md-4 col-lg-4 col-xl-2">
                <div class="form-group">
                    <label>Variation Type</label>
                    <select name="variationType2" id="variation2" class="variationType2 form-control">
                            <option value="">Select Type</option>
                            <option @if(count($variationType) > 1 && $variationType[1] == "Color") selected @endif value="Color">Color</option>
                            <option @if(count($variationType) > 1 && $variationType[1] == "Size") selected @endif value="Size">Size</option>
                            <option @if(count($variationType) > 1 && $variationType[1] == "Other") selected @endif value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xl-2" id="variationChange2">
                <div class="form-group">
                    <label>Variation Value</label>
                    <select name="variationValue2" id="variationValue2" class="variationValue2 form-control">
                            <option value= "{{ count($variationValue) > 1 ?  $variationId[1] : ''  }}" selected>{{ count($variationValue) > 1 ?  $variationValue[1] : 'Select Value' }}</option>
                    </select>
                </div>
            </div>
            @endif  --}}
            <!--End-->

            <div class="col-md-4 col-lg-4 col-xl-2">
                <div class="form-group">
                    <label>Regular Price</label>
                    <input type="number" class="regularPrice form-control" name="regularPrice" value="{{ $sku->regularPrice ?? " " }}" id="salePrice" placeholder="sale price">
                </div>
            </div>

            <div class="col-md-4 col-lg-4 col-xl-2">
                <div class="form-group">
                    <label>Sale Price</label>
                    <input type="number" class="salePrice form-control" name="salePrice" value="{{ $sku->salePrice }}" id="salePrice" placeholder="sale price">
                </div>
            </div>
            <div id="varQuantity" class="col-md-4 col-lg-4 col-xl-3">
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control" name="variationQuantity" id="variationQuantity" value="{{ @$sku->stockRecord->first()->stock}}" min="0" placeholder="Enter Quantity">
                </div>
            </div>
            
            <div class="col-md-4 col-lg-4 col-xl-2">
                <div class="form-group">
                    <label>Stock Alert</label>
                    <input type="number" class="stockAlert form-control" id="stockAlert" value="{{ $sku->stockAlert }}" name="stockAlert" placeholder="stock alert">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-lg-3 col-xl-2">
                <div data-repeater-list="repeater-group">
                    <label>Barcode</label>
                    <div class="input-group mb-1" data-repeater-item>
                        <input type="number" value="{{ $sku->barcode }}" name="barcode" id="barcodeVariationEdit" class="form-control" id="barcode">
                        <span class="input-group-append" id="button-addon2">
                            <a onclick="barcodeGenerateVariationEdit()" style="color: white; font-weight: bold; padding-top: 14px; padding: 14px 4px 10px;" class="btn btn-sm btn-danger" data-repeater-delete>
                              generate
                            </a>
                        </span>
                        <div class="divAjaxError" style="color: red" class="mb-2" id="barcodeEditError"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xl-2">
                <div class="form-group">
                    <label>Variation Image</label>
                    <input type="file" id="varImage" class="varImage form-control" name="variationImage[]" multiple>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xl-3">
                <div class="form-group">
                    <br>
                    <button style=" border: 1px solid #cacfe7; margin-top: 7px;  padding: 10px 5px;" class="btn w-100" type="button" data-toggle="collapse" data-target="#varDetails" aria-expanded="false" aria-controls="collapseExample">
                        Variation Details
                    </button>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xl-3">
                <div class="form-group">
                    <br>
                    <button style=" border: 1px solid #cacfe7; margin-top: 7px;  padding: 10px 5px;" class="btn w-100" type="button" data-toggle="collapse" data-target="#variationshort" aria-expanded="false" aria-controls="collapseExample">
                        Variation Short des
                    </button>
                </div>
            </div>
            <div id="varDetails" class="collapse row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Variation Details</label><span style="color: red;margin-left: 5px;font-weight: bold;">*</span>
                        <textarea class="form-control" name="variationDetails" id="variationDetailsedit">{{ $sku->variationDetails ? $sku->variationDetails->description : ''  }}</textarea>
                    </div>
                </div>
            </div>
            <div id="variationshort" class="collapse row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Variation Short Description</label><span style="color: red;margin-left: 5px;font-weight: bold;">*</span>
                        <textarea class="form-control " name="variationShortDes" id="variationShortDesedit">{{ $sku->variationDetails ? $sku->variationDetails->fabricDetails : ''  }}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xl-2">
                <button  type="submit" style="text-decoration: none; color: #ffffff; line-height: 1.5" class="mt-2 form-control btn btn-info btn-sm">
                    <i class="la la-check"></i> Update</button>
            </div>
        </div>
        </div>

</form>

<script>
    $(document).ready(function () {
        CKEDITOR.replace('variationDetailsedit');
        CKEDITOR.replace('variationShortDesedit');

    });

    // 1st Variation Type Change
    $(".variationType1").change(function(){
        var variationType = this.value;
        var variationRelationId1 = @if(count($variationRelation) > 0){{ $variationRelation[0] }} @else '' @endif;
        $.ajax({
            type: "POST",
            url: "{{route('product.variationTypeChange')}}",
            data: {_token: "{{ csrf_token() }}", 'variationType': variationType, 'variationRelationId1': variationRelationId1},
            success: function (data){
                console.log(data);
                $("#variationChange1").html(data)
            }
        });
    });


    // 2nd Variation Type Change
    $(".variationType2").change(function(){
        var variationType = this.value;
        var variationRelationId2 = @if(count($variationRelation) > 1){{ $variationRelation[1] }} @else '' @endif;
        $.ajax({
            type: "POST",
            url: "{{route('product.variationTypeChange2')}}",
            data: {_token: "{{ csrf_token() }}", 'variationType': variationType, 'variationRelationId2': variationRelationId2},
            success: function (data){
                console.log(data);
                $("#variationChange2").html(data)
            }
        });
    });


    // Variation Update
    $( "#variationUpdate" ).on( "submit", function(e) {
        e.preventDefault();
        for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
        }
        $.ajax({
            type: "POST",
            url: "{{route('product.variation.update')}}",
            data:new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                console.log('sdf');
                console.log(data);
                $("#variationList").html(data.html);
                $("#variationUpdate").hide();
                $(".editTitle").hide();

                $('#variationType1EditError').empty();
                $('#variationValue1EditError').empty();
                $('#variationType2EditError').empty();
                $('#variationValue2EditError').empty();
                $('#salePriceEditError').empty();
                $('#barcodeEditError').empty();
                $('#variationValue1Edit').empty();
                $('#variationValue2Edit').empty();
            },
            error: function(response) {
                $('#variationType1EditError').empty().text(response.responseJSON.errors.variationType1);
                $('#variationValue1EditError').empty().text(response.responseJSON.errors.variationValue1);
                $('#variationType2EditError').empty().text(response.responseJSON.errors.variationType2);
                $('#variationValue2EditError').empty().text(response.responseJSON.errors.variationValue2);
                $('#salePriceEditError').empty().text(response.responseJSON.errors.salePrice);
                $('#barcodeEditError').empty().text(response.responseJSON.errors.barcode);
            }
        });
        e.preventDefault();
    });

    // Barcode Generate
    function barcodeGenerateVariationEdit(){
        var rnd = Math.floor(Math.random() * 1000000000);
        document.getElementById('barcodeVariationEdit').value = rnd;
    }


</script>
@section('footer.js')

@endsection