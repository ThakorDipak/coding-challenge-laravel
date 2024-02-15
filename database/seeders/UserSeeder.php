<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Library\Date;
use App\Enums\Status;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate([
            User::EMAIL => 'admin@admin.com',
        ], [
            User::FIRST_NAME        => 'admin',
            User::LAST_NAME         => 'admin',
            User::PASSWORD          => 'admin@123',
            User::ROLE              => Role::ADMIN,
            User::STATUS            => Status::CONFIRM,
            User::EMAIL_VERIFIED_AT => Date::getCurrent(),
        ]);
        $user->assignRole(Role::ADMIN);

        $user = User::updateOrCreate([
            User::EMAIL => 'customer@customer.com',
        ], [
            User::FIRST_NAME        => 'customer',
            User::LAST_NAME         => 'customer',
            User::PASSWORD          => 'customer@123',
            User::ROLE              => Role::CUSTOMER,
            User::STATUS            => Status::CONFIRM,
            User::EMAIL_VERIFIED_AT => Date::getCurrent(),
        ]);
        $user->assignRole(Role::CUSTOMER);
    }
}
