@extends('layouts.app')

@section('title', 'KamiDengar')

@section('content')
<div class="site-index mt">
    <div class="bg-transparent rounded-3">
        <div class="container-fluid pt-3 pb-5 text-center">
            <h1 class="display-4 mb-3">Terima kasih atas rasa kepedulian pada perasaanmu</h1>

            <img src="{{ asset('images/Heros.png') }}" alt="Ilustrasi Emosi"
                class="img-fluid rounded mx-auto d-block" style="max-width: 450px; height: auto; margin-bottom: 30px;">

            <p class="fs-5 fw-light mb-4">
                Kamu sudah sampai sini, yuk jelajahi perasaanmu bersama-ku 😉
                <br> Apa yang bisa aku bantu?
            </p>

            <div class="d-flex justify-content-center gap-4 mt-3">
                <a class="btn btn-lg text-white btn-cta2" href="{{ route('disclaimer') }}">
                    Uji Kondisi Kesehatan Mentalmu
                </a>
                <a class="btn btn-lg text-black px-4 py-3"
                    style="background-color: #ffffff; border: 2px solid #E76F51; border-radius: 999px;"
                    href="https://www.yiiframework.com">
                    Konsultasi Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<div class="body-content mt-5">
    <div class="row">
        <div class="col-lg-4">
            <h2>Heading</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
            <p><a class="btn btn-outline-secondary" href="#">Heading</a></p>
        </div>
        <div class="col-lg-4">
            <h2>Heading</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
            <p><a class="btn btn-outline-secondary" href="#">Heading</a></p>
        </div>
        <div class="col-lg-4">
            <h2>Heading</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
            <p><a class="btn btn-outline-secondary" href="#">Heading</a></p>
        </div>
    </div>
</div>
@endsection
