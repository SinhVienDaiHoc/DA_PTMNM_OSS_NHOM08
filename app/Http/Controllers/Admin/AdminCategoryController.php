<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {

        $categories = Category::withCount('products')->paginate(10);

        return view('admin.category.index', compact('categories'));
    }


    public function create()
    {
        return view('admin.category.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'nullable'
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục này đã tồn tại'
        ]);


        $data['slug'] = Str::slug($request->name);

        Category::create($data);

        return redirect()->route('admin.category.index')->with('success', 'Thêm danh mục thành công!');
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa danh mục đang chứa sản phẩm!');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Đã xóa danh mục!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $id,
            'description' => 'nullable'
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục này đã tồn tại'
        ]);

        $data['slug'] = Str::slug($request->name);

        $category->update($data);

        return redirect()->route('admin.category.index')->with('success', 'Cập nhật danh mục thành công!');
    }
}
