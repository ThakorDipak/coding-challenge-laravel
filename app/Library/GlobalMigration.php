<?php

namespace App\Library;

use App\Models\Base;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;

class GlobalMigration
{
    public static function commonColumn(Blueprint $table, $soft_delete = true, $deleted_by = false)
    {

        if ($soft_delete && $deleted_by) {
            $table->unsignedBigInteger(Base::DELETED_BY)->nullable();
            $table->foreign(Base::DELETED_BY)->on(User::TABLE_NAME)->references(User::ID)->cascadeOnDelete();
        }

        $table->timestamps();
        if ($soft_delete) {
            $table->softDeletes();
        }
    }
}
