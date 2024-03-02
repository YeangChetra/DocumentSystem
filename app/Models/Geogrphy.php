<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Geogrphy extends Model
{
    use HasFactory;

    protected $fillable = [
        'gisId',
        'gisCode',
        'name',
        'secondary_name',
        'short_name',
        'geographyPrefixId',
        'paraent_id',
        'state'
    ];
    
}
