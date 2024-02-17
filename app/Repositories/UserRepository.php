<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;

class UserRepository
{
    public function index(Request $request)
    {
        $search = $request->search;
        $userQuery = User::query()->latest();
        $userQuery->where(User::ROLE, Role::CUSTOMER);
        $userQuery->where(function ($userQuery) use ($search) {
            $userQuery->where(User::FIRST_NAME, 'like', "%{$search}%")
                ->orWhere(User::LAST_NAME, 'like', "%{$search}%")
                ->orWhere(User::EMAIL, 'like', "%{$search}%")
                ->orWhere(User::STATUS, 'like', "%{$search}%");
        });
        $users = $userQuery->paginate(20);
        return $users;
    }

    public function getUserStoreInputs(UpdateUserRequest $request)
    {
        $password = $request[User::PASSWORD];
        return [
            User::PASSWORD => $password,
            ...$this->setInputs($request)
        ];
    }

    public function getUserUpdateInputs(UpdateUserRequest $request)
    {
        return $this->setInputs($request);
    }

    public function setInputs(Request $request)
    {
        $first_name = $request[User::FIRST_NAME];
        $last_name  = $request[User::LAST_NAME];
        $email      = $request[User::EMAIL];
        $status     = $request[User::STATUS];

        $inputs = [
            User::FIRST_NAME  => $first_name,
            User::LAST_NAME   => $last_name,
            User::EMAIL       => $email,
            User::STATUS      => $status,
        ];
        return $inputs;
    }

    public function update(User $user, $inputs): User
    {
        $user->update($inputs);
        return $user;
    }

    public function bulkDestroy(Request $request)
    {
        User::whereIn(User::ID, $request->destroy_ids)->delete();
    }

    public function destroy(User $user): User
    {
        $user->delete();
        return $user;
    }
}
