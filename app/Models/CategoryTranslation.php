<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use HasFactory;

    protected $table = 'tbl_category_translation';
    protected $foreignKey = 'category_id';

    public $timestamps = false;
    protected $fillable = ['category_name', 'category_caption', 'category_description'];
}
