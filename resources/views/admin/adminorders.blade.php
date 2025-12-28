@extends('admin.adminview')

@section('title', 'Quản lí đơn hàng')
@section('page_title', 'Quản lí đơn hàng')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Danh sách đơn hàng</h5>
    </div>

    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 80px;">Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Sản phẩm</th>
                    <th style="white-space: nowrap;">Tổng tiền</th>
                    <th style="white-space: nowrap;">Trạng thái</th>
                    <th style="white-space: nowrap;">Ngày đặt</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>


                    <td>{{ $order->customer_name }}</td>


                    <td>
                        @foreach($order->items as $item)
                        {{ $item->product_name }} x{{ $item->quantity }}
                        @if(!$loop->last), @endif
                        @endforeach
                    </td>


                    <td>
                        {{ number_format($order->total ?? 0, 0, ',', '.') }}₫
                    </td>

                    <td>
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}"
                            method="POST">
                            @csrf
                            @method('PATCH')

                            <select name="status"
                                class="form-select form-select-sm"
                                onchange="this.form.submit()">
                                <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>⏳ Đang chờ xác nhận</option>
                                <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>🛒 Đang chuẩn bị đơn hàng</option>
                                <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>🚚 Đang giao hàng</option>
                                <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>✅ Hoàn tất</option>
                                <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>❌ Hủy đơn</option>
                            </select>
                        </form>
                    </td>



                    <td>{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">
                        Chưa có đơn hàng nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($orders->hasPages())
    <div class="card-footer bg-white">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection