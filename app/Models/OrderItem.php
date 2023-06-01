<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'tbl_order_item';

    protected $primaryKey = 'order_item_id';
    const CREATED_AT = 'order_item_created';
    const UPDATED_AT = 'order_item_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'order_item_name', 'order_item_description', 'order_item_price', 'order_item_offer_price', 'order_id', 'product_id', 'order_item_quantity', 'is_deleted',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
