<?php

namespace App\Models;

use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    const TABLE_NAME   = 'roles';
    const SINGLE_NAME  = 'role';

    const ADMIN        = 'admin';
    const CUSTOMER     = 'customer';

    const ROLES = [
        'ADMIN'        => self::ADMIN,
        'CUSTOMER'     => self::CUSTOMER,
    ];

    const ROLE_ARRAY = [
        '1' => self::ADMIN,
        '3' => self::CUSTOMER,
    ];

    const ID    = 'id';
    const NAME  = 'name';
}
