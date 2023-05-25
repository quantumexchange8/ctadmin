<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    protected $table = 'tbl_user';

    protected $primaryKey = 'user_id';

    const CREATED_AT = 'user_created';
    const UPDATED_AT = 'user_updated';

    const ADMIN_ROLE = 1;
    const USER_ROLE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'user_fullname',
        'user_email',
        'password',
        'user_gender',
        'user_address',
        'user_nationality',
        'user_phone',
        'is_deleted',
        'user_created',
        'user_updated',
        'user_role',
        'user_status',
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

    public static function get_record($search, $perpage)
    {
        $query = User::query()->where('is_deleted', 0)->where('user_role', User::USER_ROLE);

        if (@$search['freetext']) {
            $freetext = $search['freetext'];
            $query->where(function($query) use ($freetext) {
                $query->where('user_fullname', 'like', '%' . $freetext . '%')
                    ->orWhere('user_email', 'like', '%' . $freetext . '%')
                    ->orWhere('user_phone', 'like', '%' . $freetext . '%');
            });
        }

        $user_nationality = @$search['user_nationality'];

        if(isset($user_nationality)){
            $query->where('user_nationality', $user_nationality);
        }

        $user_gender = @$search['user_gender'];

        if(isset($user_gender)){
            $query->where('user_gender', $user_gender);
        }

        $user_status = @$search['user_status'];

        if(isset($user_status)){
            $query->where('user_status', $user_status);
        }

        $order_by = @$search['order_by'];

        if(isset($order_by)){
            $query->orderby('user_created', $order_by);
        }

        return $query->orderbyDesc('user_created')->paginate($perpage);

    }
}
