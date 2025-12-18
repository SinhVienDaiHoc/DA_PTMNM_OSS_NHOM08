@extends('layouts.app')
@section ('title','Chinh sach')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chinh sach</title>
</head>
<body>
        <section class="py-3 container ">
                    <div class="row">
                         <div class="container col-8">
            {{-- start thông báo --}}
            <h5>Tại
                {{--tên cửa hàng put here --}}
                 <strong>Sweet Corner</strong>
                sự hài lòng của khách hàng được đặt lên hàng đầu. Tiệm áp dụng <strong> các chính sách</strong> minh bạch để đảm bảo khách hàng luôn nhận được các trải nghiệm tốt nhất. 
                </h5>  
               {{-- end thông báo --}}
{{-- ============================================================================ --}}
             {{-- start content --}}
             @yield('main_chinhsach')
               {{--end content --}}
               
               </div>               
 {{-- ============================================================================ --}}
         <div class="container col-4">
            {{-- all link --}}
            <h4>Đọc thêm</h4>
            <hr class="w-50">
            @include('chinhsach.policy_link');
         </div>

                    </div>


        </section>
        @endsection
</body>
</html>