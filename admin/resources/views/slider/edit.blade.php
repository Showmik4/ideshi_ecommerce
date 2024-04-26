@extends('layouts.main')
@section('title'){{ 'Slider Edit' }}@endsection
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
                        <h3>Slider Edit</h3>
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
                            <form class="form-wizard" action="{{ route('slider.update', $slider->sliderId) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="titleText">Title Text</label>
                                            <input class="form-control" id="titleText" name="titleText" type="text" placeholder="Title Text" value="{{ @$slider->titleText }}" required>
                                            <span class="text-danger"><b>{{  $errors->first('titleText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="mainText">Main Text</label>
                                            <input class="form-control" id="mainText" name="mainText" type="text" placeholder="Main Text" value="{{ @$slider->mainText }}">
                                            <span class="text-danger"><b>{{  $errors->first('mainText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="subText">Sub Text</label>
                                            <input class="form-control" id="subText" name="subText" type="text" placeholder="Sub Text" value="{{ @$slider->subText }}">
                                            <span class="text-danger"><b>{{  $errors->first('subText') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="imageLink">Slider Logo</label>
                                            <input class="form-control" id="imageLink" name="imageLink" type="file">
                                            <span class="text-danger"> <b>{{  $errors->first('imageLink') }}</b></span>
                                        </div>
                                        @if(isset($slider->imageLink))
                                        <div class="mb-3">
                                            <img height="100px" width="100px" src="{{ url(@$slider->imageLink) }}" alt="">
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <label for="pageLink">Page Link</label>
                                            <input class="form-control" id="pageLink" name="pageLink" type="text" placeholder="Page Link" value="{{ @$slider->pageLink }}">
                                            <span class="text-danger"><b>{{  $errors->first('pageLink') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="serial">Serial</label>
                                            <input class="form-control" id="serial" name="serial" type="number" min="1" placeholder="Serial" value="{{ @$slider->serial }}">
                                            <span class="text-danger"><b>{{  $errors->first('serial') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status">Slider Status</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="">Select Slider Status</option>
                                                <option value="active" @if($slider->status === 'active') selected @endif>Active</option>
                                                <option value="inactive" @if($slider->status === 'inactive') selected @endif>Inactive</option>
                                            </select>
                                            <span class="text-danger"> <b>{{  $errors->first('status') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('slider.show') }}">Cancel</a></button>
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
