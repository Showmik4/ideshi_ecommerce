@extends('layouts.main')
@section('title'){{ 'Page' }}@endsection
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
                        <h3>Page</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Page</li>
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
                                <a href="{{ route('page.create') }}" class="btn btn-md btn-info " ><i class="fa fa-plus"></i>Create New</a>
                            </div>
                            <div class="table-responsive">
                                <table id="pageTable" class="table table-striped"></table>
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
            $('#pageTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('page.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    },
                },
                columns: [
                    {title: 'Page Title', data: 'pageTitle', name: 'pageTitle', className: "text-center", orderable: true, searchable: true},
                    {title: 'Image', data: 'image', name: 'image', className: "text-center", orderable: false, searchable: false},
                    {title: 'Background Image', data: 'background_image', name: 'background_image', className: "text-center", orderable: false, searchable: false},
                    {title: 'Status', data: 'status', name: 'status', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.pageId + '" onclick="editPage(this)"><i class="fa fa-edit"></i></a>'+
                                ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.pageId + '" onclick="deletePage(this)"><i class="fa fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function editPage(x) {
            let btn = $(x).data('panel-id');
            let url = '{{route("page.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deletePage(x) {
            let pageId = $(x).data('panel-id');
            if(!confirm("Delete This Page? This will also delete related menu.")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('page.delete') !!}",
                cache: false,
                data: {_token: "{{ csrf_token() }}",'pageId': pageId},
                success: function (data) {
                    toastr.success('Page Deleted Successfully!');
                    $('#pageTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
