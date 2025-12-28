@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="py-4" style="background:#fbf1e0;">
  <div class="container container-wide">
    <h3 class="mb-4 fw-bold">Đơn hàng của bạn</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->isEmpty())
        <p>Bạn chưa có đơn hàng nào.</p>
    @else
        <table class="table bg-white">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($order->total, 0, ',', '.') }} đ</td>
                        <td>{{ $order->status_text }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">Xem chi tiết</a>
                              <form action="{{ route('orders.destroy', $order) }}"
                                  method="POST"
                                 class="d-inline"
                                     onsubmit="return confirm('Bạn có chắc muốn xoá đơn hàng này khỏi lịch sử?');">
                                    @csrf
                                 @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger ms-1">Xoá</button>
                                </form>
                       </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
  </div>
</div>
@endsection
