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
<h4>Variation List
    @if(empty($product_variations))
        <span id="addbtn"></span>
        <a title="add variation" id="addNewVariation" class="btn btn-blue btn-sm" style="color: #ffffff"><i class="ft-plus-square"></i></a>
    @endif
</h4>
<br>

<div class="row">
    <div class="col-md-12">
        <div class="text-end mb-3">
            <a href="javascript:void(0)" class="btn btn-md btn-info" onclick="addNewVariation()"><i class="fa fa-plus"></i>Add Variation</a>
        </div>
        <div class="table-responsive">
            <table id="productVariationTempTable" class="table table-striped">
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
                @if(!empty($productVariationTemps))
                    @foreach($productVariationTemps as $productVariationTemp)
                        <tr>
                            <td>{{ @$productVariationTemp->barcode }}</td>
                            <td>{{ @$productVariationTemp->variationType1 }}</td>
                            <td>
                                @if(isset($productVariationTemp->variationType1))
                                    @if($productVariationTemp->variationType1 === 'color' || $productVariationTemp->variationType1 === 'Color')
                                        <label class="btn" style="background-color: {{ @$productVariationTemp->variationValue1 }}"></label>{{ @$productVariationTemp->variationValue1 }}
                                    @else
                                        {{ @$productVariationTemp->variationValue1 }}
                                    @endif
                                @endif
                            </td>
                            <td>{{ @$productVariationTemp->variationType2 }}</td>
                            <td>
                                @if(isset($productVariationTemp->variationType2))
                                    @if($productVariationTemp->variationType2 === 'color' || $productVariationTemp->variationType2 === 'Color')
                                        <label class="btn" style="background-color: {{ @$productVariationTemp->variationValue2 }}">{{ @$productVariationTemp->variationValue2 }}</label>
                                    @else
                                        {{ @$productVariationTemp->variationValue2 }}
                                    @endif
                                @endif
                            </td>
                            <td>{{ @$productVariationTemp->regularPrice }}</td>
                            <td>{{ @$productVariationTemp->discount }}</td>
                            <td>{{ ucfirst(@$productVariationTemp->discountType) }}</td>
                            <td>{{ @$productVariationTemp->salePrice }}</td>
                            <td>{{ @$productVariationTemp->stockAlert }}</td>
                            <td>
                                @if(!empty($productVariationTemp->variationImage))
                                    @foreach (json_decode($productVariationTemp->variationImage) as $image)
                                        <img src="{{ url($image) }}" height="50px" width="50px" alt="Variation Image">
                                    @endforeach
                                @endif
                            </td>
{{--                            <td>--}}
{{--                                <a title="delete" class="btn btn-danger btn-xs" data-panel-id="{{ $productVariationTemp->productVariationTempId }}" onclick="deleteProductVariationTemp(this)"><i class="fa fa-trash"></i></a>--}}
{{--                            </td>--}}
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function addNewVariation() {
        $('#variationForm').show()
    }

    
</script>


