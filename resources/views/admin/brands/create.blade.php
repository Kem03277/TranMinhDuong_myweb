@extends('admin.layouts.admin')

@section('title', 'Thêm thương hiệu')

@section('content')
    <div class="border rounded bg-white p-4 shadow-sm">
        <h3 class="mb-4">Thêm thương hiệu</h3>

        {{-- gọi component --}}
        <x-admin.alert />

        <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tên thương hiệu</label>
                <input type="text" name="brandname" class="form-control" value="{{ old('brandname') }}" required>
                {{-- hiển thị lỗi cho trường brandname --}}
                @error('brandname')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                {{-- hiển thị lỗi cho trường slug --}}
                @error('slug')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mb-3 img-group">
                <label class="form-label">Hình ảnh</label>
                <input type="file" name="img" class="form-control img-input">
                <div class="img-preview mt-2"></div>
                {{-- hiển thị lỗi cho trường img --}}
                @error('img')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Trạng thái</label>
                <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', 1) == 1 ? 'checked' : '' }}>
                <label class="btn btn-outline-success" for="active">
                    Hiển thị
                </label>

                <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status', 1) == 0 ? 'checked' : '' }}>
                <label class="btn btn-outline-danger" for="inactive">
                    Ẩn
                </label>
                {{-- hiển thị lỗi cho trường status --}}
                @error('status')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả thương hiệu</label>
                <textarea name="description" rows="4" class="form-control">
                                                                                                                    {{ old('description') }}
                                                                                                                </textarea>
            </div>

            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
@endsection