<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $common     = $this->common();
        $admin      = $this->admin();
        $customer   = $this->customer();
        $permissions = array_merge($common, $admin, $customer);

        foreach ($permissions as $key => $value) {
            Permission::firstOrCreate([
                'name' => $value,
            ]);
        }

        $roles = collect(Role::ROLE_ARRAY);
        $roles = $roles->sortKeys();

        foreach ($roles as $role) {
            $role = Role::firstOrCreate([
                Role::NAME => $role,
            ]);

            if ($role[Role::NAME] == Role::ADMIN) {
                $permissions = array_merge($common, $admin);
                $role->givePermissionTo($permissions);
                $role->syncPermissions($permissions);
            }

            if ($role[Role::NAME] == Role::CUSTOMER) {
                $permissions = array_merge($common, $customer);
                $role->syncPermissions($permissions);
            }
        }
    }

    public function common()
    {
        return [];
    }

    public function admin()
    {
        return [];
    }

    public function customer()
    {
        return [];
    }
}
