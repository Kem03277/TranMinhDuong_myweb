@extends('admin.layouts.admin')

@section('title', 'Loại Sản phẩm')

@section('content')

    <h2 class="mb-3">DANH SÁCH LOẠI SẢN PHẨM</h2>

    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-2">
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
                <th>Mã loại</th>
                <th>Tên loại</th>
                <th>Slug</th>
                <th>Trạng thái</th>
                <th width="120">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $item)
                <tr>
                    <td>{{ $list->firstItem() + $loop->index }}</td>

                    <td>
                        <img src="{{ asset($item->image ? 'images/categories/' . $item->image : 'images/default.png') }}"
                            alt="{{ $item->catename }}" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>

                    <td>{{ $item->cateid }}</td>
                    <td>{{ $item->catename }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>
                        @if($item->status == 1)
                            <span class="badge bg-success">Hiển thị</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $item->cateid) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $item->cateid) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc muốn xóa?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
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