<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\CartService;

class CartController extends Controller {
    protected $cartService;

    public function __construct(CartService $cartService) {
        $this->cartService = $cartService;
    }

    public function index(Request $request) {
        $result = $this->cartService->create($request);
        if(!$result) {
            return redirect()->back()->withInput();
        }

        redirect('/carts');
        $request->session()->flash('success', 'Thêm sản phẩm thành công');
        return redirect()->back()->withInput();

    }

    public function show(Request $request) {
        $products = $this->cartService->getProduct($request);

        return view('cart.list', [
            'title' => 'Giỏ hàng',
            'products' => $products,
            'carts' => $request->session()->get('carts')
        ]);
    }

    public function update(Request $request) {
        $this->cartService->update($request);
        return redirect('/carts');
    }

    public function remove($id = 0) {
        $this->cartService->remove($id);
        return redirect('/carts');

    }

    public function order(Request $request) {
        $this->cartService->order($request);
        return redirect()->back();
    }
}
