<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebTemplateTranslation extends Model
{
    use HasFactory;

    protected $table = 'tbl_web_template_translation';
    protected $foreignKey = 'web_template_id';

    public $timestamps = false;
    protected $fillable = ['web_template_name', 'web_template_description'];
}
