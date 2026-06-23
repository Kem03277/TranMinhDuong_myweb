@extends('admin.layouts.admin')

@section('title', 'Cập nhật loại sản phẩm')

@section('content')
    <h2 class="mb-4">CẬP NHẬT LOẠI SẢN PHẨM {{ $category->catename }}</h2>

    <form action="{{ route('admin.categories.update', $category->cateid) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Tên loại sản phẩm {{ $category->catename }}</label>
            <input type="text" name="catename" class="form-control" value="{{ old('catename', $category->catename) }}">
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <div>
                <input type="radio" class="btn-check" name="status" id="active" value="1" 
                    {{ old('status', $category->status) == 1 ? 'checked' : '' }}>
                <label class="btn btn-outline-success" for="active">
                    Hiển thị
                </label>
                <input type="radio" class="btn-check" name="status" id="inactive" value="0" 
                    {{ old('status', $category->status) == 0 ? 'checked' : '' }}>
                <label class="btn btn-outline-danger" for="inactive">
                    Ẩn
                </label>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả sản phẩm</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
@endsection