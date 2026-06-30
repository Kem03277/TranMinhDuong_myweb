@extends('admin.layouts.admin')
@section('title', 'Thêm Sản Phẩm')

@section('content')
    <div class="border rounded bg-white p-4 shadow-sm">
        <h3 class="mb-4">Thêm loại sản phẩm</h3>

            {{-- gọi component --}}
            <x-admin.alert />

        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="productname" class="form-control" value="{{ old('productname') }}"
                            required>
                        {{-- hiển thị lỗi cho trường productname --}}
                        @error('productname')
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
                        <label class="form-label">Loại sản phẩm</label>
                        <select name="cateid" class="form-select">
                            <option value="">-- Chọn loại sản phẩm --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->cateid }}" {{ old('cateid') == $category->cateid ? 'selected' : '' }}>
                                    {{ $category->catename }}
                                </option>
                            @endforeach
                            {{-- hiển thị lỗi cho trường cateid --}}
                            @error('cateid')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror

                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thương hiệu</label>
                        <select name="brandid" class="form-select">
                            <option value="">-- Chọn thương hiệu --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brandid') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->brandname }}
                                </option>
                            @endforeach
                            {{-- hiển thị lỗi cho trường brandid --}}
                            @error('brandid')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Giá</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
                        {{-- hiển thị lỗi cho trường price --}}
                        @error('price')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá khuyến mãi</label>
                        <input type="number" name="pricediscount" class="form-control"
                            value="{{ old('pricediscount', 0) }}">
                        {{-- hiển thị lỗi cho trường pricediscount --}}
                        @error('pricediscount')
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
                        <label class="form-label">Mô tả sản phẩm</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    {{-- hiển thị lỗi cho trường description --}}
                    @error('description')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                Lưu sản phẩm
            </button>
            <a href="{{  route('admin.products.index') }}" class="btn btn-secondary">
                Quay lại
            </a>
        </form>
    </div>
@endsection