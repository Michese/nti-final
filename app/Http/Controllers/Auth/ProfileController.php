<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index()
    {
        return view('auth.profile');
    }

    public function update(ChangeProfileRequest $request)
    {
        \Auth::user()->name = $request->post('name');
        \Auth::user()->phone = $request->post('phone');
        \Auth::user()->save();
        return redirect()->route('profile.index')
            ->with('success', 'Успешное изменение данных!');
    }

    public function changePasswordPage()
    {
        return view('auth.changePassword');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        \Auth::user()->password = \Hash::make($request->post('password'));
        \Auth::user()->save();
        return redirect()->route('profile.changePassword')
            ->with('success', 'Вы успешно изменили пароль!');
    }

}
