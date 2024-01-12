<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'c_code',
        'c_description',
        'c_createdby',
        'c_updatedby',
        'c_status',
    ];
}
