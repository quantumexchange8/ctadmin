<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $table = 'tbl_order';

    protected $primaryKey = 'order_id';
    const CREATED_AT = 'order_created';
    const UPDATED_AT = 'order_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'user_id', 'is_deleted', 'order_status', 'discount_amount', 'order_total_price'
    ];

    const STATUS_PENDING = 1;
    const STATUS_REPLIED = 2;

    public static function get_record($search, $perpage)
    {
        $search_text = @$search['freetext'] ?? NULL;

        $query = Order::query()->with('user')->with('product')->where('is_deleted', 0);

        $query->whereHas('user', function ($query) use ($search_text) {

            $freetext = explode(' ', $search_text);

            if($search_text){
                foreach($freetext as $freetexts) {
                    $query->where(function ($q) use ($freetexts) {
                        $q->where('user_fullname', 'like', '%' . $freetexts . '%');
                    });
                }
            }
        });

        $category_id = @$search['category_id'];

        if(isset($category_id)){
            $query->whereHas('product', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        }

        $order_status = @$search['order_status'];

        if(isset($order_status)){
            $query->where('order_status', $order_status);
        }

        return $query->orderbyDesc('order_created')->paginate($perpage);
    }

    public function getSubTotal()
    {
        return $this->order_item()
            ->sum(DB::raw("CASE WHEN order_item_offer_price = '0.00' THEN order_item_price ELSE order_item_offer_price END"));
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function order_item()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id')->where('is_deleted', 0);
    }
}
