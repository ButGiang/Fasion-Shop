<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'thumb',
        'description',
        'content',
        'price',
        'price_sale',
        'active',
        'menu_id'
    ];


    // lấy menu của sản phẩm theo menu_id = Model::Menu->id
    public function menu() {
        return $this->hasOne(Menu::class, 'id', 'menu_id')->withDefault(['name' => '']);
    }
}
