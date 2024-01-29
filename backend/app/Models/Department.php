<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'd_code',
        'd_description',
        'd_email',
        'd_createdby',
        'd_updatedby',
        'd_status',
    ];
}
