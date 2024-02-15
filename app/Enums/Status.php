<?php

namespace App\Enums;

class Status
{
    const PENDING       = 'pending';
    const CONFIRM       = 'confirm';
    const BLOCK         = 'block';
    const USER_STATUS   = [self::CONFIRM, self::PENDING, self::BLOCK];
}
