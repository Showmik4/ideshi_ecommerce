
<div class="row" id="product-container">
  @foreach ($products as $product)
  <div class="col-sm-6 col-md-4 mb-3">
      <div class="product-item p-2">
        <a href="{{ route('product_details', $product->productId) }}">
          <img src="{{ url('admin/'. $product->featureImage) }}" alt="product" class="img-fluid w-100">
          <div class="p-3">
            <h5 class="mb-0">{{$product->productName}}</h5>
            <p class="text-ash">Men's pant</p>
            <div class="d-flex flex-wrap gap-2 pt-2 pb-2 border-bottom">
              @if(!empty($product->sku->first()->salePrice))
              <div>
                <p class="text-ash text-decoration-line-through">${{ @$product->sku->first()->regularPrice }}</p>
              </div>
              @endif

              @if(empty($product->sku->first()->salePrice))
              <div>
                <p class="text-red font-600">${{ @$product->sku->first()->regularPrice}}</p>
              </div>
              @else
              <div>
                <p class="text-red font-600">${{ @$product->sku->first()->salePrice}}</p>
              </div>
              @endif
            </div>
            <div class="d-flex flex-wrap gap-3 pt-3">
              <a href="javascript:void(0)" onclick="addToCart({{$product->sku ? $product->sku->first()->skuId : 0}})">
              <div>
                <button class="btn btn-red px-3 py-1"><i class="fas fa-shopping-bag me-2"></i> Quick Add</button>
              </div>
              </a>
              <a href="javascript:void(0)" onclick="addToWishlist({{ $product->sku ? $product->sku->first()->skuId : 0 }})">
              <div>
                <button class="btn px-3 py-1"><i class="far fa-heart"></i></button>
              </div>
              </a>
            </div>
          </div>
        </a>
      </div>
    </div>          
  @endforeach     
  {{-- <nav aria-label="...">
    <ul class="pagination justify-content-center mt-2">
        <li class="page-item {{ ($products->currentPage() == 1) ? 'disabled' : '' }}">
            <a href="{{ $products->previousPageUrl() }}" class="page-link" tabindex="-1" aria-disabled="true">Previous</a>
        </li>
        @for ($i = 1; $i <= $products->lastPage(); $i++)
            <li class="page-item {{ ($products->currentPage() == $i) ? 'active' : '' }}">
                <a href="{{ $products->url($i) }}" class="page-link">{{ $i }}</a>
            </li>
        @endfor
        <li class="page-item {{ ($products->currentPage() == $products->lastPage()) ? 'disabled' : '' }}">
            <a href="{{ $products->nextPageUrl() }}" class="page-link">Next</a>
        </li>
    </ul>
  </nav> --}}

  </div>
