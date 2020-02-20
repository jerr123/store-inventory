<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Requests\Api\ProductRequest;
use App\Transformers\ProductTransformer;

class ProductsController extends Controller
{
    public function store(ProductRequest $request, Product $product)
    {
        $product->fill($request->all());
        $product->save();

        return $this->response->item($product, new ProductTransformer())
            ->setStatusCode(201);
    }
}
