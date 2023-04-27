<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class WebTemplateCategory extends Model implements HasMedia, TranslatableContract
{
    use HasFactory, InteractsWithMedia, Translatable;

    protected $table = 'tbl_web_template_category';

    const CREATED_AT = 'web_template_category_created';
    const UPDATED_AT = 'web_template_category_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'web_template_category_slug', 'web_template_category_status', 'web_template_category_group', 'category_id', 'is_deleted'
    ];
    public $translatedAttributes = ['web_template_category_name'];

    public static function get_record($search, $perpage)
    {
        $search_text = @$search['freetext'] ?? NULL;

        $query = WebTemplateCategory::translatedIn(app()->getLocale())->where('is_deleted', 0)->whereHas('web_template_category_translation', function ($query) use ($search_text) {
            $freetext = explode(' ', $search_text);

            if($search_text){
                foreach($freetext as $freetexts) {
                    $query->where(function ($q) use ($freetexts) {
                        $q->where('web_template_category_name', 'like', '%' . $freetexts . '%');
                    });
                }
            }
        });

        $web_template_category_group = @$search['web_template_category_group'];

        if(isset($web_template_category_group)){
            $query->where('web_template_category_group', $web_template_category_group);
        }

        $web_template_category_status = @$search['web_template_category_status'];

        if(isset($web_template_category_status)){
            $query->where('web_template_category_status', $web_template_category_status);
        }

        $order_by = @$search['order_by'];

        if(isset($order_by)){
            $query->orderby('web_template_category_created', $order_by);
        }

        return $query->orderby('web_template_category_created', 'desc')->paginate($perpage);
    }

    public static function get_web_template_category_sel(): array
    {
        $query = WebTemplateCategory::translatedIn(app()->getLocale());

        $query->where('is_deleted', 0)->where('category_id', 2);

        return $query->orderby('web_template_category_slug')->get()->pluck('web_template_category_name', 'id')->toArray();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function web_template_category_translation()
    {
        return $this->hasMany(WebTemplateTranslation::class, 'web_template_id', 'id');
    }
}
