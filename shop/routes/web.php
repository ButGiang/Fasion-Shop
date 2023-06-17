<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Admin\Users\LoginController;

use \App\Http\Controllers\Admin\MainController as AdminMainController;
use \App\Http\Controllers\Admin\MenuController as AdminMenuController;
use \App\Http\Controllers\Admin\ProductController as AdminProductController;
use \App\Http\Controllers\Admin\UploadController;
use \App\Http\Controllers\Admin\SliderController;
use \App\Http\Controllers\Admin\OrderController;

use \App\Http\Controllers\MainController;
use \App\Http\Controllers\MenuController;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\CartController;


// đặt cho route này tên là 'login'
Route::get('admin/users/login', [LoginController::class, 'index'])->name('login');
Route::post('admin/users/login/store', [LoginController::class, 'store']);


// middleware để kiểm tra đã đăng nhập chưa
// nếu chưa login -> trả về route login (xem ở Http/Controllers/Admin/Middleware/Authenticate.php)
Route::middleware(['auth'])->group(function() {

    // tạo 1 nhóm thuộc admin/...
    Route::prefix('admin')->group(function() {
        // ----- LOGIN -----
        Route::get('/', [AdminMainController::class, 'index'])->name('admin');
        Route::get('main', [AdminMainController::class, 'index']);

        // ----- MENU -----
        // tạo 1 nhóm thuộc admin/menus/...
        Route::prefix('menus')->group(function() {
            // tạo danh mục: url: admin/menus/add
            Route::get('add', [AdminMenuController::class, 'create']);
            Route::post('add', [AdminMenuController::class, 'store']);
            // xem danh mục: url: admin/menus/list
            Route::get('list', [AdminMenuController::class, 'index']);
            // Xóa danh mục: admin/menus/delete
            Route::delete('destroy', [AdminMenuController::class, 'destroy']);
            // Chỉnh sửa danh mục: url: admin/menus/edit/{menu}
            Route::get('edit/{menu}', [AdminMenuController::class, 'show']);
            // Chỉnh sửa danh mục: url: admin/menus/update/{menu}
            Route::post('edit/{menu}', [AdminMenuController::class, 'update']);
        });


        // ----- PRODUCT -----
        Route::prefix('products')->group(function() {
            // url: admin/products/{...}
            Route::get('add', [AdminProductController::class, 'create']);
            Route::post('add', [AdminProductController::class, 'store']);
            Route::get('list', [AdminProductController::class, 'index']);
            Route::get('edit/{product}', [AdminProductController::class, 'show']);
            Route::post('edit/{product}', [AdminProductController::class, 'update']);
            Route::delete('destroy', [AdminProductController::class, 'destroy']);
        });


        // ----- UPLOAD FILE -----
        Route::post('upload/services', [UploadController::class, 'store']);


        // ----- SLIDERS -----
        Route::prefix('sliders')->group(function() {
            // url: admin/sliders/{...}
            Route::get('add', [SliderController::class, 'create']);
            Route::post('add', [SliderController::class, 'store']);
            Route::get('list', [SliderController::class, 'index']);
            Route::get('edit/{slider}', [SliderController::class, 'show']);
            Route::post('edit/{slider}', [SliderController::class, 'update']);
            Route::delete('destroy', [SliderController::class, 'destroy']);
        });

        // ----- ORDER -----
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('orders/view/{customer}', [OrderController::class, 'show']);
        Route::delete('orders/destroy', [OrderController::class, 'delete']);

    });
});


Route::get('/', [MainController::class, 'index']);
Route::post('/services/load-product', [MainController::class, 'loadProduct']);

Route::get('danh-muc/{id}-{slug}.html', [MenuController::class, 'index']);
Route::get('san-pham/{id}-{slug}.html', [ProductController::class, 'index']);

Route::post('add-cart', [CartController::class, 'index']);
Route::get('carts', [CartController::class, 'show']);
Route::post('update-cart', [CartController::class, 'update']);
Route::get('carts/delete/{id}', [CartController::class, 'remove']);
Route::post('carts', [CartController::class, 'Order']);
