@extends('layouts.main')
@section('title'){{ 'Banner Edit' }}@endsection
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
                        <h3>Banner Edit</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Banner</li>
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
                            <form class="form-wizard" action="{{ route('banner.update', $banner->bannerId) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="bannerTitle">Banner Title</label>
                                            <input class="form-control" id="bannerTitle" name="bannerTitle" type="text" placeholder="Banner Title" value="{{ @$banner->bannerTitle }}">
                                            <span class="text-danger"><b>{{  $errors->first('bannerTitle') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="imageLink">Banner Image</label>
                                            <input class="form-control" id="imageLink" name="imageLink" type="file">
                                            <span class="text-danger"> <b>{{  $errors->first('imageLink') }}</b></span>
                                        </div>
                                        @if(isset($banner->imageLink))
                                        <div class="mb-3">
                                            <img height="100px" width="100px" src="{{ url(@$banner->imageLink) }}" alt="">
                                        </div>
                                        @endif
                              
                                        {{-- <div class="mb-3">
                                            <label for="type">Banner Type</label>
                                            <input class="form-control" id="type" name="type" type="text" placeholder="Banner Type" value="{{ @$banner->type }}">
                                            <span class="text-danger"> <b>{{  $errors->first('type') }}</b></span>
                                        </div> --}}
                                        <div class="mb-3">
                                            <label for="status">Banner Type</label>
                                            <select class="form-control" name="type" id="" required>
                                                <option value="">Select Banner Type</option>
                                                <option value="top" @if($banner->type === 'top') selected @endif>Top</option>
                                                <option value="sale" @if($banner->type === 'sale') selected @endif>Sale</option>
                                                <option value="promo" @if($banner->type === 'promo') selected @endif>Promo</option>
                                                <option value="saving" @if($banner->type === 'saving') selected @endif>Saving</option>
                                                <option value="payday" @if($banner->type === 'payday') selected @endif>Pay Day</option>   
                                              
                                            </select>
                                            <span class="text-danger"> <b>{{  $errors->first('type') }}</b></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="type">Banner Description 1</label>                                           
                                           <textarea class="form-control" id="bannerDesc1" name="banner_description_1" placeholder="bannerDesc1">{{$banner->banner_description_1}}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('banner_description_1') }}</b></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="type">Banner Description 2</label>                                           
                                           <textarea class="form-control" id="bannerDesc2" name="banner_description_2" placeholder="bannerDesc2">{{$banner->banner_description_2}}</textarea>
                                            <span class="text-danger"><b>{{  $errors->first('banner_description_2') }}</b></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status">Banner Status</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="">Select Banner Status</option>
                                                <option value="active" @if($banner->status === 'active') selected @endif>Active</option>
                                                <option value="inactive" @if($banner->status === 'inactive') selected @endif>Inactive</option>
                                            </select>
                                            <span class="text-danger"> <b>{{  $errors->first('status') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fkPromotionId">Promotion</label>
                                            <select class="form-control" name="fkPromotionId" id="fkPromotionId">
                                                <option value="">Select Promotion</option>
                                                @foreach($promotions as $promotion)
                                                    <option value="{{ $promotion->promotionId }}" @if(@$banner->fkPromotionId === $promotion->promotionId) selected @endif>{{ $promotion->promotionCode }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"> <b>{{  $errors->first('fkPromotionId') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="pageLink">Page Link</label>
                                            <input class="form-control" id="pageLink" name="pageLink" type="text" placeholder="Page Link" value="{{ @$banner->pageLink }}">
                                            <span class="text-danger"><b>{{  $errors->first('pageLink') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('banner.show') }}">Cancel</a></button>
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
