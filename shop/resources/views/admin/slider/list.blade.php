@extends('admin.main')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Slider</th>
                <th>Url</th>
                <th>Hình ảnh</th>
                <th>Active</th>
                <th>Ngày cập nhật</th>
                <th>Method</th>
            </tr>
        </thead>

        <tbody>
            @foreach($sliders as $key => $slider)
                <tr>
                    <td>{{ $slider->id }}</td>
                    <td>{{ $slider->name }}</td>
                    <td>{{ $slider->url }}</td>
                    <td>
                        <a href="{{ $slider->thumb }}" target="_blank">
                            <img src="{{ $slider->thumb }}" width="80px" height="100px">
                        </a>
                    </td>
                    <td>{!! \App\Helpers\Helper::active($slider->active) !!}</td>
                    <td>{{ $slider->updated_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="/admin/sliders/edit/{{ $slider->id }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm"
                        onclick="RemoveRow({{ $slider->id }}, '/admin/sliders/destroy')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $sliders->links() !!}
    </div>
@endsection
