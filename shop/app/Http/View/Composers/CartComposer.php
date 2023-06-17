<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

use App\Models\Product;

class CartComposer
{

    public function __construct() {

    }

    public function compose(View $view)
    {
        $carts = Session::get('carts');

        if(is_null($carts))
            return [];

        $product_id = array_keys($carts);

        $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')->where('active', 1)
            ->whereIn('id', $product_id)->get();

        $view->with('products', $products);
    }
}
