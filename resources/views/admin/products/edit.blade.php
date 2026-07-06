@extends('admin.layouts.admin')
@section('title', 'Chỉnh Sửa Sản Phẩm')

@section('content')
   <div class="border rounded bg-white p-4 shadow-sm">
        <h3 class="mb-4">Chỉnh sửa sản phẩm</h3>

            {{-- gọi component --}}
            <x-admin.alert />

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
             <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="productname" class="form-control" 
                            value="{{ old('productname', $product->productname) }}"
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
                    <input type="text" name="slug" class="form-control" 
                            value="{{ old('slug', $product->slug) }}" required>
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
                            <option value="{{ $category->cateid }}"
                                {{ old('cateid', $product->cateid) == $category->cateid ? 'selected' : '' }}>
                                {{ $category->catename }}
                            </option>
                        @endforeach
                        {{--hiển thị lỗi cho trường cateid --}}
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
                            <option value="{{ $brand->id }}"
                                {{ old('brandid', $product->brandid) == $brand->id ? 'selected' : '' }}>
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
            <div class="mb-3 img-group">
                <label class="form-label">Hình ảnh chính</label>
                <input type="file" name="img" class="form-control img-input">
            <div class="img-preview mt-2">
                @if ($product->image)
                    <img src="{{ asset('storage/products/' . $product->image) }}" 
                        class="img-thumbnail" width="120">
                @endif
            </div>
            {{-- hiển thị lỗi cho trường img --}}
                @error('img')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mb-3 img-group">
                <label class="form-label">Hình ảnh phụ</label>
                <input type="file" name="imgs[]" class="form-control img-input" multiple>
            <div class="img-preview mt-2">
                @foreach ($product->images as $image)
                    <div class="d-inline-block position-relative me-2 mb-2 image-item">
                        <img src="{{ asset('storage/products/' . $image->image) }}"
                        class="img-thumbnail me-2 mb-2"  width="100">
                        <button type="button"
                                class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image-btn"
                                data-product-id="{{ $product->id }}"
                                data-image-id="{{ $image->id }}">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                @endforeach
            </div>
            {{-- hiển thị lỗi cho trường imgs --}}
                @error('imgs')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Giá</label>
                    <input type="number" name="price" class="form-control" 
                    value="{{ old('price', $product->price) }}" required>
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
                    value="{{ old('pricediscount', $product->pricediscount) }}">
                    {{-- hiển thị lỗi cho trường pricediscount --}}
                    @error('pricediscount')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label d-block">Trạng thái</label>
                    <input type="radio" class="btn-check" name="status" id="active" value="1" 
                        {{ old('status', $product->status) == 1 ? 'checked' : '' }}>
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
                    {{ old('status', $product->status) == 0 ? 'checked' : '' }}>
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
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
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
        </form>
    </div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.remove-image-btn').forEach(button => {

    button.addEventListener('click', function () {

        // Lấy ID sản phẩm và ID ảnh
        const productId = this.dataset.productId;
        const imageId = this.dataset.imageId;

        // Hỏi xác nhận
        if (!confirm('Bạn có chắc muốn xóa ảnh này?')) return;

        // Gửi request xóa
        fetch(`/admin/products/${productId}/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {

            if (data.success) {
                // Xóa ảnh khỏi giao diện
                this.closest('.image-item').remove();
            }

            alert(data.message);

        })
        .catch(() => {
            alert('Xóa ảnh thất bại!');
        });

    });

});
</script>
@endsection