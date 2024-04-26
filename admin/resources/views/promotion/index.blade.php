@extends('layouts.main')
@section('title'){{ 'Promotion' }}@endsection
@section('header.css')
    <style>

    </style>
@endsection
@section('main.content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Promotion</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Promotion</li>
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
                                <a href="{{ route('promotion.create') }}" class="btn btn-md btn-info " ><i class="fa fa-plus"></i>Create New</a>
                            </div>
                            <div class="table-responsive">
                                <table id="promotionTable" class="table table-striped"></table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Zero Configuration  Ends-->
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
@endsection
@section('footer.js')
    <script>
        $(document).ready(function () {
            $('#promotionTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('promotion.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    },
                },
                columns: [
                    {title: 'Promotion Code', data: 'promotionCode', name: 'promotionCode', className: "text-center", orderable: true, searchable: true},
                    {title: 'Promotion Title', data: 'promotionTitle', name: 'promotionTitle', className: "text-center", orderable: true, searchable: true},
                    {title: 'Start Date', data: 'startDate', name: 'startDate', className: "text-center", orderable: true, searchable: true},
                    {title: 'End Date', data: 'endDate', name: 'endDate', className: "text-center", orderable: true, searchable: true},
                    {title: 'Amount', data: 'amount', name: 'amount', className: "text-center", orderable: true, searchable: true},
                    {title: 'Percentage', data: 'percentage', name: 'percentage', className: "text-center", orderable: true, searchable: true},
                    {title: 'Use Limit', data: 'useLimit', name: 'useLimit', className: "text-center", orderable: true, searchable: true},
                    {title: 'Total Used', data: 'totalUsed', name: 'totalUsed', className: "text-center", orderable: true, searchable: true},
                    {title: 'Status', data: 'status', name: 'status', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.promotionId + '" onclick="editPromotion(this)"><i class="fa fa-edit"></i></a>'+
                                ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.promotionId + '" onclick="deletePromotion(this)"><i class="fa fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function editPromotion(x) {
            let btn = $(x).data('panel-id');
            let url = '{{route("promotion.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deletePromotion(x) {
            let promotionId = $(x).data('panel-id');
            if(!confirm("Delete This Promotion? This will also delete the related banner.")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('promotion.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'promotionId': promotionId},
                success: function (data) {
                    toastr.success('Promotion Deleted Successfully!');
                    $('#promotionTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
