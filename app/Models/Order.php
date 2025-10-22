<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'status',
    ];

    public function cartItems() {
        return $this->hasMany(CartItem::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
