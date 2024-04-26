@extends('layouts.main')
@section('title'){{ 'Category Edit' }}@endsection
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
                        <h3>Category Edit</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Category</li>
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
                            <form class="form-wizard" action="{{ route('category.update', $category->categoryId) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="categoryName">Category Name</label>
                                            <input class="form-control" id="categoryName" name="categoryName" type="text" placeholder="Category Name" value="{{ @$category->categoryName }}" required>
                                            <span class="text-danger"> <b>{{  $errors->first('categoryName') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="parent">Parent Category</label>
                                            <select class="form-control" name="parent" id="parent">
                                                <option value="">Select Parent Category</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->categoryId }}" @if(@$category->parent === $cat->categoryId) selected @endif>{{ $cat->categoryName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"> <b>{{  $errors->first('parent') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeShow">Home Show</label>
                                            <input type="checkbox" id="homeShow" name="homeShow" value="1" @if(@$category->homeShow === 1) checked @endif>
                                            <span class="text-danger"> <b>{{  $errors->first('homeShow') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="imageLink">Category Image</label>
                                            <input class="form-control" id="imageLink" name="imageLink" type="file">
                                            <span class="text-danger"> <b>{{  $errors->first('imageLink') }}</b></span>
                                        </div>
                                        @if(isset($category->imageLink))
                                        <div class="mb-3">
                                            <img height="100px" width="100px" src="{{ url(@$category->imageLink) }}" alt="">
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <label for="bannerLink">Banner Image</label>
                                            <input class="form-control" id="bannerLink" name="bannerLink" type="file">
                                            <span class="text-danger"> <b>{{  $errors->first('bannerLink') }}</b></span>
                                        </div>
                                        @if(isset($category->bannerLink))
                                        <div class="mb-3">
                                            <img height="100px" width="100px" src="{{ url(@$category->bannerLink) }}" alt="">
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <label for="category_serial">Category Serial</label>
                                            <input class="form-control" id="category_serial" name="category_serial" type="number" min="1" placeholder="Category Serial" value="{{ @$category->category_serial }}" required>
                                            <span class="text-danger"> <b>{{  $errors->first('category_serial') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('category.show') }}">Cancel</a></button>
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
