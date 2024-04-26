<style>
    /*variation list on edit*/

    .overlay {
        transition: 0.5s;
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        text-align: center;
        background: #00000030;
        padding-top: 14px;
    }
    .delete-icon {
        color: #fff;
        font-size: 18px;
    }
    .variation-img:hover .overlay {
        display: block !important;
        transition: 0.5s;
    }
</style>
<h4>Variation List</h4>
<br>

<div class="row">
    <div class="col-md-12">
        <div class="text-end mb-3">
            <a href="javascript:void(0)" class="btn btn-md btn-info" id="addNewVariation" onclick="addNewVariation()"><i class="fa fa-plus"></i>Add Variation</a>
        </div>
        <div class="table-responsive">
            <table id="productVariationTable" class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Barcode</th>
                    <th scope="col">Type 1</th>
                    <th scope="col">Value 1</th>
                    <th scope="col">Type 2</th>
                    <th scope="col">Value 2</th>
                    <th scope="col">Regular Price</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Discount Type</th>
                    <th scope="col">Sale Price</th>
                    <th scope="col">Stock Alert</th>
                    <th scope="col">Variation Images</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>

                <tbody>
                    {{-- @dd($products); --}}
                @if(!empty($products))
{{--                    @foreach($productVariationTemps as $productVariationTemp)--}}
{{--                        <tr>--}}
{{--                            <td>{{ @$productVariationTemp->barcode }}</td>--}}
{{--                            <td>{{ @$productVariationTemp->variationType1 }}</td>--}}
{{--                            <td>--}}
{{--                                @if(isset($productVariationTemp->variationType1))--}}
{{--                                    @if($productVariationTemp->variationType1 === 'color' || $productVariationTemp->variationType1 === 'Color')--}}
{{--                                        <label class="btn" style="background-color: {{ @$productVariationTemp->variationValue1 }}"></label>{{ @$productVariationTemp->variationValue1 }}--}}
{{--                                    @else--}}
{{--                                        {{ @$productVariationTemp->variationValue1 }}--}}
{{--                                    @endif--}}
{{--                                @endif--}}
{{--                            </td>--}}
{{--                            <td>{{ @$productVariationTemp->variationType2 }}</td>--}}
{{--                            <td>--}}
{{--                                @if(isset($productVariationTemp->variationType2))--}}
{{--                                    @if($productVariationTemp->variationType2 === 'color' || $productVariationTemp->variationType2 === 'Color')--}}
{{--                                        <label class="btn" style="background-color: {{ @$productVariationTemp->variationValue2 }}">{{ @$productVariationTemp->variationValue2 }}</label>--}}
{{--                                    @else--}}
{{--                                        {{ @$productVariationTemp->variationValue2 }}--}}
{{--                                    @endif--}}
{{--                                @endif--}}
{{--                            </td>--}}
{{--                            <td>{{ @$productVariationTemp->regularPrice }}</td>--}}
{{--                            <td>{{ @$productVariationTemp->discount }}</td>--}}
{{--                            <td>{{ ucfirst(@$productVariationTemp->discountType) }}</td>--}}
{{--                            <td>{{ @$productVariationTemp->salePrice }}</td>--}}
{{--                            <td>{{ @$productVariationTemp->stockAlert }}</td>--}}
{{--                            <td>--}}
{{--                                @if(!empty($productVariationTemp->variationImage))--}}
{{--                                    @foreach (json_decode($productVariationTemp->variationImage) as $image)--}}
{{--                                        <img src="{{ url($image) }}" height="50px" width="50px" alt="Variation Image">--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}
{{--                            </td>--}}
{{--                            --}}{{--                            <td>--}}
{{--                            --}}{{--                                <a title="delete" class="btn btn-danger btn-xs" data-panel-id="{{ $productVariationTemp->productVariationTempId }}" onclick="deleteProductVariationTemp(this)"><i class="fa fa-trash"></i></a>--}}
{{--                            --}}{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}

                    @foreach($products->sku as $key => $sku)
                        <tr>
                            <td>{{ $sku->barcode }}</td>
                            @foreach($sku->variationRelation as $variationRelation)
                            <td>
{{--                                @foreach($sku->variationRelation as $variationRelation)--}}
{{--                                    {{ $variationRelation->variationDetailsdata ? $variationRelation->variationDetailsdata->variationType : '' }}@if($key != 1),@endif--}}
{{--                                @endforeach--}}
                                {{ $variationRelation->variation->variationType }}
                            </td>
                            <td>
{{--                                @foreach($sku->variationRelation as $key => $variationRelation)--}}
{{--                                    @if(!empty($variationRelation->variationDetailsdata) && $variationRelation->variationDetailsdata->variationType == "Color")--}}
{{--                                        {{ array_key_exists($variationRelation->variationDetailsdata->variationValue, unserialize(COLOR_CODE)) ? unserialize(COLOR_CODE)[$variationRelation->variationDetailsdata->variationValue] : unserialize(COLOR_CODE)["NOT"]  }}--}}
{{--                                        @if($key != 1),@endif--}}
{{--                                    @endif--}}
{{--                                    @if(!empty($variationRelation->variationDetailsdata) && $variationRelation->variationDetailsdata->variationType != "Color")--}}
{{--                                        {{ $variationRelation->variationDetailsdata ? $variationRelation->variationDetailsdata->variationValue : '' }}@if($key != 1),@endif--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
                                {{ $variationRelation->variation->variationValue }}
                            </td>
                            @endforeach
                            <td>{{ $sku->regularPrice }}</td>
                            <td>{{ $sku->discount }}</td>
                            <td>{{ ucfirst($sku->discountType) }}</td>
                            <td>{{ $sku->salePrice }}</td>
                            <td>{{ $sku->stockAlert }}</td>
                            <td>
                                @foreach ($sku->variationImage as $image)
                                   <div class="variation-img position-relative d-inline-block">
                                        <img  class="variationImg" src="{{ url($image->image) }}" height="50px" width="50px" alt="">
                                       <div class="overlay d-none">
                                           <a href="{{ route('product.variation.image.delete', $image->productImageId) }}" class="icon" title="Variation Image">
                                               <i class="ft ft-trash-2 delete-icon"></i>
                                           </a>
                                       </div>
                                   </div>
                                @endforeach
                            </td>
                           <td>
                               <a title="edit" onclick="editVariation(this)" data-panel-sku="{{$sku->skuId}}" style="color: #fff" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                               <a title="status Change" onclick="variationStatus(this)" data-panel-sku="{{$sku->skuId}}" style="color: #fff" class="btn btn-primary btn-sm statusIcon{{$sku->skuId}}"><i class="fa fa-check-circle"></i></a>
                           </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

     //Edit Variation
     function editVariation(x) {
        $("#variationCreateForm").hide();
        $("#addbtn").hide();
        $("#addNewVariation").show();
        skuId = $(x).data('panel-sku');
        $.ajax({
            type: "POST",
            url: "{{route('product.variation.ajax.edit')}}",
            data: {_token: "{{ csrf_token() }}", 'skuId': skuId,},
            success: function (data) {
                console.log(data);
                $("#variationEditForm").html(data)
            }
        });
    }

    
      //Edit Variation Status
    function variationStatus(x){
        skuId = $(x).data('panel-sku');
        $.ajax({
           type: "POST",
           url: "{{route('product.variation.status')}}",
           data: {_token: "{{ csrf_token() }}", 'skuId': skuId,},
           success: function (data){
               console.log(data);
               if(data.status == 'active'){
                   $(".statusIcon" + data.skuId).empty().append('<i class="fa fa-check-circle"></i>')
                   $(".skuStatus" + data.skuId).empty().append(data.status)
               }
               if(data.status == 'inactive'){
                   $(".statusIcon" + data.skuId).empty().append('<i class="fa fa-lock"></i>')
                   $(".skuStatus" + data.skuId).empty().append(data.status)
               }

           }
        });
    }


    //Variation Add Form on Edit
    $("#addNewVariation").click(function (){
        $("#variationCreateForm").show();
        $(".editTitle").hide();
        $("#variationUpdate").hide();
        var el = $('<a title="cancel" class="btn btn-warning btn-sm" style="color: #ffffff"><i class="ft-minus-square"></i></a>');
        $("#addbtn").append(el);
        $("#addNewVariation").hide();
        el.click(function (){
            $("#addbtn").empty();
            $("#addNewVariation").show();
            $("#editTitle").hide();
            $("#variationCreateForm").hide();
        });
    });


    //Store New Variation on Edit
    $( "#variationAddNew" ).on( "submit", function(e) {
        e.preventDefault();
        for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
        }
        $.ajax({
            type: "POST",
            url: "{{route('product.variation.addNew')}}",
            data:new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#variationList").html(data.html);
                $("#variationAddNew").trigger('reset');
                $("#variationCreateForm").hide();
                

                $('#variationType1EditError').empty();
                $('#variationValue1EditError').empty();
                $('#variationType2EditError').empty();
                $('#variationValue2EditError').empty();
                $('#salePriceEditError').empty();
                $('#barcodeEditError').empty();
                $('#variationValue1Edit').empty();
                $('#variationValue2Edit').empty();
                //  reload the window in order to see the changes
                location.reload();
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


    // 1st Variation Type Change
    $(".variationType1").change(function(){
        var variationType = this.value;
        $.ajax({
            type: "POST",
            url: "{{route('product.variationTypeChange')}}",
            data: {_token: "{{ csrf_token() }}", 'variationType': variationType},
            success: function (data){
                console.log(data);
                $("#variationValues1").html(data)
            }
        });
    });


    // 2nd Variation Type Change
    $(".variationType2").change(function(){
        var variationType = this.value;
        $.ajax({
            type: "POST",
            url: "{{route('product.variationTypeChange2')}}",
            data: {_token: "{{ csrf_token() }}", 'variationType': variationType},
            success: function (data){
                console.log(data);
                $("#variationValues2").html(data)
            }
        });
    });

    function barcodeGenerateVariationAdd(){
        var rnd = Math.floor(Math.random() * 1000000000);
        document.getElementById('barcodeVariationAdd').value = rnd;
    }

  
</script>
