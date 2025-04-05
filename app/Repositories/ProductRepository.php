<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function findById(int $id): ?Product
    {
        return Product::find($id);
    }
}
