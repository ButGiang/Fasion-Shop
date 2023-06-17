<?php

namespace App\Http\Services\Menu;

use App\Models\Menu;
use Illuminate\Support\Facades\Session;

class MenuService {

    public function getDanhMucCha() {
        // lấy từ model Menu các danh mục với parent_id=0
        return Menu::where('parent_id', 0)->get();
    }

    public function getAllDanhMuc() {
        // lấy từ model Menu tất các danh mục
        // sắp xếp giảm dần theo 'id' với 10 danh mục mỗi trang
        return Menu::orderbyDesc('id')->paginate(10);
    }

    public function create($request) {
        try {
            // Trả về model Menu -> phương thức create()
            Menu::create([
                'name' => (string) $request->input('name'),
                'parent_id' => (int) $request->input('parent_id'),
                'description' => (string) $request->input('description'),
                'content' => (string) $request->input('content'),
                'active' => (string) $request->input('active')
            ]);
            $request->session()->flash('success', 'Tạo Danh mục mới thành công');
        }
        catch(exception $e) {
            $request->session()->flash('error', $e->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request) {
        $id = (int) $request->input('id');
        $menu = Menu::where('id', $id)->first();
        if($menu) {
            return Menu::where('id', $id)->orWhere('parent_id', $id)->delete();
        }
        return false;
    }

    public function update($request, $menu): bool {
        $menu->name = (string) $request->input('name');
        if($request->input('parent_id') != $menu->id) {
            $menu->parent_id = (int) $request->input('parent_id');
        }
        $menu->description = (string) $request->input('description');
        $menu->content = (string) $request->input('content');
        $menu->active = (string) $request->input('active');
        $menu->save();

        $request->session()->flash('success', 'Cập nhật danh mục thành công');
        return true;
    }

    public function show() {
        return Menu::select('name', 'id')->where('parent_id', 0)->orderByDesc('id')->get();
    }




    public function getId($id) {
        return Menu::where('id', $id)->where('active', 1)->firstOrFail();
    }

    public function getProduct($menu, $request) {
        $query = $menu->products()->select('id', 'name', 'price', 'price_sale', 'thumb')->where('active', 1);

        // filter sắp xếp theo giá tăng/giảm dần nếu ng dùng ấn vào lọc sp
        if($request->input('price')) {
            $query->orderBy('price', $request->input('price'));
        }
        return $query->orderByDesc('id')->paginate(12)->withQueryString();
    }
}
