<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    protected $fillable = ['instructor_id', 'name'];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
