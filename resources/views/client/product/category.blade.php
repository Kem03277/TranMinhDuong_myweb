@extends('client.layouts.app')

@section('title', $category->catename ?? 'Danh mục')

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $category->catename }}</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Danh mục: {{ $category->catename }}</h2>
        </div>

        @if ($products->isEmpty())
            <div class="alert alert-info">
                Danh mục này hiện chưa có sản phẩm nào.
            </div>
        @else
            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-12 col-sm-6 col-lg-3">
                        <x-client.product-card :product="$product" />
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection