<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoucherExchangeController;

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\PolicyController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\AdminVoucherController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ReviewController;




//====================== START ADMIN ROUTE============================================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', IsAdmin::class])
    ->group(function () {

        //QUẢN LÍ USER
        Route::prefix('user')->name('user.')->group(function () {

            //  Danh sách User (INDEX)
            Route::get('/', [UserController::class, 'index'])
                ->name('index'); // Tên Route: admin.user.index

            // Chi tiết User (SHOW)
            Route::get('/{user}', [UserController::class, 'show'])
                ->name('show'); // Tên Route: admin.user.show


        });

        // TRANG ADMIN HOME (sau khi login)
        Route::get('/view', function () {
            return view('admin.adminview');
        })->name('view');

        // DASHBOARD
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // WARNING
        Route::get('/warning', [AdminController::class, 'warning'])->name('warning');
    });






//====================== END ADMIN ROUTE============================================


// ======================================================================================================================



//====================== START CLIENT ROUTE============================================

// TRANG CHỦ
Route::get('/', [HomeController::class, 'index'])->name('home');


//CÁC CHÍNH SÁCH CỦA CỬA HÀNG
Route::get('/chinhsach', [HomeController::class, 'chinhsach'])->name('chinhsach');
Route::get('/chinhsach', [PolicyController::class, 'index'])->name('chinhsach.mainchinhsach');
Route::get('/chinhsachchung', [PolicyController::class, 'chinhsachchung'])->name('chinhsachchung');
Route::get('/chinhsachvanchuyen', [PolicyController::class, 'chinhsachvanchuyen'])->name('chinhsachvanchuyen');
Route::get('/chinhsachdoitra', [PolicyController::class, 'chinhsachdoitra'])->name('chinhsachdoitra');
Route::get('/chinhsachbaomat', [PolicyController::class, 'chinhsachbaomat'])->name('chinhsachbaomat');
Route::get('/chinhsachthanhtoan', [PolicyController::class, 'chinhsachthanhtoan'])->name('chinhsachthanhtoan');


// GIỎ HÀNG CLIENT
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// DANH MỤC CLIENT
Route::get('/danh-muc/{id}', [ProductController::class, 'showByCategory'])->name('category.show');

//SẢN PHẨM CLIENT
Route::get('/san-pham/{id}', [ProductController::class, 'detail'])->name('product.detail');

// THANH TOÁN
Route::get('/thanhtoan', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/thanhtoan', [CheckoutController::class, 'process'])->name('checkout.process');


//====================== END CLIENT ROUTE============================================


// ======================================================================================================================


// ============================= START AUTH ROUTE====================================
//SEARCH


// AUTH USER
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister'])->name('postRegister');

Route::get('/dang-nhap', [AuthController::class, 'login'])->name('login');
Route::post('/dang-nhap', [AuthController::class, 'postLogin'])->name('postLogin');

Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');

// ============================= END AUTH ROUTE====================================




// ADMIN AUTH ROUTES (KHÔNG LẶP)

Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
