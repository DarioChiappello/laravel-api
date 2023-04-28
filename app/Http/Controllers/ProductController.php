<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\ProductService;
use App\Traits\ApiResponser;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    use ApiResponser;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->all();
        return $this->successResponse($products);
    }

    public function store(ProductRequest $request)
    {
        $validateRequest = $this->productService->validateRequest($request);

        $product = $this->productService->create($request->all());

        return $this->successResponse($product);
    }

    public function show($product)
    {
        $product = $this->productService->find($product);

        return $this->successResponse($product);
    }

    public function update(ProductRequest $request, $product)
    {
        $validateRequest = $this->productService->validateRequest($request);
        $product = $this->productService->update($product, $request->all());
        return $this->successResponse($product);
    }

    public function destroy($product)
    {
        $product = $this->productService->delete($product);

        return $this->successResponse($product); 
    }

}
