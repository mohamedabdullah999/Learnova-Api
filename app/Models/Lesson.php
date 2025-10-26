<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'video_path',
        'duration',
        'video_public_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
