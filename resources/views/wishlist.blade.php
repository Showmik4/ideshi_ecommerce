@extends('layouts.main')
@section('title'){{ 'Wishlist' }}@endsection
@section('header.css')
    <style>

    </style>
@endsection
@section('main.content')

<main>
    <!--====== breadcumb area start ======-->
    <section class="breadcumb-area pb-2">
      <div class="container">
        <ul class="d-flex gap-2">
          <li>
            <a href="{{route('index')}}" class="text-ash">Home</a>
          </li>
          <li>
            <a href="#" class="text-ash"><i class="fa-solid fa-angle-right"></i></a>
          </li>
          <li>
            <a href="{{route('product.wishlist')}}" class="text-ash">Wishlist</a>
          </li>
        </ul>
      </div>
    </section>
    <!--====== breadcumb area end ======-->

    <!--====== cart table start ======-->
    <section class="cart-table mt-3">
      <div class="container">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>product details</th>
                <th>price</th>
                <th>quantity</th>
                <th>shipping</th>
                <th>subtotal</th>
                <th>action</th>
              </tr>
            </thead>

            @foreach ($wishlists as $wishlist)
            <tbody>
                <tr>
                  <td>
                    <div class="prod-detals d-flex gap-2 align-items-center">
                      <div>
                        <a href="product-details.html">
                            @if(isset($wishlist->sku->product->featureImage))
                          <img src="{{ url('admin/'. $wishlist->sku->product->featureImage) }}" alt="product" class="img-fluid">
                            @endif
                        </a>
                      </div>
                      <div>
                        <a href="product-details.html">
                          <h6 class="mb-1">{{ $wishlist->sku->product->productName }}</h6>
                        </a>
                        @foreach ($wishlist->sku->variationRelation as $skuVariation)                        
                        @if ($skuVariation->variation && $skuVariation->variation->variationType == 'Color')
                        <p class="text-ash" style="background-color: {{ $skuVariation->variation->variationValue }}">Color:{{ $skuVariation->variation->variationValue }}</p>                       
                        @endif
                        @endforeach  
                        
                        @foreach($wishlist->sku->variationRelation as $skuVariation)
                        @if ($skuVariation->variation && $skuVariation->variation->variationType == 'Size')
                        <p class="text-ash">{{ $skuVariation->variation->variationValue }}</p>
                        @endif
                        @endforeach
                      </div>
                    </div>
                  </td>
                  <td class="price-colum">
                    @if(empty($wishlist->sku->first()->salePrice))
                        ${{ $wishlist->sku->regularPrice }}
                    @else
                        ${{ $wishlist->sku->salePrice }}
                    @endif
                  </td>
                  <td>
                    <div class="quantity">
                      <a href="#" class="quantity__minus"><span>-</span></a>
                      <input name="quantity" type="text" class="quantity__input" value="1" id="quantity" disabled>
                      {{-- <input class="form-control form-control-sm px-1 py-2" type="number" min="1" id="quantity" value="1"> --}}
                      <a href="#" class="quantity__plus"><span>+</span></a>
                    </div>
                  </td>
                 
                  <td class="text-ash">$5</td>
                 
                  <td class="price-colum">
                    @if(empty($wishlist->sku->first()->salePrice))
                        ${{ $wishlist->sku->regularPrice }}
                    @else
                        ${{ $wishlist->sku->salePrice }}
                    @endif
                  </td>        
                  <td>
                    <a href=" " onclick="deleteWishlist({{$wishlist->sku->skuId }})"><i class="fa-solid fa-trash-can delete-icon"></i></a>
                    <a href="javascript:void(0)" onclick="addToCart({{ $wishlist->sku->skuId }})">
                    <button class="btn btn-red ms-3 px-2 py-0">Add to Cart</button>
                    </a>
                  </td>
                </tr>  
              </tbody>
            @endforeach           
          </table>
        </div>
      </div>
    </section>
    <!--====== cart table end ======-->
	</main>
@endsection   
@section('footer.js')
<script>
   
        function deleteWishlist(x) {
            let skuId = x;
            if(!confirm("Remove This Product From Wishlist?"))
            {
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('deleteWishlist') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'skuId': skuId},
                success: function (data) {
                    toastr.success('Product removed from wishlist successfully!');
                    $("#wishlistTable").load(" #wishlistTable");
                },
            });
        }   
</script>

@endsection






