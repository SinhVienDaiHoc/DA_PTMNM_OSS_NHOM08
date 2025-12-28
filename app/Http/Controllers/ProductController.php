<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Hàm hiển thị sản phẩm theo danh mục
    public function showByCategory($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->get();
        return view('category.show', compact('category', 'products'));
    }

    /**
     * Tìm kiếm tên bánh 
     */
    public function search(Request $request)
    {
        $keyword = trim($request->input('q'));
        if ($keyword === '') {
            return redirect()->route('home');
        }

        $products = Product::where('name', 'LIKE', "%{$keyword}%")->get();

        return view('search', compact('products', 'keyword'));
    }

    /**
     * Xem chi tiết 1 sản phẩm
     */
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $can_review = false;
        if (Auth::check()) {
            $user_id = Auth::id();

            $hasPurchased = Order::where('user_id', $user_id)
                ->whereHas('items', function ($query) use ($id) {
                    $query->where('product_id', $id);
                })
                ->where('status', '3')
                ->exists();


            $hasReviewed = $product->reviews()->where('user_id', $user_id)->exists();


            if ($hasPurchased && !$hasReviewed) {
                $can_review = true;
            }
        }


        return view('product.detail', compact('product', 'relatedProducts', 'can_review'));
    }
}
