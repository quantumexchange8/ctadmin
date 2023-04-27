<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class CustomMedia extends BaseMedia
{
    protected $table = 'media';

}
