@extends('client.layouts.app')

@section('title', $product->productname ?? 'Chi tiết sản phẩm')

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->productname }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <div class="col-lg-5">
                <img src="{{ $product->image ? asset('storage/products/' . $product->image) : asset('images/default.png') }}"
                    class="img-fluid rounded shadow-sm w-100" alt="{{ $product->productname }}"
                    style="max-height: 420px; object-fit: cover;">
            </div>
            <div class="col-lg-7">
                <h2 class="mb-3">{{ $product->productname }}</h2>
                <div class="mb-3">
                    <span class="badge bg-primary me-2">{{ $product->category?->catename }}</span>
                    <span class="badge bg-secondary">{{ $product->brand?->brandname }}</span>
                </div>
                <div class="mb-3">
                    <span class="fs-3 fw-bold text-danger">
                        {{ number_format($product->pricediscount > 0 ? $product->pricediscount : $product->price, 0, ',', '.') }}
                        đ
                    </span>
                    @if ($product->pricediscount > 0)
                        <span class="ms-2 text-muted text-decoration-line-through">
                            {{ number_format($product->price, 0, ',', '.') }} đ
                        </span>
                    @endif
                </div>
                <div class="mb-4">
                    <h5>Mô tả</h5>
                    <p class="text-muted">{{ $product->description ?: 'Chưa có mô tả cho sản phẩm này.' }}</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary add-to-cart-btn" data-product-id="{{ $product->id }}">
                        Thêm vào giỏ
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">Quay lại</a>
                </div>
            </div>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <div class="mt-5">
                <h3 class="mb-3">Sản phẩm liên quan</h3>
                <div class="row g-4">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="col-12 col-sm-6 col-lg-3">
                            <x-client.product-card :product="$relatedProduct" />
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection