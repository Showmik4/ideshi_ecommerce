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
    {{-- <td><input type="text" data-id="{{$row->id}}" id="discount{{$row->id}}" onfocusout="discountPrice(this)" class="form-control"
        name="discount" value="{{$row->attributes->discount}}"></td> --}}
    <td>
        0
        {{-- <input type="text" data-id="{{$row->id}}" id="discount{{$row->id}}" onfocusout="discountPrice(this)" class="form-control"
        name="discount" value="0" readonly> --}}
    </td>
        {{-- name="discount" value="@json(floatval(array_slice($row->conditions,-1)[0]->parsedRawValue ?? 0)  * floatval($row->quantity) ?? 0)"></td> --}}
    <td>{{$row->quantity*$row->price - $row->attributes->discount??'0'}}</td>
    <td style="text-align: center">
        <button type="button" onclick="removeItem({{$row->id}})" class="btn btn-danger btn-sm"><i id="delIcon{{$row->id}}" class="fa fa-trash"></i><span id="delSpinner{{$row->id}}" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none"></span></button>
    </td>
    {{-- <td>@json(array_slice($row->conditions,-1)[0]->parsedRawValue ?? 0)</td> --}}
</tr>

@endforeach