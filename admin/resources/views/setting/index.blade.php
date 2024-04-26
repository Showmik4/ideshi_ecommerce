@extends('layouts.main')
@section('title'){{ 'Setting' }}@endsection
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
                        <h3>Setting</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Setting</li>
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
                            @if(empty($setting))
                            <div class="text-end mb-3">
                                <a href="{{ route('setting.create') }}" class="btn btn-md btn-info " ><i class="fa fa-plus"></i>Create New</a>
                            </div>
                            @endif
                            <div class="table-responsive">
                                <table id="settingTable" class="table table-striped"></table>
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
            $('#settingTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('setting.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    },
                },
                columns: [
                    {title: 'Company Name', data: 'companyName', name: 'companyName', className: "text-center", orderable: true, searchable: true},
                    {title: 'Logo', data: 'logo', name: 'logo', className: "text-center", orderable: false, searchable: false},
                    {title: 'Logo Dark', data: 'logoDark', name: 'logoDark', className: "text-center", orderable: false, searchable: false},
                    {title: 'Phone', data: 'phone', name: 'phone', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.settingId + '" onclick="editSetting(this)"><i class="fa fa-edit"></i></a>';
                                // +' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.settingId + '" onclick="deleteSetting(this)"><i class="fa fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function editSetting(x) {
            let btn = $(x).data('panel-id');
            let url = '{{route("setting.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deleteSetting(x) {
            let settingId = $(x).data('panel-id');
            if(!confirm("Delete This Setting?")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('setting.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'settingId': settingId},
                success: function (data) {
                    toastr.success('Setting Deleted Successfully!');
                    $('#settingTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
