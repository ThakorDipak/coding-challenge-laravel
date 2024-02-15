<?php

use App\Models\Base;
use App\Models\Role;
use App\Models\User;
use App\Enums\Status;
use App\Library\GlobalMigration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string(User::FIRST_NAME);
            $table->string(User::LAST_NAME);
            $table->enum(User::ROLE, [Role::ADMIN, Role::CUSTOMER])->default(Role::CUSTOMER);
            $table->string(User::EMAIL)->unique();
            $table->string(User::PASSWORD)->nullable();
            $table->string(User::IMAGE)->nullable();
            $table->enum(Base::STATUS, Status::USER_STATUS)->default(Status::PENDING);
            $table->timestamp(User::EMAIL_VERIFIED_AT)->nullable();
            $table->string(User::VERIFICATION_TOKEN, 200)->nullable();
            $table->rememberToken();
            GlobalMigration::commonColumn($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
