@extends('layouts.main')
@section('title'){{ 'Category Create' }}@endsection
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
                        <h3>Category Create</h3>
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
                            <form class="form-wizard" action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="categoryName">Category Name</label>
                                            <input class="form-control" id="categoryName" name="categoryName" type="text" placeholder="Category Name" value="{{ old('categoryName') }}" required>
                                            <span class="text-danger"><b>{{ $errors->first('categoryName') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="parent">Parent Category</label>
                                            <select class="form-control" name="parent" id="parent">
                                                <option value="">Select Parent Category</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->categoryId }}">{{ $category->categoryName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('parent') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="homeShow">Home Show</label>
                                            <input type="checkbox" id="homeShow" name="homeShow" value="1">
                                            <span class="text-danger"><b>{{ $errors->first('homeShow') }}</b></span>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="homeShowMen">Men</label>
                                                    <input type="checkbox" id="homeShowMen" name="gender" value="Men">
                                                    <span class="text-danger"><b>{{ $errors->first('homeShow.gender') }}</b></span>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="homeShowWomen">Women</label>
                                                    <input type="checkbox" id="homeShowWomen" name="gender" value="Women">
                                                    <span class="text-danger"><b>{{ $errors->first('homeShow.gender') }}</b></span>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="homeShowOthers">Others</label>
                                                    <input type="checkbox" id="homeShowOthers" name="gender" value="Others">
                                                    <span class="text-danger"><b>{{ $errors->first('homeShow.gender') }}</b></span>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="mb-3">
                                            <label for="imageLink">Category Image</label>
                                            <input class="form-control" id="imageLink" name="imageLink" type="file" required>
                                            <span class="text-danger"><b>{{ $errors->first('imageLink') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="bannerLink">Banner Image</label>
                                            <input class="form-control" id="bannerLink" name="bannerLink" type="file" required>
                                            <span class="text-danger"><b>{{ $errors->first('bannerLink') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category_serial">Category Serial</label>
                                            <input class="form-control" id="category_serial" name="category_serial" type="number" min="1" placeholder="Category Serial" value="{{ old('category_serial') }}" required>
                                            <span class="text-danger"><b>{{ $errors->first('category_serial') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('category.show') }}">Cancel</a></button>
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
