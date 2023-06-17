<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Services\Slider\SliderService;
use App\Http\Requests\Slider\SliderRequest;
use App\Models\Slider;

class SliderController extends Controller {

    protected $slider;

    public function __construct(SliderService $slider) {
        $this->slider = $slider;
    }

    public function create() {
        return view('admin.slider.add', [
            'title' => 'Thêm slider mới'
        ]);
    }

    public function store(SliderRequest $request) {
        $this->slider->insert($request);

        return redirect()->back();
    }

    public function index() {
        return view('admin.slider.list', [
            'title' => 'danh sách slider',
            'sliders' => $this->slider->get()
        ]);
    }

    public function show(Slider $slider) {
        return view('admin.slider.edit', [
            'title' => 'chỉnh sửa slider',
            'slider' => $slider
        ]);
    }

    public function update(Request $request, Slider $slider) {
        $result = $this->slider->update($request, $slider);
        if($result) {
            return redirect('/admin/sliders/list');
        }
        else {
            return redirect()->back();
        }
    }

    public function destroy(Request $request) {
        $request = $this->slider->delete($request);
        if($request) {
            return response()->json([
                'error' => false,
                'message' => 'Đã xóa slider'
            ]);

            return location.reload();
        }
        return response()->json([
            'error' => true
        ]);
    }
}
