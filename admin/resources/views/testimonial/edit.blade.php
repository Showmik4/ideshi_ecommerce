@extends('layouts.main')
@section('title'){{ 'Testimonial Edit' }}@endsection
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
                        <h3>Testimonial Edit</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Testimonial</li>
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
                            <form class="form-wizard" action="{{ route('testimonial.update', $testimonial->testimonialId) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="name">Name</label>
                                            <input class="form-control" id="name" name="name" type="text" placeholder="Name" value="{{ @$testimonial->name }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('name') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="designation">Designation</label>
                                            <input class="form-control" id="designation" name="designation" type="text" placeholder="Designation" value="{{ @$testimonial->designation }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('designation') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="imageLink">Testimonial Image</label>
                                            <input class="form-control" id="imageLink" name="imageLink" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('imageLink') }}</b></span>
                                        </div>
                                        @if(isset($testimonial->imageLink))
                                        <div class="mb-3">
                                            <img height="100px" width="100px" src="{{ url($testimonial->imageLink) }}" alt="">
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <label for="details">Details</label>
                                            <textarea class="form-control" name="details" id="details" placeholder="Details" required>{!! @$testimonial->details !!}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('details') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeShow">Home Show</label>
                                            <input type="checkbox" id="homeShow" name="homeShow" value="1" @if(@$testimonial->homeShow === 1) checked @endif>
                                            <span class="text-danger"> <b>{{  $errors->first('homeShow') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status">Testimonial Status</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="">Select Testimonial Status</option>
                                                <option value="active" @if($testimonial->status === 'active') selected @endif>Active</option>
                                                <option value="inactive" @if($testimonial->status === 'inactive') selected @endif>Inactive</option>
                                            </select>
                                            <span class="text-danger"> <b>{{  $errors->first('status') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('testimonial.show') }}">Cancel</a></button>
                                            <button class="btn btn-primary" type="submit">Update</button>
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
            CKEDITOR.replace( 'details')
        });
    </script>
@endsection
