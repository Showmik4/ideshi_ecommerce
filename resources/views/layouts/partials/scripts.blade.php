	<!-- JS here -->

	<!-- Modernizr js -->
    
	<script src="{{ asset('public/assets/js/modernizr-3.5.0.min.js')}}"></script>
	<!-- jquery -->
	<script src="{{ asset('public/assets/js/jquery-3.2.1.min.js')}}"></script>
	<!-- Bootstrap -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
	<script src="{{ asset('public/assets/plugins/bootstrap-5.2.0/js/bootstrap.bundle.min.js')}}"></script>
	{{-- <script src="{{ asset('public/assets/plugins/bootstrap-5.2.0/js/bootstrap.min.js')}}"></script> --}}
	<!-- Owl carousel -->
	<script src="{{ asset('public/assets/plugins/owl-carousel/owl.carousel.min.js')}}"></script>
	<!-- Magnafic popup image/video -->
	<!-- <script src="public/assets/plugins/magnific-popup/magnific-popup.js"></script> -->
	<!-- Counter up -->
	<script src="{{ asset('public/assets/js/waypoints.js')}}"></script>
	<script src="{{ asset('public/assets/js/counterup.js')}}"></script>
	<!-- Custom js -->
	<script src="{{ asset('public/assets/js/all.js')}}"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(session('message'))
        toastr.info('{{ session('message') }}')
        @endif
    
        @if(session('warning'))
        toastr.warning('{{ session('warning') }}')
        @endif
    
        @if(session('success'))
        toastr.success('{{ session('success') }}')
        @endif
    
        @if(session('error'))
        toastr.error('{{ session('error') }}')
        @endif
    
            //Jquery On ecnyer event bonding
            (function($) {
                $.fn.onEnter = function(func) {
                    this.bind('keypress', function(e) {
                        if (e.keyCode === 13) func.apply(this, [e]);
                    });
                    return this;
                };
            })(jQuery);
    
    </script>
	<!--toastr end-->

	{{--cart--}}
    {{-- <script>
        document.getElementById('openCartModalButton').addEventListener('click', function(event) {
            event.preventDefault(); 
    
            var myModal = new bootstrap.Modal(document.getElementById('cartModal'));
            myModal.show();
        });
    </script> --}}
    
 
	<script>
    function addToCart(skuId)
    {
        if(skuId == 0)
        {
            toastr.warning('Please Choose a variation');
        }
        if(skuId != 0){
            let quantity=$('#quantity').val();
            if(quantity && quantity >= 1)
            {
                quantity;
            }
            if(!quantity || quantity<1)
            {
                quantity = 1;
            }
        $.ajax({
            type: 'post',          
            url: "{{route('product.addToCart')}}",
            data:{
                _token:'{{csrf_token()}}',
                sku:skuId,
                quantity:quantity,
                selectedColor: $('input[name=color]:checked').val(),
                selectedSize: $('input[name=size]:checked').val(),
            },
            success: function (response) 
            {
                toastr.success('Added to cart successfully')
                $("#cartQuantityHeader").load(location.href + " #cartQuantityHeader");
                $("#cart-body").load(location.href + " #cart-body");
                $("#cart-footer").load(location.href + " #cart-footer");               
            },
            error:function (response){
                toastr.error('Stock not available')
            }
        });
        }
    }    

    function increaseQuantity(skuId)
    {
        var quantity = $('#quantity_'+skuId).val();
        quantity = parseInt(quantity) + 1        

        $("#quantity_"+skuId).val(quantity)

        $.ajax({
            type: 'post',
            url: "{{ route('product.updateCart') }}",
            data:{
                _token:'{{csrf_token()}}',
                sku: skuId,
                quantity: quantity
            },
            success: function (response) {
                toastr.success('Quantity updated successfully')
                $("#cart-body").load(location.href + " #cart-body");
                $("#cart-footer").load(location.href + " #cart-footer");
            },
            error:function (response){
                toastr.error('Stock not available')
            }
        });
    }

    function decreaseQuantity(skuId){
        var quantity = $('#quantity_'+skuId).val();
        quantity = parseInt(quantity) - 1;

        if(quantity <= 0){
            quantity = 1;
        }

        $("#quantity_"+skuId).val(quantity)

        $.ajax({
            type: 'post',
            url: "{{ route('product.updateCart')}}",
           
            data:{
                _token:'{{csrf_token()}}',
                sku: skuId,
                quantity: quantity
            },
            success: function (response) 
            {
                toastr.success('Quantity updated successfully')
                $("#cart-body").load(location.href + " #cart-body");
                $("#cart-footer").load(location.href + " #cart-footer");
            },
            error:function (response){
                toastr.error('Stock not available')
            }
        });
    }

    function clearCart()
    {
       
            $.ajax({
            type: 'post',
            url: "{{ route('product.clearCart') }}",
            data:{
                _token:'{{csrf_token()}}',
            },
            success: function (response) {
                toastr.success('Cart clear successfully')
                $("#cartSection").load(location.href + " #cartSection");
                $("#cartQuantityHeader").load(location.href + " #cartQuantityHeader");
            },
            error:function (response){
                toastr.error('Error occurred')
            }
        });
          
    
    
    }   
  
    function removeCartItem(skuId) 
    {
        if(confirm("Are you sure to delete the cart"))
        {
        $.ajax({
            type: 'post',
            url: "{{ route('product.removeCartItem') }}",
            data: {
                _token: '{{csrf_token()}}',
                sku: skuId,
            },
            success: function (response) 
            {                   
                toastr.success('Cart item removed successfully');
                $("#cart-table-body").load(location.href + " #cart-table-body");
                $("cart-footer").load(location.href + "#cart-footer");
                $("#cartQuantityHeader").load(location.href + " #cartQuantityHeader");
            },
            error: function (response) 
            {                
                toastr.error('Error occurred');
            }
        });
    }
        }

        function zone(zoneId){
            $.ajax({
                type: 'post',
                url: "{{ route('product.shipmentZoneCharge') }}",
                data:{
                    _token:'{{csrf_token()}}',
                    zone: zoneId
                },
                success: function (response) 
                {
                    // zoneCharge
                    $("#zoneData").empty().append(`
                        $${response.zoneCharge}
                    `)
                    $("#zoneCharge").empty().append(`
                            <span class="title">Shipment Zone</span>
                            <span class="amount">$${response.zoneCharge}</span>
                    `)
                    $("#totalWithZoneCharge").empty().append(`
                            <td>Total</td>
                            <td class="order-total-amount">$${response.zoneCharge+response.cartSubTotal}</td>
                    `)
                }
            });
        }

	</script>

	{{-- wishlist --}}
    <script>
        function submitSearchForm() {
            var searchInputValue = $('#search_text').val();
            var currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('search_text', searchInputValue);
    
            // Replace the current URL without reloading the page
            window.history.replaceState({}, document.title, currentUrl.href);
    
            // You can also submit the form if needed
            // $('#searchForm').submit();
        }
    </script>

    <script>
        function addToWishlist(skuId) {
            let auth = "{{ auth()->check() }}"
            if (auth !== "") {
                if(skuId !== 0) {
                    $.ajax({
                        type: 'post',
                        url: "{{ route('product.addToWishlist') }}",
                        data: {
                            _token: '{{csrf_token()}}',
                            skuId: skuId,
                        },
                        success: function (response) {
                            if(response.hasOwnProperty('success')) {
                                toastr.success(response.success)
                            }

                            if(response.hasOwnProperty('error')) {
                                toastr.error(response.error)
                            }

                            if(response.hasOwnProperty('warning')) {
                                toastr.warning(response.warning)
                            }
                        }
                    });
                } else {
                    toastr.warning('Please Choose a variation');
                }
            } else {
                window.location.href = "{{ route('login') }}"
            }
        }
    </script>
	@yield('footer.js')