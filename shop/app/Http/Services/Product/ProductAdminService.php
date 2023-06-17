<?php

namespace App\Http\Services\Product;

use Illuminate\Support\Facades\Session;

use App\Models\Menu;
use App\Models\Product;


class ProductAdminService {

    public function getMenu() {
        return Menu::where('active', 1)->get();
    }

    protected function isValidPrice($request) {
        $price = (int)$request->input('price');
        $sale_price = (int)$request->input('price_sale');
        if($sale_price != 0 && $price == 0) {
            Session::flash('error', 'Vui lòng nhập giá sản phẩm');
            return false;
        }

        if($price != 0 &&  $sale_price != 0 &&  $sale_price >= $price) {
            Session::flash('error', 'Giá khuyến mãi phải nhỏ hơn giá gốc');
            return false;
        }

        return true;
    }

    public function insert($request) {
        $isValidPrice = $this->isValidPrice($request);
        if($isValidPrice === false)
            return false;

        try {
            $request->except('_token');
            Product::create($request->all());

            Session::flash('success', 'Thêm Sản phẩm mới thành công');
        }
        catch(Exception $err) {
            Session::flash('error', 'Thêm Sản phẩm thất bại!');
            Log::info($err->getMessage());
            return false;
        }

        return true;
    }

    public function get() {
        // gọi vào func menu của model Product
        return Product::with('menu')->orderByDesc('id')->paginate(10);
    }

    public function update($request, $product) {
        $isValidPrice = $this->isValidPrice($request);
        if($isValidPrice === false)
            return false;

        try {
            $product->fill($request->input());
            $product->save();

            Session::flash('success', 'Cập nhật thành công');
        }
         catch(Exception $err) {
            Session::flash('error', 'Có lỗi xảy ra, vui lòng thử lại');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function delete($request) {
        $product = Product::where('id', $request->input('id'))->first();
        if ($product) {
            $product->delete();
            return true;
        }

        return false;
    }

}
