<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.product.qlysanpham', compact('products'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'image_cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable',
            'reward_point' => 'nullable|integer'
        ]);


        if ($request->hasFile('image_cover')) {
            $file = $request->file('image_cover');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $data['image_cover'] = $filename;
        }


        $data['user_id'] = Auth::id() ?? 1;

        Product::create($data);

        return redirect()->route('admin.product.qlysanpham')->with('success', 'Thêm bánh mới thành công!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'image_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable',
            'reward_point' => 'nullable|integer'
        ]);


        if ($request->hasFile('image_cover')) {
            if (file_exists(public_path('uploads/products/' . $product->image_cover))) {
                unlink(public_path('uploads/products/' . $product->image_cover));
            }

            $file = $request->file('image_cover');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $data['image_cover'] = $filename; // 
        }

        $product->update($data);

        return redirect()->route('admin.product.qlysanpham')->with('success', 'Cập nhật bánh thành công!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (file_exists(public_path('uploads/products/' . $product->image_cover))) {
            unlink(public_path('uploads/products/' . $product->image_cover));
        }

        $product->delete();

        return redirect()->route('admin.product.qlysanpham')->with('success', 'Đã xóa sản phẩm!');
    }
}
