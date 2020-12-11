<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Service\FirebaseService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationRepo, $orderRepo, $firebase;

    function __construct(
        NotificationRepositoryInterface $notificationRepo,
        OrderRepositoryInterface $orderRepo,
        FirebaseService $firebase
    ) {
        $this->notificationRepo = $notificationRepo;
        $this->orderRepo = $orderRepo;
        $this->firebase = $firebase;
    }

    public function showDetailOrder($id)
    {
        $notification = $this->notificationRepo->find($id);
        if (!$notification) {
            return redirect()->back();
        }
        $this->notificationRepo->update($id, ['read_at' => now()]);
        $userId = $notification->notifiable->id;
        $status = [
            'status' => config('order.status.approved')
        ];
        $this->firebase->updateNotificationOrder($userId, $status);
        $orderID = json_decode($notification->data)->order_id;
        $detailOrder = $this->orderRepo->find($orderID);
        $orders = $this->orderRepo->orderBy('status', 'productDetails');

        return view('admin.orders.index', compact('detailOrder', 'orders'));
    }
}
