<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class WebTemplateCategoryTranslation extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tbl_web_template_category_translation';
    protected $foreignKey = 'web_template_category_id';

    public $timestamps = false;
    protected $fillable = ['web_template_category_name'];

    public function getActivitylogOptions(): LogOptions
    {
        $category_name = $this->fresh();

        return LogOptions::defaults()
            ->useLogName('category')
            ->logOnly([
                'web_template_category_name',
            ])
            ->setDescriptionForEvent(function (string $eventName) use ($category_name) {
                return Auth::user()->user_fullname . " has {$eventName} the web template category with name: {$category_name->web_template_category_name}.";
            })
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
