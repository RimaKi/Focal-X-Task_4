<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AddUserRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;
use Exception;


class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return array[]
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->only('name', 'email', 'password');
        $user = (new UserService())->StoreUser($data, 'user');
        $token = auth()->attempt($data);
        return ["user" => [...$user->toArray(), ...["role" => $user->getRoleNames()->first(),
            "token" => $token]]];
    }


    /**
     * @param LoginRequest $request
     * @return array[]
     * @throws Exception
     */
    public function login(LoginRequest $request)
    {
        $data = $request->only('email', "password");

        if (!$token = auth()->attempt($data)) {
            throw new Exception('wrong email or password');
        }
        $user = auth()->user();
        return ["user" => [...$user->toArray(), ...["role" => $user->getRoleNames()->first(),
            "token" => $token]]];
    }

    /**
     * @return string
     */
    public function logout()
    {
        auth()->logout();
        return 'Successfully logged out';
    }

    /**
     * @return array[]
     */
    public function profile()
    {
        $user = auth()->user();
        return ['user' => [...$user->toArray(), ...["role" => $user->getRoleNames()->first()]]];
    }

    /**
     *  add user with role (EX: author , admin ) by admin
     * @param AddUserRequest $request
     * @return array[]
     */
    public function addUser(AddUserRequest $request)
    {
        $data = $request->only('name', 'email', 'password');
        $user = (new UserService())->StoreUser($data, $request->role);
        return ['user' => [...$user->toArray(), ...["role" => $user->getRoleNames()->first()]]];
    }

}
