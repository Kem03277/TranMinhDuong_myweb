@extends('admin.layouts.admin')

@section('title', 'Thêm loại sản phẩm')

@section('content')
    <h2 class="mb-4">THÊM LOẠI SẢN PHẨM MỚI</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Tên loại sản phẩm</label>
            <input type="text" name="catename" class="form-control">
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control">
        </div>

        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-control">
                <option value="1">Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>

            <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
@endsection