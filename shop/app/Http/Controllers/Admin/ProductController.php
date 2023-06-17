<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Product\ProductAdminService;
use App\Models\Product;

class ProductController extends Controller {

    protected $productService;

    public function __construct(ProductAdminService $productService) {
        $this->productService = $productService;
    }

    public function index() {
        return view('admin.product.list', [
            'title' => 'Danh Sách Sản Phẩm',
            'products' => $this->productService->get()
        ]);
    }

    public function create() {
        return view('admin.product.add', [
            'title' => 'Thêm Sản Phẩm Mới',
            'menus' => $this->productService->getMenu()
        ]);
    }

    public function store(ProductRequest $request) {
        $this->productService->insert($request);

        return redirect()->back();
    }

    public function show(Product $product) {
        return view('admin.product.edit', [
            'title' => 'Chỉnh sửa sản phẩm',
            'product' => $product,
            'menus' => $this->productService->getMenu()
        ]);
    }

    public function update(Request $request, Product $product) {
        $this->productService->update($request, $product);
        return redirect()->back();
    }

    public function destroy(Request $request) {
        $request = $this->productService->delete($request);
        if($request) {
            return response()->json([
                'error' => false,
                'message' => 'Đã xóa sản phẩm'
            ]);

            return location.reload();
        }
        return response()->json([
            'error' => true
        ]);
    }
}

