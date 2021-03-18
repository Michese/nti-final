<div>
    <h1>Обновление пароля</h1>
    <h2>
        Здравствуйте, {{ $user->name }}
    </h2>
    <p>
        Ваш новый пароль: {{ $password }}
    </p>
    <p>
        Для подтверждения смены пароля перейдите по ссылке: <a href="{{ route('auth.confirmedPassword', $user->hash) }}">Ссылка</a>
    </p>
</div>
