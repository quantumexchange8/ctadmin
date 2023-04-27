<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryFile extends Model
{
    use HasFactory;

    protected $table = 'tbl_temporary_file';

    protected $primaryKey = 'temporary_file_id';

    const CREATED_AT = 'temporary_file_created';
    const UPDATED_AT = 'temporary_file_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'temporary_file_folder', 'temporary_file_name',
    ];
}
