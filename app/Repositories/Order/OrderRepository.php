<?php

namespace App\Repositories\Order;

use App\Repositories\BaseRepository;
use App\Models\Order;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }

    public function orderBy($column, $attributes = [])
    {
        $result = $this->model->orderBy($column)->withCount($attributes)->get();

        return $result;
    }

    public function attach($orderId, $productId, $attributes = [])
    {
        $order = Order::findOrFail($orderId);

        return  $order->productDetails()->attach($productId, $attributes);
    }

    public function detach($orderId, $productId)
    {
        $order = Order::findOrFail($orderId);
        if ($order) {
            return $order->productDetails()->detach($productId);
        }

        return false;
    }
}
