@extends('layouts.main')
@section('title'){{ 'Menu' }}@endsection
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
                        <h3>Menu</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Menu</li>
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
                                <a href="{{ route('menu.create') }}" class="btn btn-md btn-info " ><i class="fa fa-plus"></i>Create New</a>
                            </div>
                            <div class="table-responsive">
                                <table id="menuTable" class="table table-striped"></table>
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
            $('#menuTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('menu.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    },
                },
                columns: [
                    {title: 'Menu Name', data: 'menuName', name: 'menuName', className: "text-center", orderable: true, searchable: true},                  
                    {title: 'Menu Order', data: 'menuOrder', name: 'menuOrder', className: "text-center", orderable: true, searchable: true},
                    {title: 'Menu Type', data: 'menuType', name: 'menuType', className: "text-center", orderable: true, searchable: true},                  
                    {title: 'Page Title', data: 'fkPageId', name: 'fkPageId', className: "text-center", orderable: false, searchable: false},
                    {title: 'Status', data: 'status', name: 'status', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.menuId + '" onclick="editMenu(this)"><i class="fa fa-edit"></i></a>'+
                                ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.menuId + '" onclick="deleteMenu(this)"><i class="fa fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function editMenu(x) {
            let btn = $(x).data('panel-id');
            let url = '{{route("menu.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deleteMenu(x) {
            let menuId = $(x).data('panel-id');
            if(!confirm("Delete This Menu? This will also delete Sub Menus.")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('menu.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'menuId': menuId},
                success: function (data) {
                    toastr.success('Menu Deleted Successfully!');
                    $('#menuTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
