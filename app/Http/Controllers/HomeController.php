<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Product;
class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all(); // hoặc paginate()

    return view('home', compact('products'));
    }
    public function chinhsach(){
        return view('chinhsach');
    }
}


