<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Mockery\Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        $products = Product::withCount(['images', 'productDetails'])->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::with(['images', 'productDetails', 'comments'])->find($id);
            $images = $product->images()->where('product_id', $id)->paginate(config('setting.number_paginate'), ['*'], config('setting.paginate.image'));
            $productDetails = $product->productDetails()->where('product_id', $id)->paginate(config('setting.number_paginate'), ['*'], config('setting.paginate.product_detail'));
            $comments = $product->comments()->where('product_id', $id)->paginate(config('setting.number_paginate'), ['*'], config('setting.paginate.comment'));

            return view('admin.products.detail_product', compact('product','images', 'productDetails', 'comments'));
        } catch (Exception $ex) {
            return redirect()->back()->with('message_error', trans('message_error'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->back()->with('message_success', trans('message_success'));
        } catch (Exception $exception) {
            return redirect()->back()->with('message_error', trans('message_error'));
        }
    }
}
