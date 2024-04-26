@extends('layouts.main')
@section('title'){{ 'Page Create' }}@endsection
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
                        <h3>Page Create</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-wizard" action="{{ route('page.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="pageTitle">Page Title</label>
                                            <input class="form-control" id="pageTitle" name="pageTitle" type="text" placeholder="Page Title" value="{{ old('pageTitle') }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('pageTitle') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="details">Page Details</label>
                                            <textarea class="form-control" id="details" name="details" placeholder="Page Details" required>{{ old('details') }}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('details') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image">Page Image</label>
                                            <input class="form-control" id="image" name="image" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('image') }}</b></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="image">Background Image</label>
                                            <input class="form-control" id="image" name="background_image" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('background_image') }}</b></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status">Page Status</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="">Select Page Status</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('status') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('page.show') }}">Cancel</a></button>
                                            <button class="btn btn-primary" type="submit">Create</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer.js')
    <script>
        $(document).ready( function () {
            CKEDITOR.replace( 'details', {
                filebrowserUploadUrl: '{{ route('ckeditor.upload', ['_token' => csrf_token() ]) }}',
                filebrowserUploadMethod: 'form'
            });
        });
    </script>
@endsection
