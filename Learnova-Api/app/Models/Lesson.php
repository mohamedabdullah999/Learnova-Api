<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Lesson extends Model
{
    protected $fillable = ['course_id', 'title', 'description', 'video_path', 'duration'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
