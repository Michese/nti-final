@extends('layouts.app')

@section('content')

    <div id="home">
        <div class="slide1"></div>

        <div class="slide2"></div>

        <div class="slide3">
            <div class="slide3__body d-flex flex-column align-items-center">
                <h2>HopeOnly</h2>

                <div class="d-flex flex-column flex-sm-row align-items-center align-content-center justify-content-center justify-content-between">
                    <div class="col-11 col-sm-6">
                        <img class="rounded-circle" src="{{ asset('storage/home/student1.jpg') }}" alt="student">
                        <h4 class="text-nowrap text-center">Куликов Вадим</h4>
                        <p class="text-nowrap text-center">разработчик</p>
                    </div>
                    <div class="col-11 col-sm-6">
                        <img class="rounded-circle" src="{{ asset('storage/home/student2.jpg') }}" alt="student">
                        <h4 class="text-nowrap text-center">Зубкова Надежда</h4>
                        <p class="text-nowrap text-center">аналитик</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
