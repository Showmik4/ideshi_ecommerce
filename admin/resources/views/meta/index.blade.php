@extends('layouts.main')
@section('title'){{ 'Meta' }}@endsection
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
                        <h3>Meta</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Meta</li>
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
                                <a href="{{ route('meta.create') }}" class="btn btn-md btn-info " ><i class="fa fa-plus"></i>Create New</a>
                            </div>
                            <div class="table-responsive">
                                <table id="metaTable" class="table table-striped"></table>
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
            $('#metaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('meta.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    },
                },
                columns: [
                    {title: 'Meta Name', data: 'metaName', name: 'metaName', className: "text-center", orderable: true, searchable: true},
                    {title: 'Meta Content', data: 'metaContent', name: 'metaContent', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.metaId + '" onclick="editMeta(this)"><i class="fa fa-edit"></i></a>'+
                                ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.metaId + '" onclick="deleteMeta(this)"><i class="fa fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function editMeta(x) {
            let btn = $(x).data('panel-id');
            let url = '{{route("meta.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deleteMeta(x) {
            let metaId = $(x).data('panel-id');
            if(!confirm("Delete This Meta?")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('meta.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'metaId': metaId},
                success: function (data) {
                    toastr.success('Meta Deleted Successfully!');
                    $('#metaTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
