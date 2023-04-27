<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia, TranslatableContract
{
    use HasFactory, InteractsWithMedia, Translatable;

    protected $table = 'tbl_category';

    const CREATED_AT = 'category_created';
    const UPDATED_AT = 'category_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'category_slug', 'category_status', 'is_deleted'
    ];
    public $translatedAttributes = ['category_name', 'category_caption', 'category_description'];

    public static function get_record($search, $perpage)
    {
        $search_text = @$search['freetext'] ?? NULL;

        $query = Category::translatedIn(app()->getLocale())->where('is_deleted', 0)->whereHas('category_translation', function ($query) use ($search_text) {
            $freetext = explode(' ', $search_text);

            if($search_text){
                foreach($freetext as $freetexts) {
                    $query->where(function ($q) use ($freetexts) {
                        $q->where('category_name', 'like', '%' . $freetexts . '%');
                    });
                }
            }
        });

        $category_status = @$search['category_status'];

        if(isset($category_status)){
            $query->where('category_status', $category_status);
        }

        return $query->orderby('category_created', 'desc')->paginate($perpage);
    }

    public static function get_category_sel(): array
    {
        $query = Category::translatedIn(app()->getLocale());

        $query->where('is_deleted', 0);

        return $query->orderby('category_slug')->get()->pluck('category_name', 'id')->toArray();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function category_translation()
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id', 'id');
    }
}
