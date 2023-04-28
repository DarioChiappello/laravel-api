<?php

namespace App\Services;

use App\Models\Product;
use App\Http\Requests\ProductRequest;

class ProductService extends BaseService
{

    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

}
