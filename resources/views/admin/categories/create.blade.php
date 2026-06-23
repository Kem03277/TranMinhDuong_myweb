@extends('admin.layouts.admin')

@section('title', 'Thêm loại sản phẩm')

@section('content')
    <h2 class="mb-4">THÊM LOẠI SẢN PHẨM MỚI</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Tên loại sản phẩm</label>
            <input type="text" name="catename" class="form-control" value="{{ old('catename') }}">
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
        </div>

       <div class="mb-3">
                    <label class="form-label d-block">Trạng thái</label>
                    <input type="radio" class="btn-check" name="status" id="active" value="1" 
                        {{ old('status', 1) == 1 ? 'checked' : '' }}>
                    <label class="btn btn-outline-success" for="active">
                        Hiển thị
                    </label>
                    <input type="radio" class="btn-check" name="status" id="inactive" value="0" 
                    {{ old('status', 1) == 0 ? 'checked' : '' }}>
                    <label class="btn btn-outline-danger" for="inactive">
                        Ẩn
                    </label>
        </div>
         <div class="mb-3">
                    <label class="form-label">Mô tả sản phẩm</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
         </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
@endsection