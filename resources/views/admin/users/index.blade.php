@extends('admin.layouts.admin')

@section('title', 'Người dùng')

@section('content')
    <h2 class="mb-3">DANH SÁCH NGƯỜI DÙNG</h2>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-2">
        <i class="bi bi-plus-circle"></i>
        Thêm mới
    </a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>Tên đăng nhập</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Vai trò</th>
                <th>Trạng thái</th>
                <th width="120">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $item)
                <tr>
                    <td>{{ $list->firstItem() + $loop->index }}</td>
                    <td>{{ $item->fullname }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>
                        @if($item->role == 1)
                            <span class="badge bg-info">Quản lý</span>
                        @else
                            <span class="badge bg-warning">Nhân Viên</span>
                        @endif
                    </td>
                    <td>
                        @if($item->status == 1)
                            <span class="badge bg-success">Kích Hoạt</span>
                        @else
                            <span class="badge bg-danger">Khóa</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="{{ route('admin.users.destroy', $item->id) }}"
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