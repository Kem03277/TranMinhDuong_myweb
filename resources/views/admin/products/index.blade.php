@extends('admin.layouts.admin')

@section('title', 'Loại sản phẩm')

@section('content')
    <h2 class="mb-3">DANH SÁCH SẢN PHẨM</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-2">
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
                <th>Tên sản phẩm</th>
                <th>Loại</th>
                <th>Thương hiệu</th>
                <th>Giá</th>
                <th>Trạng thái</th>
                <th width="120">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($list as $item)
                <tr>
                    <td>{{ $list->firstItem() + $loop->index }}</td>
                    <td>{{ $item->productname }}</td>
                    <td>{{ $item->category->catename }}</td>
                    <td>{{ $item->brand?->brandname }}</td>
                    <td>{{ number_format($item->price, 0) }} đ</td>
                    <td>
                        @if($item->status)
                            <span class="badge bg-success">Hiển thị</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="{{ route('admin.products.destroy', $item->id) }}"
                            onclick="return confirm('Bạn có chắc muốn xóa?')" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        Không có dữ liệu
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $list->links() }}
    </div>
@endsection