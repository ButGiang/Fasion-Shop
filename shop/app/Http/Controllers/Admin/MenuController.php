<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Menu;
use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use App\Http\Services\Menu\MenuService;

class MenuController extends Controller {   

    protected $menuService;

    public function __construct(MenuService $menuService) {
        $this->menuService = $menuService;
    }

    public function create() {
        return view('admin.menu.add', [
            'title' => 'Thêm danh mục mới',
            'menus' => $this->menuService->getDanhMucCha()
        ]);
    }

    public function store(CreateFormRequest $request) {
        $result= $this->menuService->create($request);
        return redirect()->back(); 
    }

    public function index() {
        return view('admin.menu.list', [
            'title' => 'Danh sách danh mục',
            'menus' => $this->menuService->getAllDanhMuc()
        ]);
    }

    public function destroy(Request $request): JsonResponse {
        $result = $this->menuService->destroy($request);
        if($request) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công!'
            ]);
        }
        return response()->json([
            'error' => true
        ]);
    }

    // truyền vào model Menu với id là $menu lấy từ routes/web.php
    public function show(Menu $menu) {
        // dd($menu->name);
        return view('admin.menu.edit', [
            'title' => 'Chỉnh sửa danh mục '.$menu->name,
            'menu' => $menu,
            'menus' => $this->menuService->getDanhMucCha()
        ]);
    }

    public function update(Menu $menu, CreateFormRequest $request) {
        $this->menuService->update($request, $menu);
        return redirect('/admin/menus/list');
    }
}
