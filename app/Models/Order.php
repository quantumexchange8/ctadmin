<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model implements HasMedia
{
    use HasFactory,  InteractsWithMedia, LogsActivity;

    protected $table = 'tbl_order';

    protected $primaryKey = 'order_id';
    const CREATED_AT = 'order_created';
    const UPDATED_AT = 'order_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'order_number', 'quotation_number', 'invoice_number', 'receipt_number', 'order_total_price', 'user_id', 'is_deleted', 'order_status', 'discount_amount', 'order_completed_at'
    ];

    const STATUS_PROCESSING = 1;
    const STATUS_PENDING = 2;
    const STATUS_AWAITING = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_CANCELLED = 5;

    protected static $logAttributes = ['order_status'];

    public static function get_record($search, $perpage)
    {
        $search_text = @$search['freetext'] ?? NULL;

        $query = Order::query()->with('user')->where('is_deleted', 0);

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

    public static function get_order_status_sel()
    {
        return $orderStatuses = [
            Order::STATUS_PROCESSING => 'Processing',
            Order::STATUS_PENDING => 'Pending',
            Order::STATUS_AWAITING => 'Awaiting Payment',
            Order::STATUS_COMPLETED => 'Completed',
            Order::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public function getSubTotal()
    {
        return $this->order_item()
            ->sum(DB::raw("CASE WHEN order_item_offer_price = '0.00' THEN order_item_price ELSE order_item_offer_price END"));
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function order_item()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id')->where('is_deleted', 0);
    }

    public function getActivitylogOptions(): LogOptions
    {
        $order = $this->fresh();

        return LogOptions::defaults()
            ->useLogName('order')
            ->logOnly([
                'order_total_price', 'is_deleted', 'discount_amount', 'order_completed_at'
            ])
            ->setDescriptionForEvent(function (string $eventName) use ($order) {
                return Auth::user()->user_fullname . " has {$eventName} Order Number {$order->order_number}.";
            })
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
