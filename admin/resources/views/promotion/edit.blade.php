@extends('layouts.main')
@section('title'){{ 'Promotion Edit' }}@endsection
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
                        <h3>Promotion Edit</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Promotion</li>
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
                            <form class="form-wizard" action="{{ route('promotion.update', $promotion->promotionId) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="promotionTitle">Promotion Title</label>
                                            <input class="form-control" id="promotionTitle" name="promotionTitle" type="text" placeholder="Promotion title" value="{{ @$promotion->promotionTitle }}" required>
                                            <span class="text-danger"><b>{{ $errors->first('promotionTitle') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="promotionCode">Promotion Code</label>
                                            <input class="form-control" id="promotionCode" name="promotionCode" type="text" placeholder="Promotion Code" value="{{ @$promotion->promotionCode }}" required>
                                            <span class="text-danger"><b>{{ $errors->first('promotionCode') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="startDate">Start Date</label>
                                            <input class="form-control" id="" name="startDate" type="datetime-local" value="{{ @$promotion->startDate }}" required>
                                            <span class="text-danger"><b>{{ $errors->first('startDate') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="endDate">End Date</label>
                                            <input class="form-control" id="" name="endDate" type="datetime-local" value="{{ @$promotion->endDate }}" required>
                                            <span class="text-danger"><b>{{ $errors->first('endDate') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="amount">Amount</label>
                                            <input class="form-control" id="amount" name="amount" type="number" min="1" step="0.01" placeholder="Amount" value="{{ @$promotion->amount }}">
                                            <span class="text-danger"><b>{{ $errors->first('amount') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="percentage">Percentage</label>
                                            <input class="form-control" id="percentage" name="percentage" type="number" min="1" step="0.01" placeholder="Percentage" value="{{ @$promotion->percentage }}">
                                            <span class="text-danger"><b>{{ $errors->first('percentage') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="useLimit">Use Limit</label>
                                            <input class="form-control" id="useLimit" name="useLimit" type="number" min="1" placeholder="Use Limit" value="{{ @$promotion->useLimit }}" required>
                                            <span class="text-danger"><b>{{ $errors->first('useLimit') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="">Select Status</option>
                                                <option value="active" @if($promotion->status === 'active') selected @endif>Active</option>
                                                <option value="inactive" @if($promotion->status === 'inactive') selected @endif>Inactive</option>
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('status') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('promotion.show') }}">Cancel</a></button>
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
