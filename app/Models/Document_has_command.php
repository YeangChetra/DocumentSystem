<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document_has_command extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'positionprefixid',
        'position',
        'user_id',
        'commands',
        'status',
        'permission_type',
        'order_by',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
}
