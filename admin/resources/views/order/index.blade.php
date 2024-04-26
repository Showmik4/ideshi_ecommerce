@extends('layouts.main')
@section('title'){{ 'Orders' }}@endsection
@section('header.css')
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">
<link href="{{ url('public/assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
type="text/css" />
<link href="{{ url('public/assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
type="text/css" />
    <style>

    </style>
@endsection
@section('main.content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Orders</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active">Orders</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <!-- Zero Configuration  Starts-->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-end mb-3">
                                <a href="{{ route('order.create') }}" class="btn btn-md btn-info " ><i class="fa fa-plus"></i>Create New</a>
                            </div>
                            <div class="table-responsive">
                                <table id="orderTable" class="table table-striped"></table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Zero Configuration  Ends-->
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
    <div id="statusModal"></div>
@endsection
@section('footer.js')
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js" type="text/javascript"></script>
<script src="{{ url('public/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('public/assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        // $(document).ready(function () {
        //     $('#productTable').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: {
        //             "url": "{{route('order.list')}}",
        //             "type": "POST",
        //             data: function (d) {
        //                 d._token = "{{ csrf_token() }}";
        //             },
        //         },
        //         columns: [
        //             {title: 'OrderId', data: 'orderId', name: 'orderId', className: "text-center", orderable: true, searchable: true},
        //             {title: 'phone', data: 'phone', name: 'customer.phone', className: "text-center", orderable: true, searchable: true},
        //             {title: 'Order Total', data: 'orderTotal', name: 'orderTotal', className: "text-center", orderable: true, searchable: true},
        //             {title: 'Total Paid', data: 'totalpaid', name: 'totalpaid', className: "text-center", orderable: true, searchable: true},
        //             {title: 'Status', data: 'lastStatus', name: 'lastStatus', className: "text-center", orderable: true, searchable: true},
        //             {title: 'Created', data: 'created_at', name: 'created_at', className: "text-center", orderable: false, searchable: false,  render: (data) => data.split('T')[0]},
        //             {title: 'Updated', data: 'updated_at', name: 'updated_at', className: "text-center", orderable: true, searchable: true,  render: (data) => data.split('T')[0]},
        //             {title: 'Action', className: "text-center", data: function (data) {
        //                     return '<a title="edit" class="btn btn-warning btn-xs" data-panel-id="' + data.orderId + '" onclick="showOrder(${data.orderId})"><i class="fa fa-eye"></i></a>'+
        //                         ' <a title="delete" class="btn btn-danger btn-xs" data-panel-id="' + data.orderId + '" onclick="editOrder(${data.orderId})"><i class="fa fa-edit"></i></a>';
        //                 }, orderable: false, searchable: false
        //             }
        //         ]
        //     });
        // });
        $(document).ready(function() {
                table()
            });

            function table() {
                dataTable = $('#orderTable').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    Filter: true,
                    bDestroy: true,
                    columnDefs: [{
                        className: 'select-checkbox',
                        targets: 0,
                    }],
                    select: {
                        style: 'os',
                        selector: 'td:first-child'
                    },
                    type: "POST",
                    "ajax": {

                        "url": "{!! route('order.list') !!}",
                        "type": "POST",
                        "data": function(d) {
                            d._token = "{{ csrf_token() }}";
                            d.vendorInfo = $('#vendorInfo').val();
                            d.orderStatus = $('#status').val();
                            d.fromDate = $('#fromDate').val();
                            d.toDate = $('#toDate').val();
                            // d.productId = serachP
                            // d.memo = serachM
                            d.print=$('#pStatus').val();
                            d.payment=$('#paymentStatus').val();
                            d.problem=$('#problemOrder').val();
                            d.paymentType=$('#paymentType').val();

                        },
                    },
                    columns: [{
                            data: null,
                            defaultContent: "",
                            orderable: false,
                            searchable: false
                        },
                        {
                            title: 'OrderID',
                            data: 'orderId',
                            name: 'orderId',
                            className: "text-center",
                            orderable: true,
                            searchable: true
                        },
                        {
                            title: 'Phone',
                            data: 'phone',
                            name: 'customer.phone',
                            className: "text-center",
                            orderable: true,
                            searchable: true
                        },
                        {
                            title: 'Order Total',
                            data: 'orderTotal',
                            name: 'orderTotal',
                            className: "text-center",
                            orderable: true,
                            searchable: false
                        },
                        {
                            title: 'Total paid',
                            data: 'totalpaid',
                            name: 'totalpaid',
                            className: "text-center",
                            orderable: true,
                            searchable: false
                        },
                        // {
                        //     title: 'Remark',
                        //     data: 'remark',
                        //     name: 'remark',
                        //     className: "text-center",
                        //     orderable: true,
                        //     searchable: false
                        // },
                        // {
                        //     title: 'Print',
                        //     name: 'print',
                        //     className: "text-center",
                        //     orderable: true,
                        //     searchable: false,
                        //     data: (data) => {
                        //         if (data.print == 1) {
                        //             return `<i class="ft ft-printer"></i>`
                        //         } else {
                        //             return 'NO'
                        //         }
                        //     }
                        // },
                        {
                            title: 'Status',
                            data: 'lastStatus',
                            name: 'lastStatus',
                            className: "text-center",
                            orderable: true,
                            searchable: false
                        },
                        {
                            title: 'Created',
                            data: 'created_at',
                            name: 'order_info.created_at',
                            className: "text-center",
                            orderable: true,
                            searchable: true,
                            render: (data) => data.split('T')[0]
                        },
                        {
                            title: 'Updated',
                            data: 'updated_at',
                            name: 'updated_at',
                            className: "text-center",
                            orderable: true,
                            searchable: true,
                            render: (data) => data.split('T')[0]

                        },
                        {
                            title: 'Action',
                            name: 'action',
                            className: "text-center",
                            orderable: false,
                            searchable: false,
                            data: (data) => {
                                return `<a href="javascript:void(0)" class="btn btn-warning" onclick="editOrder(${data.orderId})" title="Order edit"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="showOrder(${data.orderId})" title="Order show"><i class="fa fa-eye"></i></a>
                                    <a href="javascript:void(0)" class="btn btn-info" onclick="orderStatus(${data.orderId})" title="Status change"><i class="fa fa-refresh"></i></a>`
                            }
                        }
                    ],
                });

                dataTable.on('select', function(e, dt, type, indexes) {

                    $('.zip').show();
                });
            };

        function orderStatus(data) {
            $.ajax({
                type: "POST",
                url: '{{ route('order.orderStatus')}}',
                data: {
                    'id': data,
                    '_token': "{{ csrf_token() }}",
                },
                success: function(response) {
                    $('#statusModal').html(response)                    
                    $('#statusChangeModal').modal('toggle');                   
                }
            });
        }

        function editOrder(data){
            window.location.href = `{{ route('order.edit', '') }}/${data}`
        }

        function showOrder(data) {
           window.location.href = `{{ route('order.details', '') }}/${data}`
        }

        function editProduct(x) {
            let btn = $(x).data('panel-id');
            let url = '{{route("product.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deleteProduct(x) {
            let productId = $(x).data('panel-id');
            if(!confirm("Delete This Product?")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('product.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'productId': productId},
                success: function (data) {
                    toastr.success('Product Deleted Successfully!');
                    $('#productTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
