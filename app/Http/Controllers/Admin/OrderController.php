<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Illuminate\Support\Facades\DB;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\ProductDetails\ProductDetailRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Notifications\Admin\CensoredOrderNotification;

class OrderController extends Controller
{
    protected $userRepo;
    protected $orderRepo;
    protected $productDetailRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        OrderRepositoryInterface $orderRepo,
        ProductDetailRepositoryInterface $productDetailRepo
    ) {
        $this->userRepo = $userRepo;
        $this->orderRepo = $orderRepo;
        $this->productDetailRepo = $productDetailRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('viewAny', Order::class)) {
            $orders = $this->orderRepo->orderBy('status', 'productDetails');

            return view('admin.orders.index', compact('orders'));
        }

        return abort(config('setting.errors404'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->orderRepo->find($id, ['productDetails', 'user']);
        $productDetails = $order->productDetails;
        $user = $order->user;

        return view('admin.orders.modal_detail_order', compact('order', 'productDetails', 'user'));
    }

    public function approvedOrder($id)
    {
        DB::beginTransaction();
        $data = [
            'status' => config('setting.http_status.success'),
            'message' => trans('message_success'),
        ];
        try {
            $order = $this->orderRepo->find($id, ['productDetails']);
            if ($order->status != config('order.status.approved')) {
                $productDetails = $order->productDetails;
                foreach ($productDetails as $productDetail) {
                    if ($productDetail->deleted_at == null) {
                        if ($productDetail->quantity >= $productDetail->pivot->quantity) {
                            $this->productDetailRepo->update($productDetail->id, [
                                'quantity' => $productDetail->quantity - $productDetail->pivot->quantity,
                            ]);
                        } else {
                            $data['status'] = config('setting.http_status.error');
                            $data['message'] = trans('admin.order.not_enough');

                            return json_encode($data);
                        }
                    } else {
                        $data['status'] = config('setting.http_status.error');
                        $data['message'] = trans('product_not_exists');

                        return json_encode($data);
                    }
                }
                $this->orderRepo->update($id, [
                    'status' => config('order.status.approved'),
                ]);
                $data['id'] = $order->id;
                $data['approved'] = trans('admin.approved');
                $user = $this->userRepo->find($order->user_id);
                $notification = [
                    'order_id' => $order->id,
                    'title' => 'admin.notification.order_approved.title',
                    'content' => 'admin.notification.order_approved.content',
                ];
                $user->notify(new CensoredOrderNotification($notification));
                DB::commit();

                return json_encode($data);
            } else {
                $data['status'] = config('setting.http_status.serve');
                $data['message'] = trans('admin.order.approved_error');

                return  json_encode($data);
            }
        } catch (Exception $exception) {
            DB::rollBack();
            $data['status'] = config('setting.http_status.error');
            $data['message'] = trans('message_errors');

            return json_encode($data);
        }
    }

    public function rejectedOrder($id)
    {
        DB::beginTransaction();
        $data = [
            'status' => config('setting.http_status.success'),
            'message' => trans('message_success'),
        ];
        try {
            $order = $this->orderRepo->find($id, ['productDetails']);
            if ($order->status != config('order.status.rejected')
                && $order->status != config('order.status.approved')) {
                $this->orderRepo->update($order->id, [
                   'status' => config('order.status.rejected')
                ]);
                $data['id'] = $order->id;
                $data['rejected'] = trans('admin.rejected');
                $user = $this->userRepo->find($order->user_id);
                $notification = [
                    'order_id' => $order->id,
                    'title' => 'admin.notification.order_rejected.title',
                    'content' => 'admin.notification.order_rejected.content',
                ];
                $user->notify(new CensoredOrderNotification($notification));
                DB::commit();

                return json_encode($data);
            } elseif ($order->status == config('order.status.approved')) {
                $productDetails = $order->productDetails;
                foreach ($productDetails as $productDetail) {
                    if ($productDetail->quantity >= $productDetail->pivot->quantity) {
                        $this->productDetailRepo->update($productDetail->id, [
                            'quantity' => $productDetail->quantity + $productDetail->pivot->quantity,
                        ]);
                    }
                }
                $this->orderRepo->update($order->id, [
                    'status' => config('order.status.rejected')
                ]);
                $data['id'] = $order->id;
                $data['rejected'] = trans('admin.rejected');
                $user = $this->userRepo->find($order->user_id);
                $notification = [
                    'order_id' => $order->id,
                    'title' => 'admin.notification.order_rejected.title',
                    'content' => 'admin.notification.order_rejected.content',
                ];
                $user->notify(new CensoredOrderNotification($notification));
                DB::commit();

                return json_encode($data);
            } else {
                $data['status'] = config('setting.http_status.serve');
                $data['message'] = trans('admin.order.rejected_error');

                return  json_encode($data);
            }
        } catch (Exception $exception) {
            DB::rollBack();
            $data['status'] = config('setting.http_status.error');
            $data['message'] = trans('message_errors');

            return json_encode($data);
        }
    }
}
