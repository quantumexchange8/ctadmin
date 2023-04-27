<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tbl_user';

    protected $primaryKey = 'user_id';

    const CREATED_AT = 'user_created';
    const UPDATED_AT = 'user_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'user_fullname',
        'user_email',
        'password',
        'user_nationality',
        'user_phone',
        'is_deleted',
        'user_created',
        'user_updated',
        'role_as',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
