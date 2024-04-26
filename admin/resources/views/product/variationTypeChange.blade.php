    {{--  <label>Variation Value</label>
   
    <select name="variationValue1" id="variationValue1" class="variationValue1 form-control">
        <option value="" disabled selected>Select Value</option>
        @foreach($variations as $variation)
            <option style="background: {{ $variation->variationValue }}" value="{{ $variation->variationId }}"> @if($variation->variationType == "Color"){{ array_key_exists("$variation->variationValue", unserialize(COLOR_CODE)) ? unserialize(COLOR_CODE)["$variation->variationValue"] : unserialize(COLOR_CODE)["NOT"]  }}@else {{$variation->variationValue}} @endif</option>
        @endforeach
    </select>
    @if(count($variations) > 0)
    <input type="hidden" id="variationRelationId1" value="{{ $variationRelationId1 }}" name="variationRelationId1">
    @endif  --}}

    <label>Variation Value</label>
<select name="variationValue1" id="variationValue1" class="variationValue1 form-control">
    <option value="" disabled selected>Select Value</option>
    @foreach($variations as $variation)
    <option style="background: {{ $variation->variationValue }}" value="{{ $variation->variationId }}"> @if($variation->variationType == "Color"){{ array_key_exists("$variation->variationValue", unserialize(COLOR_CODE)) ? unserialize(COLOR_CODE)["$variation->variationValue"] : unserialize(COLOR_CODE)["NOT"]  }}@else {{$variation->variationValue}} @endif</option>

        {{--  <option style="background: {{ $variation->variationValue }}" value="{{ $variation->variationId }}">{{ $variation->variationValue }}</option>  --}}
    @endforeach
</select>
<div style="color: red" class="mb-2" id="variationValue1Error"></div>
<div style="color: red" class="mb-2" id="variationValue1EditError"></div>
@if(count($variations) > 0)
    <input type="hidden" id="variationRelationId1" value="{{ $variationRelationId1 }}" name="variationRelationId1">
@endif




