@extends('admin.layouts.admin')

@section('title', 'Cập nhật loại sản phẩm')

@section('content')
    <h2 class="mb-4">CẬP NHẬT LOẠI SẢN PHẨM {{ $category->catename }}</h2>

    <form action="{{ route('admin.categories.update', $category->cateid) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Tên loại sản phẩm {{ $category->catename }}</label>
            <input type="text" name="catename" class="form-control" value="{{ $category->catename }}">
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ $category->slug }}">
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
@endsection