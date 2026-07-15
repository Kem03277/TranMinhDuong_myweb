@extends('client.layouts.app')

@section('title', 'Thanh toán')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Thông tin đặt hàng</h2>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Họ tên</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <textarea name="address" class="form-control" rows="4" required></textarea>
                            </div>
                            <button class="btn btn-success" type="submit">Đặt hàng</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Giỏ hàng</h5>
                        @foreach ($cart as $item)
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span>{{ $item['proname'] }} x {{ $item['quantity'] }}</span>
                                <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection