<?php

namespace App\Http\Services\Slider;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use App\Models\Slider;

class SliderService {
    public function insert($request) {
        try {
            Slider::create($request->all());

            Session::flash('success', 'Thêm Slider mới thành công');
        }
        catch(Exception $err) {
            Session::flash('error', 'Thêm Slider thất bại!');
            Log::info($err->getMessage());
            return false;
        }

        return true;
    }

    public function get() {
        return Slider::orderByDesc('id')->paginate(10);
    }

    public function update($request, $slider) {
        try {
            $slider->fill($request->input());
            $slider->save();

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
        $slider = Slider::where('id', $request->input('id'))->first();
        if ($slider) {
            // dẫn link hình ảnh trong folder:
            // url ví dụ: https://shop.test/storage/uploads/2023/04/24/abcxyz.jpg
            // sẽ thành: https://shop.test/public/uploads/2023/04/24/abcxyz.jpg
            $pic_link = str_replace('storage', 'public', $slider->thumb);
            Storage::delete($pic_link);
            $slider->delete();
            return true;
        }

        return false;
    }

    public function show() {
        return Slider::where('active', 1)->orderByDesc('sort_by')->get();
    }
}
