@extends('admin.adminview')

@section('title', 'Dashboard')
@section('page_title')

@section('content')

<h3 class="mb-3">Doanh thu & sản phẩm</h3>

{{-- BẢNG DOANH THU + SỐ LƯỢNG --}}
<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng đã bán</th>
            <th>Doanh thu</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($productStats as $i => $row)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $row->product_name }}</td>
            <td>{{ $row->total_sold }}</td>
            <td>{{ number_format($row->total_revenue, 0, ',', '.') }} đ</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center text-muted">Chưa có dữ liệu</td>
        </tr>
        @endforelse

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted">Tổng doanh thu tháng {{ now()->format('m/Y') }}</div>
                        <div class="fs-4 fw-bold text-success">
                            {{ number_format($currentMonthRevenue, 0, ',', '.') }} đ
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </tbody>
</table>

<hr>

<h3 class="mb-3">Khách hàng đã đặt hàng</h3>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Tên khách hàng</th>
            <th>SĐT</th>
            <th>Số đơn</th>
            <th>Đơn gần nhất</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($customers as $i => $c)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $c->full_name }}</td>
            <td>{{ $c->phone_number }}</td>
            <td>{{ $c->total_orders }}</td>
            <td>{{ $c->last_order_at }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center text-muted">Chưa có khách hàng</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection