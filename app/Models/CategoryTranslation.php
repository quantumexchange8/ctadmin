<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CategoryTranslation extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tbl_category_translation';
    protected $foreignKey = 'category_id';

    public $timestamps = false;
    protected $fillable = ['category_name', 'category_caption', 'category_description'];

    public function getActivitylogOptions(): LogOptions
    {
        $category_name = $this->fresh();

        return LogOptions::defaults()
            ->useLogName('category')
            ->logOnly([
                'category_name', 'category_caption', 'category_description'
            ])
            ->setDescriptionForEvent(function (string $eventName) use ($category_name) {
                return Auth::user()->user_fullname . " has {$eventName} the category with name: {$category_name->category_name}.";
            })
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
