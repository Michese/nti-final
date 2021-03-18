<?php

namespace App\Http\Middleware;

use App\Mail\VerifyMail;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Mail;

class CheckVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::check()) {
            if (is_null(\Auth::user()->email_verified_at)) {
                $hash = \Auth::user()->hash;
                \Auth::logout();
                return redirect()->route('auth.verify', $hash);
            }
        }
        else {
            $user = User::where('email', '=', $request->post('email'))->first();
            if ($user && is_null($user->email_verified_at)) {
                return redirect()->route('auth.verify', $user->hash);
            }
        }

        return $next($request);
    }
}
