<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document_file extends Model
{
    use HasFactory;
    
    protected $table="document_has_files";

    protected $fillable = [
        'document_id',
        'displaytitle',
        'filename',
        'file_type',
        'status',
        'created_by',
        'deleted_by',
        'deleted_at',
    ];
}
