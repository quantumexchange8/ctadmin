<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia, TranslatableContract, Viewable
{
    use HasFactory, InteractsWithMedia, Translatable, InteractsWithViews, LogsActivity;

    protected $table = 'tbl_product';

    const CREATED_AT = 'product_created';
    const UPDATED_AT = 'product_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    const STATUS_NORMAL = 1;
    const STATUS_OFFER = 2;

    protected $fillable = [
        'product_slug', 'product_price', 'product_offer_price', 'product_status', 'product_visibility', 'category_id', 'web_template_category_id', 'pos_system_category', 'is_deleted'
    ];
    public $translatedAttributes = ['product_title', 'product_description'];

    public static function get_record($search, $perpage)
    {
        $search_text = @$search['freetext'] ?? NULL;

        $query = Product::translatedIn(app()->getLocale())->where('is_deleted', 0)->whereHas('product_translation', function ($query) use ($search_text) {
            $freetext = explode(' ', $search_text);

            if($search_text){
                foreach($freetext as $freetexts) {
                    $query->where(function ($q) use ($freetexts) {
                        $q->where('product_title', 'like', '%' . $freetexts . '%');
                    });
                }
            }
        });

        $category_id = @$search['category_id'];

        if(isset($category_id)){
            $query->where('category_id', $category_id);
        }

        $web_template_category_id = @$search['web_template_category_id'];

        if(isset($web_template_category_id)){
            $query->where('web_template_category_id', $web_template_category_id);
        }

        $pos_system_category = @$search['pos_system_category'];

        if(isset($pos_system_category)){
            $query->where('pos_system_category', $pos_system_category);
        }

        $product_status = @$search['product_status'];

        if(isset($product_status)){
            $query->where('product_status', $product_status);
        }

        $product_visibility = @$search['product_visibility'];

        if(isset($product_visibility)){
            $query->where('product_visibility', $product_visibility);
        }

        $product_visibility = @$search['product_visibility'];

        if(isset($product_visibility)){
            $query->where('product_visibility', $product_visibility);
        }

        $order_by = @$search['order_by'];

        if(isset($order_by)){
            $query->orderby('product_created', $order_by);
        }

        return $query->orderby('product_created', 'desc')->paginate($perpage);
    }

    public static function get_product_sel(): array
    {
        $query = Product::translatedIn(app()->getLocale());

        $query->where('is_deleted', 0);

        return $query->orderby('id')->get()->pluck('product_name', 'id')->toArray();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function web_template_category()
    {
        return $this->belongsTo(WebTemplateCategory::class, 'web_template_category_id', 'id');
    }

    public function pos_system_category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function product_translation()
    {
        return $this->hasMany(ProductTranslation::class, 'product_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        $productTitle = $this->product_translation()
            ->whereIn('locale', ['en', 'zh-Hans', 'zh-Hant'])
            ->pluck('product_title', 'locale')
            ->toArray();

        return LogOptions::defaults()
            ->useLogName('product')
            ->logOnly([
                'product_price', 'product_offer_price', 'product_status', 'product_visibility', 'category_id', 'web_template_category_id', 'pos_system_category', 'is_deleted'
            ])
            ->setDescriptionForEvent(function (string $eventName) use ($productTitle) {
                $language = app()->getLocale();
                $title = $productTitle[$language] ?? 'N/A';

                return Auth::user()->user_fullname . " has {$eventName} the product with title: {$title}.";
            })
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
