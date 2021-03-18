<div>
    <h1>Здравствуйте, {{ $user->name }}!</h1>
    <p>
        Если Вы хотите подтвердить регистрацию на платформе {{ env('APP_URL') }}, перейдите по ссылке: <a href="{{ route('auth.verified', $user->hash) }}">Подтверждение регистрации</a>
    </p>
    <p>
        Если Вы не регистрировались на платформе {{ env('APP_URL') }}, проигнорируйте это письмо!
    </p>
</div>