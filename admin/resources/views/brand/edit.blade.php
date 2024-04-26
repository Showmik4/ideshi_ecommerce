@extends('layouts.main')
@section('title'){{ 'Brand Edit' }}@endsection
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
                        <h3>Brand Edit</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Brand</li>
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
                            <form class="form-wizard" action="{{ route('brand.update', $brand->brandId) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="brandName">Brand Name</label>
                                            <input class="form-control" id="brandName" name="brandName" type="text" placeholder="Brand Name" value="{{ @$brand->brandName }}" required>
                                            <span class="text-danger"> <b>{{  $errors->first('brandName') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="brandLogo">Brand Logo</label>
                                            <input class="form-control" id="brandLogo" name="brandLogo" type="file">
                                            <span class="text-danger"> <b>{{  $errors->first('brandLogo') }}</b></span>
                                        </div>
                                        @if(isset($brand->brandLogo))
                                        <div class="mb-3">
                                            <img height="100px" width="100px" src="{{ url(@$brand->brandLogo) }}" alt="">
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <label for="status">Brand Status</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="">Select Brand Status</option>
                                                <option value="active" @if($brand->status === 'active') selected @endif>Active</option>
                                                <option value="inactive" @if($brand->status === 'inactive') selected @endif>Inactive</option>
                                            </select>
                                            <span class="text-danger"> <b>{{  $errors->first('status') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('brand.show') }}">Cancel</a></button>
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
