<?php

namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    public function orderBy($column, $attributes = []);

    public function attach($orderId, $productId, $attributes = []);

    public function detach($orderID, $productId);

    public function quantityOrderByStatus($status = []);

    public function getNumberOrderByStatus();
}
