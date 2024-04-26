@extends('layouts.main')
@section('title'){{ 'Slider Create' }}@endsection
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
                        <h3>Slider Create</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Slider</li>
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
                            <form class="form-wizard" action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="titleText">Title Text</label>
                                            <input class="form-control" id="titleText" name="titleText" type="text" placeholder="Title Text" value="{{ old('titleText') }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('titleText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="mainText">Main Text</label>
                                            <input class="form-control" id="mainText" name="mainText" type="text" placeholder="Main Text" value="{{ old('mainText') }}">
                                            <span class="text-danger"><b>{{  $errors->first('mainText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="subText">Sub Text</label>
                                            <input class="form-control" id="subText" name="subText" type="text" placeholder="Sub Text" value="{{ old('subText') }}">
                                            <span class="text-danger"><b>{{  $errors->first('subText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="imageLink">Slider Image</label>
                                            <input class="form-control" id="imageLink" name="imageLink" type="file" required>
                                            <span class="text-danger"><b>{{ $errors->first('imageLink') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="pageLink">Page Link</label>
                                            <input class="form-control" id="pageLink" name="pageLink" type="text" placeholder="Page Link" value="{{ old('pageLink') }}">
                                            <span class="text-danger"><b>{{  $errors->first('pageLink') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="serial">Serial</label>
                                            <input class="form-control" id="serial" name="serial" type="number" min="1" placeholder="Serial" value="{{ old('serial') }}">
                                            <span class="text-danger"><b>{{  $errors->first('serial') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status">Slider Status</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="">Select Slider Status</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('status') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('slider.show') }}">Cancel</a></button>
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
