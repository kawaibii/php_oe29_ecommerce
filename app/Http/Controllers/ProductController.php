<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(config('setting.paginate.product'));
        $categories = Category::where('parent_id', null)->get();
        $children = Category::where('parent_id', '<>', null)->get();

        return view('users.pages.product', compact('products', 'categories', 'children'));
    }
}
