@extends('layouts.main')
@section('title'){{ 'Contact' }}@endsection
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
                        <h3>Contact</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active">Contact</li>
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
                            <div class="table-responsive">
                                <table id="contactTable" class="table table-striped"></table>
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
            $('#contactTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{route('contact.list')}}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    },
                },
                columns: [
                    {title: 'Name', data: 'name', name: 'name', className: "text-center", orderable: true, searchable: true},
                    {title: 'Email', data: 'email', name: 'email', className: "text-center", orderable: true, searchable: true},
                    {title: 'Phone', data: 'phone', name: 'phone', className: "text-center", orderable: true, searchable: true},
                    {title: 'Subject', data: 'subject', name: 'subject', className: "text-center", orderable: true, searchable: true},
                    {title: 'Received At', data: 'created_at', name: 'created_at', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            // return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.contactId + '" onclick="editContact(this)"><i class="fa fa-edit"></i></a>';
                                return ' <a title="delete" class="btn btn-danger btn-sm" data-panel-id="' + data.contactId + '" onclick="deleteContact(this)"><i class="fa fa-trash"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        {{--function editContact(x) {--}}
        {{--    let btn = $(x).data('panel-id');--}}
        {{--    let url = '{{route("contact.edit", ":id") }}';--}}
        {{--    window.location.href = url.replace(':id', btn);--}}
        {{--}--}}

        function deleteContact(x) {
            let contactId = $(x).data('panel-id');
            if(!confirm("Delete This Contact?")){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "{!! route('contact.delete') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'contactId': contactId},
                success: function (data) {
                    toastr.success('Contact Deleted Successfully!');
                    $('#contactTable').DataTable().clear().draw();
                },
            });
        }
    </script>
@endsection
