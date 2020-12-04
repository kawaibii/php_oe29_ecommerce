<?php

namespace App\Http\Controllers;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Notifications\UserCheckoutNotification;
use App\Service\FirebaseService;
use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use Session;
use Auth;

class OrderController extends Controller
{
    protected $productRepository, $orderRepository, $userRepository;
    protected $firebase;

    function __construct(
        OrderRepositoryInterface $order,
        ProductRepositoryInterface $product,
        UserRepositoryInterface $user,
        FirebaseService $firebase
    ) {
        $this->orderRepository = $order;
        $this->productRepository = $product;
        $this->userRepository = $user;
        $this->firebase = $firebase;
    }

    public function getListItemsInCart()
    {
        $user = Auth::user();
        $cart = Session::get('cart');
        $productNames = [];
        foreach ($cart as $item) {
            $product = $this->productRepository->find($item['product_id']);
            if ($product) {
                array_push($productNames, $product->name);
            }
        }

        return view('users.pages.checkout', compact('user', 'cart', 'productNames'));
    }

     public function checkout(CheckoutRequest $request)
    {
            $data = [
                'user_id' => Auth::id(),
                'status' => config('order.status.pending'),
                'total_price' => $request->payment,
                'address' => $request->receive_address,
                'phone' => $request->receive_phone,
                'note' => $request->note,
            ];
            $order = $this->orderRepository->create($data);
            $cart = Session::get('cart');
            foreach ($cart as $key => $item) {
                $data = [
                    'order_id' => $order->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                ];
                $this->orderRepository->attach($order->id, $item['product_detail_id'], $data);
            }
            Session::forget('cart');
            Session::forget('numberOfItemInCart');
            Session::save();
            $user = Auth::user();
            $notification = [
                'message' => "message_pending",
                'name_user' => $user->name,
                'order_id' => $order->id,
            ];
            $user->notify(new UserCheckoutNotification($notification));
            $notification['status'] = config('order.status.pending');
            $notification['route'] = route('orders.detail', $user->notifications->first()->id);
            $notification['timestamp'] = time();
            $this->firebase->sendNotificationOrderPending($user->id, $notification);
            alert()->success(trans('user.sweetalert.saved'), trans('user.sweetalert.checkout'));

            return redirect()->route('user.orderHistory');
    }

    public function getOrderHistory()
    {
        $orders = $this->userRepository->getOrderHistory(Auth::user()->id);

        return view('users.pages.order_history', compact('orders'));
    }

    public function getOrderHistoryByStatus()
    {
        $orders = $this->userRepository->getOrderHistory(Auth::user()->id);

        return view('users.pages.order_history_by_status', compact('orders'));
    }

    public function userCancelOrder(Request $request)
    {
        try {
            $this->orderRepository->update($request->order_id, [
                'status' => config('order.status.cancelled'),
            ]);
            alert()->success(trans('user.sweetalert.done'), trans('user.sweetalert.cancel_order'));

            return redirect()->route('user.orderHistory');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteProductNotExistInOrder(Request $request)
    {
        try {
            $order = $this->orderRepository->find($request->order_id);
            if ($order) {
                foreach ($order->productDetails as $productDetail) {
                    if ($request->product_detail_id == $productDetail->pivot->product_detail_id) {
                        $total = $request->total_price - ($productDetail->pivot->quantity * $productDetail->pivot->unit_price);

                        break;
                    }
                }
                $this->orderRepository->detach($order->id , $request->product_detail_id);
                $this->orderRepository->update($order->id, [
                    'total_price' => $total,
                ]);
                alert()->success(trans('user.sweetalert.saved'));
            }

            return redirect()->back();
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
}
