@extends('admin.layouts.admin')
@section('title', 'Thêm Bài Viết')

@section('content')
<div class="border rounded bg-white p-4 shadow-sm">
    <h3 class="mb-4">Thêm loại sản phẩm</h3>

    {{-- gọi component --}}
    <x-admin.alert />

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tiêu đề bài viết</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    {{-- hiển thị lỗi cho trường title --}}
                    @error('title')
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
                <div class="mb-3">
                    <label class="form-label d-block">Trạng thái</label>
                    <input type="radio" class="btn-check" name="status" id="active" value="1" 
                        {{ old('status', 1) == 1 ? 'checked' : '' }}>
                    <label class="btn btn-outline-success" for="active">
                        Hiển thị
                    </label>
                    {{-- hiển thị lỗi cho trường status --}}
                    @error('status')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    <input type="radio" class="btn-check" name="status" id="inactive" value="0" 
                    {{ old('status', 0) == 0 ? 'checked' : '' }}>
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
                    <label class="form-label">Người viết</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">-- Chọn người viết --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" 
                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->fullname }}
                            </option>
                        @endforeach
                    </select>
                    {{-- hiển thị lỗi cho trường user_id --}}
                    @error('user_id')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nội dung</label>
                    <textarea name="content" rows="10" class="form-control" required>{{ old('content') }}</textarea>
                </div>
            </div>
            {{-- hiển thị lỗi cho trường content --}}
            @error('content')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">
            Lưu bài viết
        </button>
    </form>
</div>
@endsection
