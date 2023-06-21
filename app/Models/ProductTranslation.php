<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductTranslation extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tbl_product_translation';
    protected $foreignKey = 'product_id';

    public $timestamps = false;
    protected $fillable = ['product_title', 'product_description'];

    public function getActivitylogOptions(): LogOptions
    {
        $product_title = $this->fresh();

        return LogOptions::defaults()
            ->useLogName('product')
            ->logOnly([
                'product_title'
            ])
            ->setDescriptionForEvent(function (string $eventName) use ($product_title) {
                return Auth::user()->user_fullname . " has {$eventName} the product with title: {$product_title->product_title}.";
            })
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
