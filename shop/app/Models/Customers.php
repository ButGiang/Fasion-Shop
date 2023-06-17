<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cart;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'content'
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'customer_id', 'id');
    }
}
