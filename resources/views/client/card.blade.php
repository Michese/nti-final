@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="overflow-auto">
            <table class="table table-dark">
                <thead>
                <tr>
                    <th class="text-center">Артикул</th>
                    <th class="text-center">Номенклатура</th>
                    <th class="text-center">Вес, т</th>
                    <th class="text-center">Кол-во на складе</th>
                    <th class="text-center">Заказать</th>
                    <th class="text-center">Подтвердить</th>
                </tr>
                </thead>
                <tbody>
                <tr id="response__row"></tr>
                @forelse($cards as $card)
                    <tr>
                        <td class="text-center">{{ $card->nomenclature()->first()->number }}</td>
                        <td class="text-center">{{ $card->nomenclature()->first()->body }}</td>
                        <td class="text-center">{{ round($card->nomenclature()->first()->cargos()->avg('weight'), 2) }}</td>
                        <td class="text-center">{{ $card->nomenclature()->first()->cargos()->count() }}</td>
                        <td class="text-center"><input type="number" id="nomenclature{{ $card->nomenclature()->first()->nomenclature_id }}" class="form-control" name="quantity" value="{{ $card->quantity }}"></td>
                        <td class="text-center"><input type="button" class="btn btn-primary" value="Подтвердить" onclick="onSubmitHandler(this, {{$card->nomenclature()->first()->nomenclature_id}})"></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Пока нет</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                <input type="button" class="btn btn-primary" value="Подтвердить" onclick="onSubmitCardHandler(this)">
            </div>
        </div>
    </div>

    <script>
        const responseRow = document.querySelector('#response__row');

        const onSubmitHandler = (event, nomenclature_id) => {
            event.disabled = true;
            responseRow.innerHTML = ''
            let quantity = document.querySelector(`#nomenclature` + nomenclature_id).value;
            quantity = parseInt(quantity)
            axios.post("{{ route('client.order.add') }}", {
                nomenclature_id: nomenclature_id,
                quantity: quantity
            }).then(response => {
                let html = `<td colspan="6" class="text-center text-dark">${response.data}</td>`
                if (!responseRow.classList.contains('table-success')) {
                    responseRow.classList.add('table-success')
                }
                responseRow.insertAdjacentHTML('beforeend', html)
                event.disabled = false;
            }).catch(error => {
                let html = `<td colspan="6" class="text-center text-dark">Ошибка!</td>`
                if (!responseRow.classList.contains('table-danger')) {
                    responseRow.classList.add('table-danger')
                }
                responseRow.insertAdjacentHTML('beforeend', html)
                event.disabled = false;
            })
        }

        const onSubmitCardHandler = (event) => {
            event.disabled = true;
            responseRow.innerHTML = ''
            axios.post("{{ route('client.order.create') }}").then(response => {
                let html = `<td colspan="6" class="text-center text-dark">${response.data}</td>`
                responseRow.classList.toggle('table-success')
                responseRow.insertAdjacentHTML('beforeend', html)
                event.disabled = false;
            }).catch(error => {
                let html = `<td colspan="6" class="text-center text-dark">Ошибка!</td>`
                responseRow.classList.toggle('table-danger')
                responseRow.insertAdjacentHTML('beforeend', html)
                event.disabled = false;
            })
        }
    </script>

@endsection
