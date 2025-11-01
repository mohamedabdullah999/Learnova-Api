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
        'img',
        'email',
        'linkedin',
        'twitter',
        'img_public_id',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function expertises()
    {
        return $this->hasMany(Expertise::class);
    }
}
