<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ===== ĐĂNG KÝ =====
    
    public function register()
    {
        return view('auth.register');
    }

    public function postRegister(RegisterRequest $request)
    {
        // Tạo user mới
        $user = User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        // Đăng nhập luôn sau khi đăng ký (tùy bạn)
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('home')   // đổi thành route bạn muốn
            ->with('message', 'Register successfully!!!');
    }

    // ===== ĐĂNG NHẬP =====


    public function login()
{
    return view('auth.login');
}

public function postLogin(Request $request)
{
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user=Auth::user();
        if($user->role===1){
            return redirect()->route('admin.dashboard')->with('success','Đăng nhập với tư cách là Admin');
        }
        else{
            return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        }        
    }

    return back()->withErrors([
        'email' => 'Email hoặc mật khẩu không chính xác.',
    ])->onlyInput('email');
}


    // ===== ĐĂNG XUẤT =====
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
