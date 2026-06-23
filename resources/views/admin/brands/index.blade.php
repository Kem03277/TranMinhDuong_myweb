@extends('admin.layouts.admin')

@section('title', 'Thương hiệu')

@section('content')
    <h2 class="mb-3">DANH SÁCH THƯƠNG HIỆU</h2>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary mb-2">
        <i class="bi bi-plus-circle"></i>
        Thêm mới
    </a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Hình ảnh</th>
                <th>Tên thương hiệu</th>
                <th>Slug</th>
                <th>Thứ tự</th>
                <th>Trạng thái</th>
                <th width="120">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $item)
                <tr>
                    <td>{{ $list->firstItem() + $loop->index }}</td>

                    <td>
                        <img src="{{ asset($item->image ? 'images/brands/' . $item->image : 'images/default.png') }}"
                            alt="{{ $item->brandname }}" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>

                    <td>{{ $item->brandname }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>{{ $item->sort_order }}</td>
                    <td>
                        @if($item->status == 1)
                            <span class="badge bg-success">Hiển thị</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.brands.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="{{ route('admin.brands.destroy', $item->id) }}"
                            onclick="return confirm('Bạn có chắc muốn xóa?')" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- Hien thi phan trang --}}
    <div class="d-flex justify-content-center">
        {{ $list->links() }}
    </div>
@endsection