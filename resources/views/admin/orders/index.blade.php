@extends('admin.layouts.admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Danh sách đơn hàng</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer->name ?? '' }}</td>
                        <td>{{ $order->customer->phone ?? '' }}</td>
                        <td>{{ number_format($order->total, 0, ',', '.') }} đ</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection