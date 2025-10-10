<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'expertise',
        'image',
        'linkedin',
        'twitter',
    ];
}
