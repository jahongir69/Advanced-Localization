<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = auth()->user()->products()->get();
        return $this->successResponse($products, __('product.list_success'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = auth()->user()->products()->create($request->validated());
        return $this->successResponse($product, __('product.create_success'));
    }

    public function show(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            return $this->errorResponse(__('product.not_authorized'), 403);
        }

        return $this->successResponse($product, __('product.show_success'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            return $this->errorResponse(__('product.not_authorized'), 403);
        }

        $product->update($request->validated());
        return $this->successResponse($product, __('product.update_success'));
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            return $this->errorResponse(__('product.not_authorized'), 403);
        }

        $product->delete();
        return $this->successResponse([], __('product.delete_success'));
    }
}
