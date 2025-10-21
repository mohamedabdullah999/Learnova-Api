<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'order_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
