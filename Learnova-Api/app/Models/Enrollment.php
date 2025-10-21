<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\User;

class Enrollment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
