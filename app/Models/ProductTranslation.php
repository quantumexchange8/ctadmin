<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasFactory;

    protected $table = 'tbl_product_translation';
    protected $foreignKey = 'product_id';

    public $timestamps = false;
    protected $fillable = ['product_title', 'product_description'];
}
