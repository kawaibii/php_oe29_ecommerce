<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDetail;
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
}
