<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\Product;
use Session;
use Auth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $productDetail = ProductDetail::where('product_id', $request->product_id)->where('size', $request->size)->first();
        if ($productDetail) {
            $cart = Session::get('cart');
            if ($cart) {
                $numberOfItemInCart = Session::get('numberOfItemInCart');
                foreach ($cart as $key => $item) {
                    if ($item['product_detail_id'] == $productDetail->id && $item['product_id'] == $productDetail->product_id) {
                        $cart[$key]['quantity'] += $request->quantity;
                        Session::put('cart', $cart);
                        $numberOfItemInCart += $request->quantity;
                        Session::put('numberOfItemInCart', $numberOfItemInCart);
                        Session::save();

                        return redirect()->back();
                    }
                }
                Session::push('cart', [
                    'product_detail_id' => $productDetail->id,
                    'product_id' => $request->product_id,
                    'size' => $request->size,
                    'quantity' => (int) $request->quantity,
                    'price' => (int) $productDetail->product->current_price,
                ]);
                $numberOfItemInCart += $request->quantity;
                Session::put('numberOfItemInCart', $numberOfItemInCart);
                Session::save();
            } else {
                Session::put('cart', [
                    [
                        'product_detail_id' => $productDetail->id,
                        'product_id' => $request->product_id,
                        'size' => $request->size,
                        'quantity' => (int) $request->quantity,
                        'price' => (int) $productDetail->product->current_price,
                    ],
                ]);
                Session::put('numberOfItemInCart', (int) $request->quantity);
                Session::save();
            }

            return redirect()->back();
        }
    }

    public function cart() {
        $cart = [];
        $productNames = [];
        $images = [];
        if (Session::has('numberOfItemInCart') && Session::get('numberOfItemInCart') > 0) {
            $cart = Session::get('cart');
            foreach ($cart as $item) {
                $product = Product::findOrFail($item['product_id']);
                array_push($productNames, $product->name);
                $image = $product->images->first()->image_link;
                array_push($images, $image);
            }
        }

        return view('users.pages.cart', compact('cart', 'productNames', 'images'));
    }

    public function deleteOneProduct(Request $request)
    {
        try {
            $productDetail = ProductDetail::findOrFail($request->product_detail_id);
            $cart = Session::get('cart');
            $numberOfItemInCart = Session::get('numberOfItemInCart');
            $newCart = [];
            foreach ($cart as $item) {
                if ($item['product_detail_id'] == $productDetail->id) {
                    $numberOfItemInCart -= $item['quantity'];
                    Session::put('numberOfItemInCart', $numberOfItemInCart);
                    Session::save();
                } else {
                    array_push($newCart, $item);
                }
            }
            Session::put('cart', $newCart);
            Session::save();

            return redirect()->route('user.cart');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteAllProduct()
    {
        Session::forget('cart');
        Session::forget('numberOfItemInCart');
        Session::save();

        return redirect()->route('user.cart');
    }
}
