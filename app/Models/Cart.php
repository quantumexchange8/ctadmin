<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'tbl_cart';

    protected $primaryKey = 'cart_id';
    const CREATED_AT = 'cart_created';
    const UPDATED_AT = 'cart_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'cart_name', 'cart_email', 'cart_phone', 'cart_address', 'cart_quantity', 'cart_price', 'product_id', 'user_id', 'is_deleted'
    ];

    public static function get_record($perpage)
    {
        $query = Cart::query()->where('is_deleted', 0)->where('user_id', Auth::user()->user_id);

        return $query->orderby('cart_created', 'desc')->paginate($perpage);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
