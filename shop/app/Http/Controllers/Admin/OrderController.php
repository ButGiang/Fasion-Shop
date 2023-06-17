<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;

use App\Models\Customers;

class OrderController extends Controller
{

    protected $order;

    public function __construct(OrderService $order) {
        $this->order = $order;
    }

    public function index() {
        return view('admin.order.list', [
            'title' => 'Danh sách đơn đặt hàng',
            'customers' => $this->order->getOrder()
        ]);
    }

    public function show(Customers $customer) {

        return view('admin.order.detail', [
            'title' => 'Chi Tiết Đơn Đặt Hàng: ' . $customer->name,
            'customer' => $customer,
            'carts' => $customer->carts()->with(['product' => function($query) {
                $query->select('id', 'name', 'thumb');
            }])->get()
        ]);
    }

    public function delete(Request $request) {
        $request = $this->order->delete($request);
        if($request) {
            return response()->json([
                'error' => false,
                'message' => 'Đã xóa đơn đặt hàng'
            ]);

            return location.reload();
        }
        return response()->json([
            'error' => true
        ]);
    }
}
