<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
use App\Mail\VerifyMail;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;
use Str;

class LoginController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function sign_in(Request $request)
    {
        if (\Auth::attempt(['email' => Str::lower($request->post('email')), 'password' => $request->post('password')])) {
            return redirect()->route('home');
        }

        return redirect()->route('auth.login.index')->with(['error' => 'Неверный email или пароль!']);
    }

    public function logout()
    {
        \Auth::logout();
        return redirect()->route('home');
    }

    public function forgotPasswordPage(Request $request)
    {
        return view("auth.forgotPassword");
    }

    public function forgotPassword(Request $request)
    {

        $user = User::where('email', '=', $request->post('email'))->first();
        if($user && \Gate::denies(env('IS_ADMIN'),$user)) {

            $newPassword = Str::random(16);
            $user->hash = \Hash::make($newPassword);
            $user->save();
            Mail::send(new ForgotPasswordMail($user, $newPassword));
            return redirect()->route('auth.forgotPassword')->with("success", "На вашу почту пришло письмо с новым паролем!");
        }
        return redirect()->route('auth.forgotPassword')->with("error", "Такая почта не зарегистрирована!");
    }

    public function confirmedPassword(string $hash)
    {

        $user = User::where('hash', '=', $hash)->first();
        if($user && \Gate::denies(env('IS_ADMIN'),$user)) {
            $user->password = $hash;
            $user->hash = null;
            $user->save();
            return view('auth.confirmedPassword');
        }
        return redirect()->route('home');
    }


}
