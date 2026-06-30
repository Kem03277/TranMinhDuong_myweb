@extends('admin.layouts.admin')
@section('title', 'Chỉnh Sửa Bài Viết')

@section('content')
<div class="border rounded bg-white p-4 shadow-sm">
    <h3 class="mb-4">Chỉnh Sửa Bài Viết {{ $post->title }}</h3>

    {{-- gọi component --}}
    <x-admin.alert />

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tiêu đề bài viết</label>
                    <input type="text" name="title" class="form-control" 
                            value="{{ old('title', $post->title) }}" required>
                    {{-- hiển thị lỗi cho trường title --}}
                    @error('title')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" 
                            value="{{ old('slug', $post->slug) }}" required>
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
                        {{ old('status', $post->status) == 1 ? 'checked' : '' }}>
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
                    {{ old('status', $post->status) == 0 ? 'checked' : '' }}>
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
                                {{ old('user_id', $post->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->fullname }}
                            </option>
                        @endforeach
                        {{-- hiển thị lỗi cho trường user_id --}}
                        @error('user_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nội dung</label>
                    <textarea name="content" rows="10" class="form-control" required>
                        {{ old('content', $post->content) }}
                    </textarea>
                    {{-- hiển thị lỗi cho trường content --}}
                    @error('content')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            Lưu bài viết
        </button>
    </form>
</div>
@endsection
