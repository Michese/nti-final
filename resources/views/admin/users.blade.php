@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="overflow-auto">
            <table class="table table-dark">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>email</th>
                    <th>Телефон</th>
                    <th>Должность</th>
                </tr>
                </thead>
                <tbody>
                <tr id="response__row"></tr>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }} @if(!is_null($user->email_verified_at)) &#10004; @endif</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            <div class="input-group mb-3">
                                <select class="custom-select custom-select-sm" id="inputGroupSelect01"
                                        onchange="onChangeHandler({{ $user->id }}, event.target.value)">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->role_id }}"
                                                @if($role->role_id == $user->role_id) selected @endif>{{ $role->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Пока нет</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    <script>
        const responseRow = document.querySelector('#response__row');

        const onChangeHandler = (user_id, role_id) => {
            responseRow.innerHTML = ''
            role_id = parseInt(role_id)
            console.log(user_id, role_id)
            axios.put("{{ route('admin.users.changeRole') }}", {
                user_id: user_id,
                role_id: role_id
            }).then(response => {
                let html = `<td colspan="4" class="text-center text-dark">${response.data}</td>`
                responseRow.classList.toggle('table-success')
                responseRow.insertAdjacentHTML('beforeend', html)
            }).catch(error => {
                let html = `<td colspan="4" class="text-center text-dark">Ошибка!</td>`
                responseRow.classList.toggle('table-danger')
                responseRow.insertAdjacentHTML('beforeend', html)
            })
        }
    </script>
@endsection
