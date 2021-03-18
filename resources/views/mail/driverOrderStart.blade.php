<div>
    <h1>Обновление пароля</h1>
    <h2>
        Здравствуйте, {{ $user->name }}
    </h2>

    <p>
        Ожидаемое время прибытия на базу: {{ $order->first()->arrival_at }}
    </p>

    <table border="1">
        <thead>
            <tr>
                <th>Штрихкод</th>
                <th>Вес</th>
                <th>Номенклатура</th>
            </tr>
        </thead>
        <tbody>
        @foreach($order->cargos()->get() as $cargo)
        <tr>
            <td>{{ $cargo->cargo()->first()->barcode }}</td>
            <td>{{ $cargo->cargo()->first()->weight }}</td>
            <td>{{ $cargo->cargo()->first()->nomenclature->first()->body }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <p>
        Чтобы узнать подробнее, перейдите по ссылке: <a href="{{ route('home') }}">Ссылка</a>
    </p>
</div>
