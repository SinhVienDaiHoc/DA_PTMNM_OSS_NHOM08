<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class ProfileController extends Controller
{
        // THÔNG TIN CÁ NHÂN
   public function edit(Request $request){
    $user=$request->user()->load('profile');
    return view('auth.profile_in4',compact('user'));

   }
   public function update(Request $request){
    $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'date_of_birth'=>'nullable|date',
            'gender'        => ['nullable', Rule::in(['male', 'female', 'other'])],
            'address'       => 'nullable|string|max:500',

    ]);
    $user = $request->user();
    $user->profile()->updateOrCreate(
            ['user_id' => $user->id], // Điều kiện tìm kiếm (chỉ tìm bản ghi có user_id này)
            $validated);
            return redirect()->back()->with('success', 'Thông tin cá nhân đã được cập nhật thành công!');
   }
   

   public function changePassword(Request $request)
    {
        $user = $request->user();

        // 1. Validation
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' yêu cầu trường password_confirmation
        ]);

        // 2. Kiểm tra mật khẩu cũ
        if (!Hash::check($request->current_password, $user->password)) {
            // THAY ĐỔI: Nếu mật khẩu cũ không khớp, ném ra ngoại lệ
            throw ValidationException::withMessages([
                'current_password' => ['Mật khẩu hiện tại không chính xác.'],
            ]);
        }

        // 3. Cập nhật mật khẩu mới
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();
        
        // GHI CHÚ: Redirect về cùng trang với thông báo thành công khác
return redirect()->route('profile.edit')->with('password_success', 'Mật khẩu của bạn đã được thay đổi thành công!');    }

}
