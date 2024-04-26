
        {{--  <label>Variation Value</label>
        <select name="variationValue2" id="variationValue2" class="variationValue2 form-control">
            <option value="" disabled selected>Select Value</option>
            @foreach($variations as $variation)
            <option style="background: {{ $variation->variationValue }}" value="{{ $variation->variationId }}"> @if($variation->variationType == "Color"){{ array_key_exists("$variation->variationValue", unserialize(COLOR_CODE)) ? unserialize(COLOR_CODE)["$variation->variationValue"] : unserialize(COLOR_CODE)["NOT"]  }}@else {{$variation->variationValue}} @endif</option>
            
            @endforeach
        </select>
        @if(count($variations) > 0)
        <input type="hidden" id="variationRelationId2" value="{{ $variationRelationId2 }}" name="variationRelationId2">
        @endif  --}}

        

        <label>Variation Value</label>
        <select name="variationValue2" id="variationValue2" class="variationValue2 form-control">
            <option value="" disabled selected>Select Value</option>
            @foreach($variations as $variation)
            <option style="background: {{ $variation->variationValue }}" value="{{ $variation->variationId }}"> @if($variation->variationType == "Color"){{ array_key_exists("$variation->variationValue", unserialize(COLOR_CODE)) ? unserialize(COLOR_CODE)["$variation->variationValue"] : unserialize(COLOR_CODE)["NOT"]  }}@else {{$variation->variationValue}} @endif</option>

                {{--  <option style="background: {{ $variation->variationValue }}"  value="{{ $variation->variationId }}">{{ $variation->variationValue }}</option>  --}}
            @endforeach
        </select>
        <div style="color: red" class="mb-2" id="variationValue2Error"></div>
        <div style="color: red" class="mb-2" id="variationValue2EditError"></div>
        @if(count($variations) > 0)
            <input type="hidden" id="variationRelationId2" value="{{ $variationRelationId2 }}" name="variationRelationId2">
        @endif








        {{--  <option style="background: {{ $variation->variationValue }}"  value="{{ $variation->variationId }}">{{ $variation->variationValue }}</option>  --}}




