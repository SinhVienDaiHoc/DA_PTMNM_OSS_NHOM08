<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // Form đăng nhập admin
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    // đăng nhập admin
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        //  email + password
        $credentials = $request->only('email', 'password');

        // điều kiện role = 1 (admin)
        $credentials['role'] = 1;   // cột role trong bảng users = 1 là admin

        //  form  checkbox remember
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Đăng nhập thành công -> vào dashboard 
            return redirect()->route('admin.dashboard');
            // hoặc: return redirect()->intended(route('admin.dashboard'));
        }

        // Sai tài khoản / mật khẩu / không phải admin
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập admin không chính xác.',
        ])->onlyInput('email');
    }

    // Đăng xuất admin
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.view');
    }
}
