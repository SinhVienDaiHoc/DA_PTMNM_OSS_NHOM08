@extends('layouts.app')
@section('title','HomePage')

@section('content')

<section class="py-3">
  <div class="container container-wide hero">

  
    <div id="heroCarousel"
         class="carousel slide"
         data-bs-ride="carousel"
         data-bs-interval="2000">  {{--tốc độ chuyển trang--}}
    <div class="carousel-inner">

        {{-- Slide 1 --}}
        <div class="carousel-item active">
          <img src="{{ asset('images/banner.png') }}"
               class="d-block w-100"
               alt="Banner 1">
        </div>

        {{-- Slide 2 --}}
        <div class="carousel-item">
          <img src="{{ asset('images/banner2.png') }}"
               class="d-block w-100"
               alt="Banner 2">
        </div>

        {{-- Slide 3 --}}
        <div class="carousel-item">
          <img src="{{ asset('images/banner3.png') }}"
               class="d-block w-100"
               alt="Banner 3">
        </div>
        {{-- Slide 4 --}}
        <div class="carousel-item">
          <img src="{{ asset('images/banner4.png') }}"
               class="d-block w-100"
               alt="Banner 4">
        </div>

      </div>

      {{-- Nút control trái/phải --}}
      <button class="carousel-control-prev" type="button"
              data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>

      <button class="carousel-control-next" type="button"
              data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
      

    </div>

  </div>
</section>

@endsection

