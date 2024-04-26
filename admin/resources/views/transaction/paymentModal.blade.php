<div class="modal fade" id="payment-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="addPaymentFrom">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Payment</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="orderId" value="@if(isset($orderInfo)) {{$orderInfo->orderId}} @endif">
                        <input type="hidden" name="orderTotal" value="@if(isset($orderInfo)) {{$orderInfo->orderTotal+$orderInfo->deliveryFee}} @endif">
                        <input type="hidden" name="customerId" value="@if(isset($orderInfo)) {{$orderInfo->fkcustomerId}} @endif">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="paymentType">Payment Type</label><span style="color: red;margin-left: 5px;font-weight: bold;">*</span>
                                <select id="paymentType" name="paymentType" class="form-control">
                                    <option value="">Select</option>
                                    <option value="advance">Advance</option>
                                    <option value="normal">Normal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="paymentMethod">Payment Method</label><span style="color: red;margin-left: 5px;font-weight: bold;">*</span>
                                <select id="paymentMethod" name="paymentMethod" class="form-control">
                                    <option value="">Select</option>
                                    <option value="cash">Cash</option>
                                    <option value="mobileTransfer">Mobile Transfer</option>
                                    <option value="card">Card</option>
                                    {{-- @if(isset($orderInfo->balance))
                                        <option value="customerBalance">Customer Balance-({{$orderInfo->balance}})</option>
                                    @endif --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="amount">Amount</label><span style="color: red;margin-left: 5px;font-weight: bold;">*</span>
                                <input type="text" id="amount" name="amount" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="note">Note</label><span style="color: red;margin-left: 5px;font-weight: bold;">*</span>
                                <textarea id="note" name="note" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" onclick="paymentSave()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function paymentSave() {
        $.ajax({
            url: "{{ route('transaction.save.payment') }}",
            method: 'post',
            cache: false,
            processData: false,
            contentType: false,
            data: new FormData($("#addPaymentFrom")[0]),
            success: function (data) {
                let {message} =data
                toastr.success(`${message}`)
                $('#payment-Modal').modal('toggle');
                $("#addPaymentFrom").trigger('reset')
                location.reload();
            },
            error: function (err) {
                if (err.status === 422) {
                    $("#addPaymentFrom").find("small").remove();
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