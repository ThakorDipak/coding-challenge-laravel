<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    const TABLE_NAME  = 'users';
    const SINGLE_NAME = 'user';

    const ID          = 'id';
    const ROLE        = 'role';

    const FIRST_NAME         = 'first_name';
    const LAST_NAME          = 'last_name';
    const EMAIL              = 'email';
    const TOKEN              = 'token';
    const IMAGE              = 'image';
    const STATUS             = 'status';
    const PASSWORD           = 'password';
    const REMEMBER_TOKEN     = 'remember_token';
    const EMAIL_VERIFIED_AT  = 'email_verified_at';
    const VERIFICATION_TOKEN = 'verification_token';

    const FILLABLE = [
        'FIRST_NAME'         => self::FIRST_NAME,
        'LAST_NAME'          => self::LAST_NAME,
        'EMAIL'              => self::EMAIL,
        'STATUS'             => self::STATUS,
        'PASSWORD'           => self::PASSWORD,
        'ROLE'               => self::ROLE,
        'REMEMBER_TOKEN'     => self::REMEMBER_TOKEN,
        'EMAIL_VERIFIED_AT'  => self::EMAIL_VERIFIED_AT,
        'VERIFICATION_TOKEN' => self::VERIFICATION_TOKEN,
    ];

    protected $fillable = self::FILLABLE;

    protected $hidden = [
        self::PASSWORD,
        self::REMEMBER_TOKEN,
        self::VERIFICATION_TOKEN
    ];

    protected $casts = [
        self::EMAIL_VERIFIED_AT => Base::DATETIME,
        // 'password' => 'hashed',

    ];

    public function setPasswordAttribute($password): void
    {
        if ($password != null) {
            $this->attributes[self::PASSWORD] = bcrypt($password);
        } else {
            $this->attributes[self::PASSWORD] = null;
        }
    }
}
