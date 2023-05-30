<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'tbl_favorite';

    protected $primaryKey = 'favorite_id';
    const CREATED_AT = 'favorite_created';
    const UPDATED_AT = 'favorite_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'product_id', 'user_id', 'is_checked'
    ];

    public static function get_record($perpage)
    {
        $query = Favorite::query()->where('is_checked', 1)->where('user_id', Auth::user()->user_id);

        return $query->orderby('favorite_created', 'desc')->paginate($perpage);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
