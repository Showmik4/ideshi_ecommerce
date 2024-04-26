@extends('layouts.main')
@section('title'){{ 'Banner' }}@endsection
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
                        <h3>Banner</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Banner</li>
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
                                <a href="{{ route('banner.create') }}" class="btn btn-md btn-info " ><i class="fa fa-plus"></i>Create New</a>
                            </div>
                            <div class="table-responsive">
                                <table id="bannerTable" class="table table-striped"></table>
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
            $('#bannerTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('banner.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    },
                },
                columns: [
                    {title: 'Banner Title', data: 'bannerTitle', name: 'bannerTitle', className: "text-center", orderable: true, searchable: true},
                    {title: 'Banner Image', data: 'imageLink', name: 'imageLink', className: "text-center", orderable: false, searchable: false},
                    {title: 'Type', data: 'type', name: 'type', className: "text-center", orderable: true, searchable: true},
                    {title: 'Status', data: 'status', name: 'status', className: "text-center", orderable: true, searchable: true},                    
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.bannerId + '" onclick="editBanner(this)"><i class="fa fa-edit"></i></a>'+
                                ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.bannerId + '" onclick="deleteBanner(this)"><i class="fa fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function editBanner(x) {
            let btn = $(x).data('panel-id');
            let url = '{{route("banner.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deleteBanner(x) {
            let bannerId = $(x).data('panel-id');
            if(!confirm("Delete This Banner?")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('banner.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'bannerId': bannerId},
                success: function (data) {
                    toastr.success('Banner Deleted Successfully!');
                    $('#bannerTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
