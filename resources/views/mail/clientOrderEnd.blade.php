<div>
    <h1>Подтверждение заказа</h1>
    <h2>
        Здравствуйте, {{ $user->name }}
    </h2>
    <p>
        Ваш заказ выполнен!
    </p>

    @if (Route::has('client.orderStatus'))
        <p>
            Чтобы узнать подробнее, перейдите по ссылке: <a href="{{ route('client.orderStatus') }}">Ссылка</a>
        </p>
    @endif
</div>
