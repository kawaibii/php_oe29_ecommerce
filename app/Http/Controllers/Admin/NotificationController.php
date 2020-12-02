<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Service\FirebaseService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationRepo, $orderRepo;

    function __construct(NotificationRepositoryInterface $notificationRepo, OrderRepositoryInterface $orderRepo)
    {
        $this->notificationRepo = $notificationRepo;
        $this->orderRepo = $orderRepo;
    }

    public function showDetailOrder($id)
    {
        $notification = $this->notificationRepo->find($id);
        $notification->update(['read_at' => now()]);
        $userId = $notification->notifiable->id;
        $firebase = new FirebaseService();
        $status = [
            'status' => config('order.status.approved')
        ];
        $firebase->getDatabase()->getReference('user/' . $userId)->update($status);
        $detailOrder = $this->orderRepo->find(json_decode($notification->data)->order_id);
        $orders = $this->orderRepo->orderBy('status', 'productDetails');

        return view('admin.orders.index', compact('detailOrder', 'orders'));
    }
}
