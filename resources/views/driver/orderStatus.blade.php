@extends('layouts.app')

@section('content')
    <div class="container">


        @if (\Auth::user()->driverOrders()->first())
            <p> <strong>Статус:</strong> {{ \Auth::user()->driverOrders()->first()->status()->first()->title }}</p>
            <p> <strong>Время прибытия:</strong> {{ \Auth::user()->driverOrders()->first()->arrival_at }}</p>
        @endif


        <div class="overflow-auto">
            <table class="table table-dark">
                <thead>
                <tr>
                    <th class="text-center">Штрихкод</th>
                    <th class="text-center">Артикул</th>
                    <th class="text-center">Номенклатура</th>
                    <th class="text-center">Вес, т</th>
                    <th class="text-center">Погрузка</th>
                </tr>
                </thead>
                <tbody>
                @if(session('success'))
                    <div class="row justify-content-center">
                        <div class="alert alert-success mt-2 text-center" role="alert">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="row justify-content-center">
                        <div class="alert alert-danger mt-2 text-center" role="alert">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @foreach($driverOrders as $order)
                    @foreach($order->first()->cargos()->get() as $cargo)
                        <tr>
                            <td class="text-center">{{ $cargo->cargo()->first()->barcode }}</td>
                            <td class="text-center">{{ $cargo->cargo()->first()->nomenclature->first()->number }}</td>
                            <td class="text-center">{{ $cargo->cargo()->first()->nomenclature->first()->body }}</td>
                            <td class="text-center">{{ $cargo->cargo()->first()->weight }}</td>
                            <td class="text-center"> @if ($cargo->first()->hasShip == 1) погружен @else не погружен @endif </td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $driverOrders->links() }}
            </div>
        </div>
    </div>
@endsection
