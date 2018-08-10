<?php

namespace App\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function auth(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|min:6|max:16'
        ]);

        $attempt = Auth::attempt([
            'email'    => $request->post('email'),
            'password' => $request->post('password'),
        ]);

        return $attempt
            ? $this->setResponse(Auth::user(), ['full' => true, 'token' => true], false)
            : abort(401);
    }

    public function checkToken()
    {
        return Auth::check()
            ? $this->setResponse(Auth::user(), ['full' => true, 'token' => true], false)
            : abort(401);
    }
}
