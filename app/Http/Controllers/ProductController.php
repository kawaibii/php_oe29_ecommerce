<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use App\Models\ProductDetail;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(config('setting.paginate.product'));
        $categories = Category::where('parent_id', null)->get();
        $children = Category::where('parent_id', '<>', null)->get();

        return view('users.pages.product', compact('products', 'categories', 'children'));
    }

    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            $images = $product->images;
            $productDetails = $product->productDetails;

            return view('users.pages.product_detail', compact('product', 'images', 'productDetails'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function quantity($id)
    {
        try {
            $productDetails = ProductDetail::findOrFail($id);
            $data = [
                'quantity' => $productDetails->quantity,
            ];

            return json_encode($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
