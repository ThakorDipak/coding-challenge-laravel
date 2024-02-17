<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AuthRepository
{
    private $currentRouteName;
    public function __construct()
    {
        $this->currentRouteName = Route::currentRouteName();
    }

    public function logout(Request $user)
    {
        $user->user()->tokens()->delete();
    }

    public function setInputs(Request $request)
    {
        $first_name = $request[User::FIRST_NAME] ?? NULL;
        $last_name  = $request[User::LAST_NAME] ?? NULL;
        $email      = $request[User::EMAIL] ?? NULL;
        $status     = $request[User::STATUS] ?? NULL;

        $inputs = [
            User::FIRST_NAME         => $first_name,
            User::LAST_NAME          => $last_name,
            User::EMAIL              => $email,
            User::STATUS             => $status,
            User::VERIFICATION_TOKEN => Str::random(90),
        ];

        $request[User::PASSWORD] ? $inputs[User::PASSWORD] =  $request[User::PASSWORD] : '';

        return $inputs;
    }

    public function store($inputs): User
    {
        return User::create($inputs);
    }
}
