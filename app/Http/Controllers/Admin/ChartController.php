<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use Carbon\Carbon;

class ChartController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function orderChart()
    {
        return view('admin.pages.charts');
    }

    public function getStatusByMonth()
    {
        $list = [];
        $pendingByMonth = $approvedByMonth = $rejectedByMonth = $canceledByMonth = array_fill(0, 12, 0);
        $orders = $this->orderRepo->getAll();
        $months = $orders->groupBy(function($order) {
            return Carbon::parse($order->created_at)->format('m');
        });
        foreach ($months as $month => $orders) {
            $index = ((int) $month) - 1;
            $pendingByMonth[$index] = $orders->where('status', config('order.status.pending'))->count();
            $approvedByMonth[$index] = $orders->where('status', config('order.status.approved'))->count();
            $rejectedByMonth[$index] = $orders->where('status', config('order.status.rejected'))->count();
            $canceledByMonth[$index] = $orders->where('status', config('order.status.cancelled'))->count();
        }
        array_push($list, [
            'pending' => $pendingByMonth,
            'approved' => $approvedByMonth,
            'rejected' => $rejectedByMonth,
            'canceled' => $canceledByMonth,
        ]);

        return json_encode($list);
    }
}
