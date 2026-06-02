@extends('admin.layouts.admin')

@section('title', 'Bài viết')

@section('content')
    <h2 class="mb-3">DANH SÁCH BÀI VIẾT</h2>

    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Hình ảnh</th>
                <th>Tiêu đề</th>
                <th>Người viết</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        <img src="{{ asset($item->image ? 'images/posts/' . $item->image : 'images/default.png') }}"
                            alt="{{ $item->title }}" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>

                    <td>{{ $item->title }}</td>
                    <td>{{ $item->fullname }}</td>
                    <td>
                        @if($item->status == 1)
                            <span class="badge bg-success">Xuất bản</span>
                        @else
                            <span class="badge bg-danger">Nháp</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection