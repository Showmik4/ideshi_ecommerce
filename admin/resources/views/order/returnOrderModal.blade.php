<div class="modal fade" id="return-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="orderReturnFrom">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Return</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="orderItemId" value="@if(isset($orderedProduct)){{$orderedProduct->fkOrderId}}@endif">
                        <input type="hidden" name="previousQuantity" value="@if(isset($orderedProduct)){{$orderedProduct->quantity}}@endif">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="rQuantity">Quantity</label>
                                <input type="text" name="rQuantity" id="rQuantity" class="form-control" value="@if(isset($orderedProduct)){{$orderedProduct->quantity}}@endif">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="reason">Reason</label>
                                <textarea id="reason" name="reason" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" onclick="returnSave()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function returnSave() {
        $.ajax({
            url: "{{ route('order.singleReturn') }}",
            method: 'post',
            cache: false,
            processData: false,
            contentType: false,
            data: new FormData($("#orderReturnFrom")[0]),
            success: function (response) {
                console.log(response);
                var url= window.location.href
                url=url.includes("order-details")
                if(url){
                    location.reload();
                }
                else{
                    $('#return-Modal').modal('hide');
                }
            },
            error: function (err) {
                if (err.status === 422) {
                    $("#orderReturnFrom").find("small").remove();
                    $.each(err.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        var errorMSG = error[0].replace('[]', '');
                        el.after($('<small style="color: red;font-weight: bold;">' + errorMSG + '</small>'));
                    });
                }
            }
        });
    }
</script>
