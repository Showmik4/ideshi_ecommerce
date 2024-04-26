@extends('layouts.main')
@section('title'){{ 'User Type' }}@endsection
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
                        <h3>User Type</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">User Type</li>
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
                                <a href="{{ route('userType.create') }}" class="btn btn-md btn-info " ><i class="fa fa-plus"></i>Create New</a>
                            </div>
                            <div class="table-responsive">
                                <table id="userTypeTable" class="table table-striped"></table>
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
            $('#userTypeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('userType.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    },
                },
                columns: [
                    {title: 'User Type Name', data: 'typeName', name: 'typeName', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.userTypeId + '" onclick="editUserType(this)"><i class="fa fa-edit"></i></a>'+
                                ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.userTypeId + '" onclick="deleteUserType(this)"><i class="fa fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function editUserType(x) {
            let btn = $(x).data('panel-id');
            let url = '{{route("userType.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deleteUserType(x) {
            let userTypeId = $(x).data('panel-id');
            if(!confirm("Delete This User Type?")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('userType.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'userTypeId': userTypeId},
                success: function (data) {
                    toastr.success('User Type Deleted Successfully!');
                    $('#userTypeTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
