<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyMail;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class VerifyController extends Controller
{
    public function index(string $hash)
    {
        $user = User::where('hash', '=', $hash)->first();
        if ($user) {
            Mail::send(new VerifyMail($user));
            return view('auth.verify');
        }

        return redirect()->route('auth.login.index');
    }

    public function verified(string $hash)
    {
        $user = User::where('hash', '=', $hash)->first();
        if ($user) {
            $user->email_verified_at = now();
            $user->hash = null;
            $user->save();
            return view('auth.verified');
        }

        return redirect()->route('auth.verify', $hash);
    }

}
