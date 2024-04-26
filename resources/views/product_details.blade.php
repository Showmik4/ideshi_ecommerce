@extends('layouts.main')
@section('title'){{ 'Product Details' }}@endsection
@section('header.css')
    <style>

    </style>
@endsection
@section('main.content')
<main>
    <!--====== product details start ======-->
    <section class="product-details-area pt-3 pt-lg-4">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 mb-3 mb-lg-0">
            <div class="slider-box me-xl-4">
              <div class="row align-items-center">
                <div class="col-md-3 d-none d-md-block">
                  @foreach ($product_details->productImages as $index => $productImage)
                    @if(isset($productImage))
                      <div class="text-end mb-3">
                        <a href="#" class="nav-img" data-index="{{ $index }}">
                          <img src="{{ url('admin/'. $productImage->image) }}" alt="Product Image {{ $index + 1 }}">
                        </a>
                      </div> 
                    @endif
                  @endforeach
                </div>
                <div class="col-md-9">
                  <div class="owl-carousel owl-theme main-img" id="product-image-slider">
                    @foreach ($product_details->productImages as $productImage)
                      @if(isset($productImage))
                        <div class="item" data-hash="{{ url('admin/'. $productImage->image) }}">
                          <img src="{{ url('admin/'. $productImage->image) }}" alt="Product Image">
                        </div>                    
                      @endif
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>        
        <div class="col-lg-5">
            <ul class="d-flex gap-2 mb-2">
              <li>
                <a href="{{route('index')}}" class="text-ash">Home</a>
              </li>
              <li>
                <a href="#" class="text-ash"><i class="fa-solid fa-angle-right"></i></a>
              </li>
              <li>
                <a href="javascript:void(0)" onclick="addToWishlist({{ $product_details->sku ? $product_details->sku->first()->skuId : 0 }})" class="text-ash">Wishlist</a>
              </li>
            </ul>
            <h3 class="mb-4">
             {{$product_details->productName}}
            </h3>
            <div class="size-select-box" @if(count($variations) === 0 || count($variations[0]->variationRelation) === 0) style="display: none;" @endif>
              <p class="font-700 mb-2">Select Size</p>
              <form>
                @foreach ($variations as $variation)
                    <div class="select-btn">
                        @foreach ($variation->variationRelation as $index => $skuVariation)
                            @if ($skuVariation->variation && $skuVariation->variation->variationType=='Size')
                                <input type="radio" id="size{{ $variation->id }}" name="size{{ $variation->id }}" value="{{ $skuVariation->variation->variationValue }}" @if($index === 0) checked @endif/>
                                <label class="btn" for="size{{$variation->id}}">{{ $skuVariation->variation->variationValue }}</label>
                            @endif
                        @endforeach
                    </div>
                @endforeach
             </form>             
            </div>  
       
            <div class="color-select-box" @if(count($variations) === 0 || count($variations[0]->variationRelation) === 0) style="display: none;" @endif>
              <p class="font-700 mb-1">Colors Available</p>
              <form>
                @foreach ($variations as $variation) 
                @foreach ($variation->variationRelation as $skuVariation) 
                <label class="color-option">
                    {{-- <input type="radio" name="color" value="red"> --}}
                    @if ($skuVariation->variation && $skuVariation->variation->variationType=='Color')
                    <input type="radio" name="color" value="{{ $skuVariation->variation->variationValue }}">
                    <span class="color-indicator" style="background-color:{{$skuVariation->variation->variationValue}}"></span>
                    @endif
                </label>
                @endforeach
                @endforeach         
              </form>
            </div>

            <div class="d-flex flex-wrap gap-2 mt-4">
              <a href="javascript:void(0)" onclick="addToCart({{$product_details->sku ? $product_details->sku->first()->skuId : 0}})">
              <div>
                <button class="btn btn-red px-3 py-2"><i class="fas fa-shopping-bag me-2"></i> Add to Cart</button>
              </div>
              </a>
              <div>
                <input class="form-control form-control-sm px-1 py-2" type="number" min="1" id="quantity" value="1">
              </div>
              @if(empty($product_details->sku->first()->salePrice))
              <div>
              <div class="btn bg-white text-dark px-3 py-2">${{$product_details->sku->first()->regularPrice}}</div>
              </div>
              @else
              <div>
                <div class="btn bg-white text-dark px-3 py-2">${{$product_details->sku->first()->salePrice}}</div>
              </div>
              @endif
              </div>
            <hr class="mt-4">
            <div class="row order-features pt-3">
              <div class="col-md-6 mb-3">
                <div class="d-flex align-items-center gap-2">
                  <div>
                    <div class="icon-box">
                      <img src="{{asset('public/assets/images/product-details/of-1.svg')}}" alt="icon">
                    </div>
                  </div>
                  <div>
                    <h6>Secure Payment</h6>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex align-items-center gap-2">
                  <div>
                    <div class="icon-box">
                      <img src="{{asset('public/assets/images/product-details/of-2.svg')}}" alt="icon">
                    </div>
                  </div>
                  <div>
                    <h6>Size & Fit</h6>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex align-items-center gap-2">
                  <div>
                    <div class="icon-box">
                      <img src="{{asset('public/assets/images/product-details/of-3.svg')}}" alt="icon">
                    </div>
                  </div>
                  <div>
                    <h6>Free shipping</h6>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex align-items-center gap-2">
                  <div>
                    <div class="icon-box">
                      <img src="{{asset('public/assets/images/product-details/of-4.svg')}}" alt="icon">
                    </div>
                  </div>
                  <div>
                    <h6>Free Shipping & Returns</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>         
        </div>
      </div>
    </section>
    <!--====== product details end ======-->

    <!--====== product description start ======-->
    <section class="product-description-area pt-80">
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <h4 class="section-heading mb-4 ps-4">Product Description</h4>
            <p class="text-ash mb-3">
              {{@$product_details->productDetails->shortDescription}}
            </p>
            <div class="item-box">
              <table class="table">
                <tr>
                  <td>
                    <p class="text-ash">Fabric</p>
                    <p class="font-500">{{@$product_details->productDetails->fabricDetails}}</p>
                  </td>
                  <td>
                    <p class="text-ash">Pattern</p>
                    <p class="font-500">{{@$product_details->productDetails->pattern}}</p>
                  </td>
                  <td>
                    <p class="text-ash">Fit</p>
                    <p class="font-500">{{@$product_details->productDetails->fit}}</p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p class="text-ash">Nace</p>
                    <p class="font-500">{{@$product_details->productDetails->nace}}</p>
                  </td>
                  <td>
                    <p class="text-ash">Sleeve</p>
                    <p class="font-500">{{@$product_details->productDetails->sleeve}}</p>
                  </td>
                  <td>
                    <p class="text-ash">Style</p>
                    <p class="font-500">{{@$product_details->productDetails->style}}</p>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-lg-5">
            <iframe width="100%" height="300" src="https://www.youtube.com/embed/uFgcSjVRJhE" title="FASHION CINEMATIC VIDEO | JITESH THAKUR | HOUSE OF CREATION | JAIPUR" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </section>
    <!--====== product description end ======-->

    <!--====== similar products start ======-->
    <section class="similar-product-area py-4 py-lg-5">
      <div class="container">
        <h4 class="section-heading mb-4 ps-4">Similar Products</h4>
        <div class="product-slider owl-carousel owl-theme">
          @foreach ($similar_products as $similar_product)             
         
          <div class="product-item p-2">
            <a href="#">
              <img src="{{ url('admin/'.$similar_product->featureImage)}}" alt="product" class="img-fluid w-100">
              <div class="p-3">
                <h5 class="mb-0">{{$similar_product->productName}}</h5>
                <p class="text-ash">Men's pant</p>
                <div class="d-flex flex-wrap gap-2 pt-2 pb-2 border-bottom">
                  @if(!empty($product_details->sku->first()->salePrice))
                  <div>
                    <p class="text-ash text-decoration-line-through">{{ @$similar_product->sku->first()->regularPrice}}</p>
                  </div>
                  @endif
                  @if(empty($product_details->sku->first()->salePrice))
                  <div>
                    <p class="text-red font-600">${{ @$similar_product->sku->first()->regularPrice}}</p>
                  </div>
                  @else
                  <div>
                    <p class="text-red font-600">${{ @$similar_product->sku->first()->salePrice}}</p>
                  </div>
                  @endif
                </div>
                <div class="d-flex flex-wrap gap-3 pt-3">
                  <a href="javascript:void(0)" onclick="addToCart({{$similar_product->sku ? $similar_product->sku->first()->skuId : 0}})">
                  <div>
                    <button class="btn btn-red px-3 py-1"><i class="fas fa-shopping-bag me-2"></i>Quick Add</button>
                  </div>
                  </a>
                  <a href="javascript:void(0)" onclick="addToWishlist({{ $similar_product->sku ? $similar_product->sku->first()->skuId : 0 }})">
                  <div>
                    <button class="btn px-3 py-1"><i class="far fa-heart"></i></button>
                  </div>
                  </a>
                </div>
              </div>
            </a>
          </div>
          @endforeach        
        </div>
      </div>
    </section>
    <!--====== similar products end ======-->

	</main>
@endsection
@section('footer.js')
    <script>    
   $('.nav-img').on('click', function(event) {
    event.preventDefault();
    var index = $(this).data('index');
    $('#product-image-slider').trigger('to.owl.carousel', index);
  });

  // Initialize Owl Carousel
  $('#product-image-slider').owlCarousel({
    items: 1,
    loop: true,
    margin: 10,
    nav: false,
    dots: false
  });


  </script>
  
@endsection