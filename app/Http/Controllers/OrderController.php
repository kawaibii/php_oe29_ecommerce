<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use App\Models\Product;
use App\Models\Order;
use Session;
use Auth;

class OrderController extends Controller
{
    public function getListItemsInCart()
    {
        $user = Auth::user();
        $cart = Session::get('cart');
        $productNames = [];
        foreach ($cart as $item) {
            $product = Product::findOrFail($item['product_id']);
            array_push($productNames, $product->name);
        }

        return view('users.pages.checkout', compact('user', 'cart', 'productNames'));
    }

     public function checkout(CheckoutRequest $request)
    {
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => config('order.status.pending'),
                'total_price' => $request->payment,
                'address' => $request->receive_address,
                'phone' => $request->receive_phone,
                'note' => $request->note,
            ]);
            $cart = Session::get('cart');
            foreach ($cart as $key => $item) {
                $order->productDetails()->attach([
                    $key => [
                        'product_detail_id' => $item['product_detail_id'],
                        'order_id' => $order->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['price'],
                    ],
                ]);
            }
            Session::forget('cart');
            Session::forget('numberOfItemInCart');
            Session::save();

            return redirect()->route('user.orderHistory');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getOrderHistory()
    {
        $orders = Auth::user()->orders()
            ->orderBy('created_at', 'desc')
            ->with('productDetails.product')
            ->paginate(config('setting.paginate.order'));

        return view('users.pages.order_history', compact('orders'));
    }

    public function getOrderHistoryByStatus()
    {
        $orders = Auth::user()->orders()
            ->orderBy('created_at', 'desc')
            ->with('productDetails.product')
            ->get();
        $existsPending = false;
        $existsApproved = false;
        $existsRejected= false;
        $existsCancelled = false;
        foreach ($orders as $order) {
            switch ($order->status) {
                case config('order.status.pending'):
                    $existsPending = true;

                    break;
                case config('order.status.approved'):
                    $existsApproved = true;

                    break;
                case config('order.status.rejected'):
                    $existsRejected = true;

                    break;
                case config('order.status.cancelled'):
                    $existsCancelled = true;

                    break;
            }
        }

        return view('users.pages.order_history_by_status', compact(
            'orders',
            'existsPending',
            'existsApproved',
            'existsRejected',
            'existsCancelled'
        ));
    }
}
