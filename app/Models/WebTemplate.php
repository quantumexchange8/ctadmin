<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class WebTemplate extends Model implements HasMedia, TranslatableContract
{
    use HasFactory, InteractsWithMedia, Translatable;

    protected $table = 'tbl_web_template';

    const CREATED_AT = 'web_template_created';
    const UPDATED_AT = 'web_template_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    const STATUS_NORMAL = 1;
    const STATUS_OFFER = 2;

    protected $fillable = [
        'web_template_slug', 'web_template_visibility', 'category_id', 'web_template_price', 'web_template_offer_price', 'web_template_status', 'user_id', 'is_deleted'
    ];
    public $translatedAttributes = ['web_template_name', 'web_template_description'];

    public static function get_record($search, $perpage)
    {
        $search_text = @$search['freetext'] ?? NULL;

        $query = WebTemplate::translatedIn(app()->getLocale())->where('is_deleted', 0)->whereHas('web_template_translation', function ($query) use ($search_text) {
            $freetext = explode(' ', $search_text);

            if($search_text){
                foreach($freetext as $freetexts) {
                    $query->where(function ($q) use ($freetexts) {
                        $q->where('web_template_name', 'like', '%' . $freetexts . '%');
                    });
                }
            }
        });

        $category_id = @$search['category_id'];

        if(isset($category_id)){
            $query->where('category_id', $category_id);
        }

        $web_template_visibility = @$search['web_template_visibility'];

        if(isset($web_template_visibility)){
            $query->where('web_template_visibility', $web_template_visibility);
        }

        $order_by = @$search['order_by'];

        if(isset($order_by)){
            $query->orderby('web_template_created', $order_by);
        }

        return $query->orderby('web_template_created', 'desc')->paginate($perpage);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function web_template_translation()
    {
        return $this->hasMany(WebTemplateTranslation::class, 'web_template_id', 'id');
    }

}
