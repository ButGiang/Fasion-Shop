@extends('admin.main')

@section('header')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
    <!-- form start -->
    <form action="" method="POST">
        <div class="card-body">
            <div class="form-group">
                <label>Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label>Danh mục</label>
                <select name="menu_id" class="form-control">
                    @foreach($menus as $item)
                        <option value='{{ $item->id }}'>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Mô tả</label>
                <!-- old() giúp giữ dữ liệu input cũ sau khi refresh lại trang -->
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Thông tin chi tiết</label>
                <textarea name="content" class="form-control" id="content">{{ old('content') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Giá Gốc</label>
                        <input type="number" name="price" value="{{ old('price') }}"  class="form-control" >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Giá khuyến mãi</label>
                        <input type="number" name="price_sale" value="{{ old('price_sale') }}"  class="form-control" >
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Sản Phẩm</label>
                <input type="file" class="form-control" id="upload">
                <div id="image_show"></div>
                <input type="hidden" name="thumb" id="file">
            </div>

            <div class="form-group">
                <label>Kích Hoạt</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="active" checked="">
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="active" >
                    <label for="no_active" class="custom-control-label">Không</label>
                </div>
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Tạo</button>
        </div>

        @csrf
    </form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
