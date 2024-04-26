@extends('layouts.main')
@section('title'){{ 'Variation Create' }}@endsection
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
                        <h3>Variation Create</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Variation</li>
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
                            <form class="form-wizard" action="{{ route('variation.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="variationType">Variation Type</label>
                                            <select class="form-control" name="variationType" id="variationType" onchange="changeValueDiv()" required>
                                                <option value="">Select Variation Type</option>
                                                <option value="color">Color</option>
                                                <option value="size">Size</option>
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('variationType') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="selectionType">Selection Type</label>
                                            <select class="form-control" name="selectionType" id="selectionType" required>
                                                <option value="">Select Selection Type</option>
                                                <option value="checkbox">Checkbox</option>
                                                <option value="dropdown">Dropdown</option>
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('selectionType') }}</b></span>
                                        </div>
                                        <div class="mb-3" id="colorValueDiv">
                                            <label for="color">Variation Value</label>
                                            <input type="color" class="form-control" name="color" id="color" value="">
                                            <span class="text-danger"><b>{{ $errors->first('color') }}</b></span>
                                        </div>
                                        <div class="mb-3" id="sizeValueDiv">
                                            <label for="size">Variation Value</label>
                                            <input type="text" class="form-control" name="size" id="size" placeholder="Size Value" value="">
                                            <span class="text-danger"><b>{{ $errors->first('size') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('variation.show') }}">Cancel</a></button>
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
        $(document).ready(function (){
            changeValueDiv()
        })

        function changeValueDiv()
        {
            if ($('#variationType').val() === 'color') {
                $('#sizeValueDiv').hide()
                $('#size').val('')
                $('#colorValueDiv').show()
            } else if ($('#variationType').val() === 'size') {
                $('#sizeValueDiv').show()
                $('#color').val('')
                $('#colorValueDiv').hide()
            } else {
                $('#size').val('')
                $('#sizeValueDiv').hide()
                $('#color').val('')
                $('#colorValueDiv').hide()
            }
        }
    </script>
@endsection
