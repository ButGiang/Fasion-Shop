<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Customers;
use App\Models\Cart;

use App\Jobs\SendMail;

class CartService {

    public function create($request) {
        $num_product = (int) $request->input('num_product');
        $product_id = (int) $request->input('product_id');

        if($num_product <= 0) {
            $request->session()->flash('error', 'Số lượng sản phẩm phải > 0');
            return false;
        }

        $carts = $request->session()->get('carts');

        // nếu chưa có sp tồn tại trong giỏ hàng thì tạo mới
        if(is_null($carts)) {
            $request->session()->put('carts', [$product_id => $num_product]);
            return true;
        }

        $exist = Arr::exists($carts, $product_id);
        // nếu sp đã tồn tại trong giỏ hàng thì cập nhật lại số lượng
        if($exist) {
            $carts[$product_id] = $carts[$product_id] + $num_product;
            $request->session()->put('carts', $carts);
            return true;
        }

        $carts[$product_id] = $num_product;
        $request->session()->put('carts', $carts);
        return true;
    }


    public function getProduct($request) {
        $carts = $request->session()->get('carts');

        if(is_null($carts))
            return [];

        $product_id = array_keys($carts);

        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')->where('active', 1)
            ->whereIn('id', $product_id)->get();
    }


    public function update($request) {
        $request->session()->put('carts', $request->input('num_product'));

        return true;
    }


    public function remove($id) {
        if($id != 0) {
            $carts = Session::get('carts');
            unset($carts[$id]);

            Session::put('carts', $carts);
        }
    }


    public function order($request) {
        try {
            DB::beginTransaction();
            $carts = $request->session()->get('carts');

            if(is_null($carts))
                return false;

            $customers = Customers::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'content' => $request->input('content')]);

            $product_id = array_keys($carts);

            $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')->where('active', 1)
                ->whereIn('id', $product_id)->get();

            $data = [];
            foreach($products as $product) {
                $data[] = [
                    'customer_id' => $customers->id,
                    'product_id' => $product->id,
                    'qty' => $carts[$product->id],
                    'price' => $product->price_sale != 0 ? $product->price_sale : $product->price
                ];
            }

            DB::commit();
            $request->session()->flash('success', 'Đặt hàng thành công!');


            SendMail::dispatch($request->input('email'))->delay(now()->addSeconds(3));
            Session::forget('carts');


            return Cart::insert($data);
        }

        catch(exception $e) {
            DB::rollBack();
            $request->session()->flash('success', 'Đặt hàng thất bại! Vui lòng thử lại');
            return false;
        }
    }
}
