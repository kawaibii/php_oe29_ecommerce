<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    public function getCountImageAndProductDetail()
    {
        $products = Product::withCount(['images', 'productDetails'])->get();

        return $products;
    }

    public function getRelated($id, $data)
    {
        if (count($data) != 0) {
            $products = Product::with($data)->find($id);

            return $products;
        }

        return false;
    }

    public function getLasted()
    {
        $products = Product::with('images')
            ->orderBy('created_at', 'DESC')
            ->take(config('setting.number_product'))
            ->get();

        return $products;
    }
}
