<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'img_public_id',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
