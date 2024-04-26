@extends('layouts.main')
@section('title'){{ 'Menu Create' }}@endsection
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
                        <h3>Menu Create</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Menu</li>
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
                            <form class="form-wizard" action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="menuName">Menu Name</label>
                                            <input class="form-control" id="menuName" name="menuName" type="text" placeholder="Menu Name" value="{{ old('menuName') }}" required>
                                            <span class="text-danger"><b>{{ $errors->first('menuName') }}</b></span>
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label for="parent">Parent Menu</label>
                                            <select class="form-control" name="parent" id="parent" onchange="checkParentMenu()">
                                                <option value="">Select Parent Menu</option>
                                                @foreach($menus as $menu)
                                                <option value="{{ $menu->menuId }}">{{ $menu->menuName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('parent') }}</b></span>
                                        </div> --}}
                                        <div class="mb-3">
                                            <label for="menuOrder">Menu Order</label>
                                            <input class="form-control" id="menuOrder" name="menuOrder" type="number" min="1" placeholder="Menu Order" value="{{ old('menuOrder') }}" required>
                                            <span class="text-danger"><b>{{ $errors->first('menuOrder') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="menuType">Menu Type</label>
                                            <select class="form-control" name="menuType" id="menuType" required>
                                                <option value="">Select Menu Type</option>
                                                <option value="resource">Resource</option>
                                                <option value="contact">Contact</option>
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('menuType') }}</b></span>
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label for="imageLink">Menu Image</label>
                                            <input class="form-control" id="imageLink" name="imageLink" type="file">
                                            <span class="text-danger"><b>{{ $errors->first('imageLink') }}</b></span>
                                        </div> --}}
                                        <div class="mb-3">
                                            <label for="fkPageId">Page</label>
                                            <select class="form-control" name="fkPageId" id="fkPageId">
                                                <option value="">Select Page</option>
                                                @foreach($pages as $page)
                                                    <option value="{{ $page->pageId }}">{{ $page->pageTitle }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('fkPageId') }}</b></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="">Select Menu Status</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            <span class="text-danger"><b>{{ $errors->first('status') }}</b></span>
                                        </div>
                                        <div class="text-end btn-mb">
                                            <button class="btn btn-secondary" type="button"><a class="text-white" href="{{ route('menu.show') }}">Cancel</a></button>
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
        function checkParentMenu()
        {
            let parentMenuId = $('#parent').val();
            if (parentMenuId !== '') {
                $('#fkPageId').attr('required', true)

                $.ajax({
                    type: 'POST',
                    url: "{!! route('menu.checkParentType') !!}",
                    cache: false,
                    data: {_token: "{{csrf_token()}}", 'menuId': parentMenuId},
                    success: function (data) {
                        if(data.parentMenuType !== '' || data.parentMenuType !== null) {
                            $('#menuType').empty()
                            $('#menuType').append('<option value="'+data.parentMenuType+'" selected>'+data.parentMenuType.charAt(0).toUpperCase() + data.parentMenuType.slice(1)+'</option>')
                            $('#menuType').attr('readonly', true)
                        }
                    }
                });
            } else {
                $('#fkPageId').attr('required', false)

                $('#menuType').empty()
                $('#menuType').append(
                    '<option value="">Select Menu Type</option>'
                    + '<option value="header">Header</option>'
                    + '<option value="footer">Footer</option>'
                )
                $('#menuType').attr('readonly', false)
            }
        }
    </script>
@endsection
