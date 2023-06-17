<?php

namespace App\Http\Services;

use App\Models\Customers;
use App\Models\Product;


class OrderService {
    public function getOrder()
    {
        return Customers::orderByDesc('id')->paginate(10);
    }

    public function delete($request) {
        $order = Customers::where('id', $request->input('id'))->first();
        dd($order);
        if ($order) {
            $order->delete();
            return true;
        }

        return false;
    }
}
