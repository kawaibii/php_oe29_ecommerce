<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Order\OrderRepositoryInterface;

class DashboardController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function index()
    {
        return view('admin.pages.dashboard');
    }

    public function highChart()
    {
        $orders = $this->orderRepo->getNumberOrderByStatus();
        $data = array();
        foreach ($orders as $order) {
            switch ($order->status) {
                case config('order.status.approved') :
                    $data['approved'] = $order->number_order;

                    break;
                case config('order.status.pending') :
                    $data['pending'] = $order->number_order;

                    break;
                case config('order.status.rejected'):
                    $data['rejected'] = $order->number_order;

                    break;
                default :
                    $data['cancel'] = $order->number_order;
            }
        }

        return json_encode($data);
    }
}
