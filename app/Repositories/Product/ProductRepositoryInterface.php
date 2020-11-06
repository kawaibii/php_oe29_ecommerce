<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function getCountImageAndProductDetail();

    public function getRelated($id, $data);
}
