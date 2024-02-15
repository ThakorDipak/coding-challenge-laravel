<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    const TABLE_NAME  = 'permissions';

    const SINGLE_NAME = 'permission';
}
