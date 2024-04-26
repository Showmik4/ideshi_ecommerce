<div class="modal"id="statusChangeModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Order Status</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="ml-1">Order Current Status.</p>
                {{-- @dd($order->lastStatus->status); --}}
                <form id="" action="{{ route('order.orderStatusUpdate', $order->orderId) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="orderId" name="orderId" value="@if(isset($order)){{$order->orderId}}@endif">
                    <input type="hidden" name="currentStatus" value="@if(isset($order)){{$order->lastStatus}}@endif">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <select id="status" name="status" class="form-control">
                                <option value="">Select</option>                               
                                <option value="Processing" @if(isset($order) && $order->lastStatus == 'Processing') selected @endif>Processing</option>
                                <option value="OnDelivery" @if(isset($order) && $order->lastStatus == 'OnDelivery') selected @endif>OnDelivery</option>
                                <option value="Delivered" @if(isset($order) && $order->lastStatus == 'Delivered') selected @endif>Delivered</option>                                
                                <option value="Complete" @if(isset($order) && $order->lastStatus == 'Complete') selected @endif>Complete</option>
                                <option value="Cancel" @if(isset($order) && $order->lastStatus == 'Cancel') selected @endif>Cancel</option>
                            </select>
                        </div>
                        <div id="deliverdNew" style="display: none" >
                            <div class="row ">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="deliveryFee">Total amount</label>
                                        <input type="text" name="amount" id="amount" class="form-control" value="{{$order->orderTotal ?? ''}}" readonly>
                                    </div>
                                </div>
    
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="deliveryFee">Due amount:</label>
                                        <input type="text" name="dueAmount" id="dueAmount" class="form-control" value="{{$dueAmount ?? $order->orderTotal}}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="deliveryCommissionType">Delivery Company Name</label>
                                        <select class="form-control" name="delivery_company" id="delivery_company">
                                            <option value="">Select</option>
                                            @foreach($deliveryServices as $deliveryService)
                                                <option value="{{$deliveryService->deliveryServiceId}}" @if($order->delivery_service==$deliveryService->deliveryServiceId) selected @endif >{{$deliveryService->companyName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="deliveryFee">Delivery Fee</label>
                                        <input type="text" name="deliveryFee" id="deliveryFee" class="form-control" value="{{$order->deliveryFee ?? ''}}" >
                                    </div>
                                </div>
                                
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="deliveryFee">Collect amount:</label>
                                        <input type="text" name="collectAmount" id="collectAmount" class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group mt-2">
                            <textarea class="form-control" id="note" name="note" rows="4" cols="50" placeholder="Enter note here..">                              
                            </textarea>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
			</div>
			
		</div>
	</div>
</div>
<script>
    function changeStatus(...data){
        
        let status=_.head(data);
        let orderId=_.last(data);
        if(status=="OnDelivery")
        {
            $('#deliverdNew').show()
        }
        else{
            $('#deliverdNew').hide()
        }
        
        // $.ajax({
        //     type: "POST",
        //     url: "{{route('order.statusChangeSubmit')}}",
        //     data: {
        //         data,
        //         '_token':"{{csrf_token()}}",
        //         },
        //     success: function (response) {
                
        //     }
        // });
    }

    function statusSubmit(){
        $.ajax({
        url: "{{route('order.statusChangeSubmit')}}",
        method: 'post',
        cache: false,
        processData: false,
        contentType: false,
        data: new FormData($("#statusForm")[0]),
        success: function (data) {
            let message = data.message ?? '';

            // display toastr notification
            if (message) {
                toastr.success('The status is changed');
            }
            let newStatus=$('#status').val();
            $('#viewStatus').html(`Status: ${newStatus}`);
            $('#mainStatus').html(`Status: ${newStatus}`);
            $('#statusChangeModal').modal('hide'); 
         
            let url=location.href;
            if(!url.match('order-details')){
                $('#orderTable').DataTable().draw() 
            }
        },
        error: function (err) {
            console.log(err);
            if (err.status === 422) {
                $("#statusForm").find("small").remove();
                $('#status').after($(`<small style="color: red"> ${err.responseJSON.message} </small>`));
                $.each(err.responseJSON.errors, function (i, error) {
                    var el = $(document).find('[name="' + i + '"]');
                    var errorMSG = error[0].replace('[]', '');
                    el.after($('<small style="color: red;">' + errorMSG + '</small>'));
                });
            }
        }
    });
    }

    
    
</script>