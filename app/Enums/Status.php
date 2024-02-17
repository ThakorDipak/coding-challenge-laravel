<?php

namespace App\Enums;

class Status
{
    const PENDING       = 'pending';
    const CONFIRM       = 'confirm';
    const BLOCK         = 'block';
    const ADMIN_PENDING = 'admin_pending';

    const USER_STATUS   = [self::CONFIRM, self::PENDING, self::ADMIN_PENDING, self::BLOCK];
}
