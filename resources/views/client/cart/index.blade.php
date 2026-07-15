@extends('client.layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Giỏ hàng</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (empty($cart))
            <div class="alert alert-info">Giỏ hàng của bạn đang trống.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $id => $item)
                            <tr>
                                <td>{{ $item['proname'] }}</td>
                                <td>{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                                <td>
                                    <form action="{{ route('cart.update') }}" method="POST" class="d-flex gap-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $id }}">
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                            class="form-control" style="width: 90px;">
                                        <button class="btn btn-sm btn-outline-primary" type="submit">Cập nhật</button>
                                    </form>
                                </td>
                                <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ</td>
                                <td>
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $id }}">
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <strong>Tổng tiền:</strong> {{ number_format($total, 0, ',', '.') }} đ
                </div>
                <div class="d-flex gap-2">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-secondary" type="submit">Xóa toàn bộ</button>
                    </form>
                    <a href="{{ route('cart.checkout') }}" class="btn btn-success">Tiến hành đặt hàng</a>
                </div>
            </div>
        @endif
    </div>
@endsection