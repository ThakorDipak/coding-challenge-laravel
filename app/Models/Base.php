<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Base extends Model
{
    use HasFactory;

    const ID               = 'id';
    const SLUG             = 'slug';
    const STATUS           = 'status';
    const DATETIME         = 'datetime';
    const DIRECTORY        = 'directory';
    const CREATED_BY       = 'created_by';
    const CREATED_AT       = 'created_at';
    const UPDATED_BY       = 'updated_by';
    const UPDATED_AT       = 'updated_at';
    const DELETED_BY       = 'deleted_by';
    const DELETED_AT       = 'deleted_at';
    const BASE_TABLE_NAME  = 'table_name';
    const BASE_SINGLE_NAME = 'single_name';
}
