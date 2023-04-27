<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebTemplateCategoryTranslation extends Model
{
    use HasFactory;

    protected $table = 'tbl_web_template_category_translation';
    protected $foreignKey = 'web_template_category_id';

    public $timestamps = false;
    protected $fillable = ['web_template_category_name'];
}
