<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="exampleModalLabel">
          Your Cart
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-image">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">Product</th>
              <th scope="col">Price</th>            
              <th scope="col">Actions</th>
            </tr>
          </thead>
          @foreach(\Cart::getContent() as $cartItem)
          <tbody>           
            <tr id="partial-cart-body">
              <td class="w-25">
                <img src="{{ url('admin/'.$cartItem->attributes->image) }}" class="img-fluid img-thumbnail" alt="Sheep">
              </td>
              <td>{{ $cartItem->name }}</td>
              <td>{{ $cartItem->price }}</td>             
              <td>
                <a href="#" class="btn btn-danger btn-sm">
                  <i class="fa fa-times"></i>
                </a>
              </td>
            </tr>            
          </tbody>
          @endforeach
        </table> 
        <div class="d-flex justify-content-end" id="partial-cart-footer">
          <h5>Total: <span class="modal-cart-price text-success">{{ \Cart::getSubTotal() }}$</span></h5>
        </div>
      </div>
      <div class="modal-footer border-top-0 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="{{route('product.view_cart')}}">
        <button type="button" class="btn btn-success">View Cart</button>
        </a>
      </div>
    </div>
  </div>
</div>