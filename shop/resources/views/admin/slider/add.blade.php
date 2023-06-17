@extends('admin.main')

@section('header')

@endsection

@section('content')
    <!-- form start -->
    <form action="" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Đường dẫn</label>
                        <input type="text" name="url" class="form-control" value="{{ old('url') }}">
                        </select>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="menu">Ảnh</label>
                <input type="file" class="form-control" id="upload">
                <div id="image_show"></div>
                <input type="hidden" name="thumb" id="file">
            </div>


            <div class="form-group">
                <label>Sắp xếp theo</label>
                <input type="number" name="sort_by" class="form-control" value="{{ old('sort_by') }}">
                </select>
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

@endsection
