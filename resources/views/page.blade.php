@extends('layouts.main')
@section('title'){{ @$page->pageTitle }}@endsection
@section('header.css')
    <style>

    </style>
@endsection
@section('main.content')
    <main class="main-wrapper">
        <section class="page-banner-area" style="
        background: url('{{ asset('admin/' . @$page->background_image)}}');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    ">
        <div class="overlay pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="font-itcbahuas text-white text-center mb-3">{{ @$page->pageTitle }}</h3>
            </div>
            </div>
        </div>
        </div>
    </section>
    <section class="about-adv-mad pt-60 pb-60">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-5 mb-3 mb-md-0">
              @isset($page->image)
              <img src="{{ url('admin/'.@$page->image) }}" alt="about" class="img-fluid rounded">
              @endisset
            </div>
            <div class="col-md-7 mb-3 mb-md-0">
              <h5 class="font-itcbahuas text-orange mb-3">{{ @$page->pageTitle }}</h5>
              <h3 class="mb-3">{!! @$page->details !!}</h3>                
            </div>
          </div>
        </div>
      </section>
    @endsection
    @section('footer.js')
    <script>

    </script>
@endsection
