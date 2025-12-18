@extends('admin.adminview')

@section('content')
<div class="container-fluid">
    <h2>Quản Lý Người Dùng</h2>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Điểm</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                 
                    N/A (Cần tính điểm)
                </td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>
                    {{-- Chuyển hướng đến trang Chi tiết (admin.users.show) --}}
                    <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-sm btn-info">Xem Chi tiết</a>
                    
            
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{-- Hiển thị phân trang --}}
    {{ $users->links() }}
</div>
@endsection