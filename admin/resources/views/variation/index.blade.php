@extends('layouts.main')
@section('title'){{ 'Variation' }}@endsection
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
                        <h3>Variation</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Variation</li>
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
                                <a href="{{ route('variation.create') }}" class="btn btn-md btn-info " ><i class="fa fa-plus"></i>Create New</a>
                            </div>
                            <div class="table-responsive">
                                <table id="variationTable" class="table table-striped"></table>
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
            $('#variationTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('variation.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    },
                },
                columns: [
                    {title: 'Variation Type', data: 'variationType', name: 'variationType', className: "text-center", orderable: true, searchable: true},
                    {title: 'Selection Type', data: 'selectionType', name: 'selectionType', className: "text-center", orderable: true, searchable: true},
                    {title: 'Variation Value', data: 'variationValue', name: 'variationValue', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.variationId + '" onclick="editVariation(this)"><i class="fa fa-edit"></i></a>'+
                                ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.variationId + '" onclick="deleteVariation(this)"><i class="fa fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function editVariation(x) {
            let btn = $(x).data('panel-id');
            let url = '{{route("variation.edit", ":id") }}';
            window.location.href = url.replace(':id', btn);
        }

        function deleteVariation(x) {
            let variationId = $(x).data('panel-id');
            if(!confirm("Delete This Variation?")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('variation.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'variationId': variationId},
                success: function (data) {
                    toastr.success('Variation Deleted Successfully!');
                    $('#variationTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
