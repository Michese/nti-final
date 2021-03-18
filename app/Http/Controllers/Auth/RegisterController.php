<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Testing\Fluent\Concerns\Has;
use Str;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function create(RegisterRequest $request)
    {
        $newUser = new User();
        $newUser->fill([
            'name' => $request->post('name'),
            'email' => Str::lower($request->post('email')),
            'code' => (is_null($request->post('code'))) ? \Str::upper(\Str::random(11)) : $request->post('code'),
            'phone' => $request->post('phone'),
            'password' => \Hash::make($request->post('password'))
        ]);

        $newUser->hash = \Hash::make($request->post('email'));
        $newUser->save();

        if ($newUser) {
            return redirect()->route('auth.verify', $newUser->hash);
        }

        return redirect()->route('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
