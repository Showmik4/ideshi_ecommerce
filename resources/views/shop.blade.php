@extends('layouts.main')
@section('title'){{ 'Shop' }}@endsection
@section('header.css')
@endsection
@section('main.content')

<main>
    <!--====== breadcumb area start ======-->
    <section class="breadcumb-area pb-3">
      <div class="container">
        <ul class="d-flex gap-2">
          <li>
            <a href="{{url('/')}}" class="text-ash">Home</a>
          </li>
          <li>
            <a href="#" class="text-ash"><i class="fa-solid fa-angle-right"></i></a>
          </li>
          <li>
            <a href="#" class="text-ash">Shop</a>
          </li>
        </ul>
      </div>
    </section>
    <!--====== breadcumb area end ======-->

    <!--====== shop page content start ======-->
    <section class="shop-page pb-4">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="filter-box d-none d-md-block px-3 py-4">
              <h5 class="text-red text-center mb-4">Filter Products</h5>

              <div class="filter-block mb-4">
                <h6>Price range</h6>
                <hr class="">
                <label>
                  <span id="amount-range1">$0</span> to <span id="amount-range2">Any</span>
                </label>
                <div class="mb-2"></div>
                <form action="#" class="mt--25">
                  <div id="slider-range" class="mb-4 responsive-slider-range">                      
                      <span tabindex="0" onclick="filterChange()" class="" style=""></span>
                      <span tabindex="100" onclick="filterChange()" class="" style=""></span>
                  </div>                 
                </form>
              </div>
              <div class="filter-block mb-4">
                <h6>Brand</h6>
                <hr class="mt-1 mb-2">

                @foreach ($brands as $brand)
                <div class="form-check d-flex gap-2 align-items-center">
                    <input class="form-check-input" type="checkbox" name="brands" value="{{$brand->brandId}}" id="brd{{$brand->brandId}}" onchange="filterChange()">
                    <label class="form-check-label mt-1" for="brd{{$brand->brandId}}">
                        {{$brand->brandName}}
                    </label>
                </div>
                @endforeach              
             
              </div>
              <div class="filter-block">
                <h6>Category</h6>
                <hr class="mt-1 mb-2">
                @foreach ($parentCategories as $category)
                <div class="form-check d-flex gap-2 align-items-center">
                  
                    <input class="form-check-input" type="checkbox" name="category"  value="{{$category->categoryId}}" id="{{$category->categoryId}}" onchange="filterChange()">
                    
                    <label class="form-check-label mt-1" for="ct1">
                      {{$category->categoryName}}
                    </label>
                </div>  
                @endforeach
                @foreach ($subCategories as $subcategory)
                <div class="form-check d-flex gap-2 align-items-center">
                  
                    <input class="form-check-input" type="checkbox" name="category"  value="{{$subcategory->categoryId}}" id="{{$subcategory->categoryId}}" onchange="filterChange()">
                    
                    <label class="form-check-label mt-1" for="ct1">
                      {{$subcategory->categoryName}}
                    </label>
                </div>  
                @endforeach
                          
              </div>
            </div>
          </div>
          <div class="col-md-9">         
              {{-- @include('ajaxProductList', ['products' => $products])--}}
              <div id="ajaxProductList"></div>             
              <div id="pagination" class="mt-4 d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mt-2">
                        <!-- Pagination links will be dynamically added here -->
                    </ul>
                </nav>
            </div>            
          </div>     
       
        </div>
        </div>
        </div>
      </div>
    </section>
    @php
    $minValue = @$setting->min_price_range;
    $maxValue = @$setting->max_price_range;
    @endphp
    <!--====== shop page content end ======-->

	</main>
    @endsection   
    @section('footer.js')
    <script>
      $(document).ready(function() 
      {
          loadDefaultProductList();

          $("#slider-range").slider({
            range: true,
            min: {{$minValue}},
            max: {{$maxValue}}, // Adjust this based on your actual range
            values: [{{$minValue}}, {{$maxValue}}], // Set initial values
            slide: function(event, ui) {
                updatePriceRange(ui.values[0], ui.values[1]);
            },
            change: function(event, ui) {
                filterChange();
            }
        });
    
      }); 

      function updatePriceRange(minValue, maxValue) {
        $("#amount-range1").text("$" + minValue);
        $("#amount-range2").text("$" + maxValue);
    }
  
      $('input[name="brands"]').click(function() 
      {
          $('input[name="brands"]').not(this).prop('checked', false);
          filterChange();
      });
  
      $('input[name="category"]').click(function() 
      {
          $('input[name="category"]').not(this).prop('checked', false);
          filterChange();
      });
           
  
      function loadDefaultProductList(page = 1) 
      {
          // Extract the route parameter from the URL
          var routeParameter = window.location.pathname.split('/').pop();
          var searchParameter = getUrlParameter('search_text');
          console.log(routeParameter);
          console.log(searchParameter);       
          filterChange(page, routeParameter,searchParameter);
      }
  
      function filterChange(page = 1, routeParameter,searchParameter) 
      {
          var selectedBrands = [];
          var selectedCategory = [];
          // var search = $('#search_text').val();          
          var amountMin = $("#slider-range").slider("values", 0);
          console.log(amountMin);
          var amountMax = $("#slider-range").slider("values", 1);
          console.log(amountMax);

          $('input[name="brands"]:checked').each(function() 
          {
              selectedBrands.push($(this).val());
          });
  
          $('input[name="category"]:checked').each(function() 
          {
              selectedCategory.push($(this).val());
          });     

          $.ajax({
              url: "{{ route('getFilteredProducts') }}",
              type: 'POST',
              data: {
                  _token:'{{ csrf_token() }}',
                  brands: selectedBrands,
                  category: selectedCategory,
                  page: page,
                  // search_text: search, 
                  minAmount: amountMin,
                  maxAmount: amountMax,
                  search: searchParameter,
                  filter: routeParameter,
                               
              },
              dataType: 'json',
              success: function(data) 
              { 
               
                  $('#ajaxProductList').html(data.data);
                  updatePagination(data);        
                                              
              },
              error: function(xhr, status, error) {
                  console.error('Error fetching products:', error);
                  console.log(xhr.responseText);
              }
          });
      }

      function getUrlParameter(name) {
        // Function to parse query parameters from the URL
        const urlSearchParams = new URLSearchParams(window.location.search);
        return urlSearchParams.get(name);
      }
  
      function updatePagination(data) {
          $('#pagination ul').html(data.pagination);
          $('#pagination ul').addClass('pagination justify-content-center mt-2');
      }
  
      $(document).on('click', '#pagination a', function(e) {
          e.preventDefault();
          var page = $(this).attr('href').split('page=')[1];
          // Extract the route parameter from the URL
          var routeParameter = window.location.pathname.split('/').pop();
          var searchParameter = getUrlParameter('search_text');
          filterChange(page, routeParameter,searchParameter);
      });
  </script>
    @endsection
   
 




  
  
 
  
