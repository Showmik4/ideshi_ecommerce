@extends('layouts.main')
@section('title'){{ 'Unit' }}@endsection
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
                        <h3>Unit</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Unit</li>
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
                                <a href="{{ route('unit.create') }}" class="btn btn-md btn-info " ><i class="fa fa-plus"></i>Create New</a>
                            </div>
                            <div class="table-responsive">
                                <table id="unitTable" class="table table-striped"></table>
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
            $('#unitTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('unit.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    },
                },
                columns: [
                    {title: 'Unit Name', data: 'unitName', name: 'unitName', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.unitId + '" onclick="editUnit(this)"><i class="fa fa-edit"></i></a>'+
                                ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.unitId + '" onclick="deleteUnit(this)"><i class="fa fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function editUnit(x) {
            let btn = $(x).data('panel-id');
            let url = '{{route("unit.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deleteUnit(x) {
            let unitId = $(x).data('panel-id');
            if(!confirm("Delete This Unit?")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('unit.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'unitId': unitId},
                success: function (data) {
                    toastr.success('Unit Deleted Successfully!');
                    $('#unitTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
