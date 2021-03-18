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
                @forelse($nomenclatures as $nomenclature)
                    <tr>
                        <td class="text-center">{{ $nomenclature->number }}</td>
                        <td class="text-center">{{ $nomenclature->body }}</td>
                        <td class="text-center">{{ round($nomenclature->cargos()->avg('weight'), 2) }}</td>
                        <td class="text-center">{{ $nomenclature->cargos()->count() }}</td>
                        <td class="text-center"><input type="number" id="nomenclature{{ $nomenclature->nomenclature_id }}" class="form-control" name="quantity" value="0"></td>
                        <td class="text-center"><input type="button" class="btn btn-primary" value="Подтвердить" onclick="onSubmitHandler({{$nomenclature->nomenclature_id}})"></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Пока нет</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $nomenclatures->links() }}
            </div>
        </div>
    </div>

    <script>
        const responseRow = document.querySelector('#response__row');

        const onSubmitHandler = (nomenclature_id) => {
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
            }).catch(error => {
                let html = `<td colspan="6" class="text-center text-dark">Ошибка!</td>`
                if (!responseRow.classList.contains('table-danger')) {
                    responseRow.classList.add('table-danger')
                }
                responseRow.insertAdjacentHTML('beforeend', html)
            })
        }
    </script>

@endsection
