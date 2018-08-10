<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends ApiController
{
    public function show($userId = 0)
    {

        $users = User::with('role');
        $users = $userId ? $users->findOrFail($userId) : $users->get();

        return $this->setResponse($users, [],true);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|string|max:100',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:16|confirmed',
        ]);

        $user           = new User();
        $user->name     = $request->post('name');
        $user->email    = $request->post('email');
        $user->password = bcrypt($request->post('password'));

        return $user->save()
            ? $this->setResponse($user, [], 201)
            : abort(500);
    }

    public function update(Request $request, $userId)
    {
        /** @var User $user */
        $user = $this->permissionsModel = User::findOrFail($userId);

        $this->validate($request, [
            'name'      => "string|max:255",
            'email'    => "string|email|max:255|unique:users,email,{$user->id}",
            'password' => "sometimes|string|min:6|max:16|confirmed",
        ]);

        $user->fio = $request->post('fio', $user->fio);
        $user->email = $request->post('email', $user->email);

        if ($request->has('password')) {
            $user->password = bcrypt($request->post('password'));
        }

        return $user->save()
            ? $this->setResponse($user)
            : abort(500);
    }

    public function block($userId)
    {
        /** @var User $user */
        $user = User::findOrFail($userId);
        $user->api_token = '';

        return $user->save()
            ? $this->setResponse($user)
            : abort(500);
    }

    public function unblock($userId)
    {
        /** @var User $user */
        $user = User::findOrFail($userId);
        $user->api_token = str_random(60);

        return $user->save()
            ? $this->setResponse($user)
            : abort(500);
    }

    public function destroy($userId)
    {
        /** @var User $user */
        $user = User::findOrFail($userId);

        return $user->delete()
            ? $this->setResponse($this->permissionsModel->id)
            : abort(500);
    }
}