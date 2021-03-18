@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="overflow-auto">
            <table class="table table-dark">
                <thead>
                <tr>
                    <th class="text-center">Штрихкод</th>
                    <th class="text-center">Артикул</th>
                    <th class="text-center">Номенклатура</th>
                    <th class="text-center">Номер водителя</th>
                    <th class="text-center">Вес, т</th>
                    <th class="text-center">Дата</th>
                    <th class="text-center">Статус</th>
                </tr>
                </thead>
                <tbody>
                <tr id="response__row"></tr>

                @foreach($clientOrders as $order)
                    <tr>
                        <td>{{ $order->barcode }}</td>
                        <td>{{ $order->number }}</td>
                        <td>{{ $order->body }}</td>
                        <td>{{ $order->driver_phone }}</td>
                        <td>{{ $order->weight }}</td>
                        <td>{{ $order->arrival_at }}</td>
                        <td>{{ $order->status }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $clientOrders->links() }}
            </div>
        </div>
    </div>
@endsection
