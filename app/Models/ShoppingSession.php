<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingSession extends Model
{
    use HasFactory;

    public function carts()
    {
        return $this->hasMany(CartItem::class,"session_id");
    }
}
