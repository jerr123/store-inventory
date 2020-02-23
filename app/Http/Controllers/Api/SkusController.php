<?php

namespace App\Http\Controllers\Api;

use App\Models\Sku;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\Api\SkuRequest;
use App\Transformers\SkuTransformer;

class SkusController extends Controller
{
    public function store(SkuRequest $request, Sku $sku, Product $product)
    {
        if (!$request->product_id) {
            $phash = md5($request->name . $request->category_id . $request->description);
            if ($p = Product::where(['hash'=>$phash])->first()) {
                $product = $p;
            } else {
                $product->fill($request->all());
                $product->hash = $phash;
                $product->save();
            }
            $request->offsetSet('product_id', $product->id);
        }
        $skuHash = md5($request->bar_code . $request->unit_id . $request->product_id);
        $sku->fill($request->all());
        if ($s = Sku::where(['sku_hash'=>$skuHash])->first()) {
            return $this->response->error('该sku已经存在', 400);
        }
        $sku->sku_hash = $skuHash;
        $sku->save();

        return $this->response->item($sku, new SkuTransformer())
            ->setStatusCode(201);
    }

    public function barcodeSearch() {
        $barCode = request('bar_code');
        if (!$sku = Sku::where(['bar_code' => $barCode])->first()) {
            return $this->response->error('未找到或不存在', 404);
        }

        return $this->response->item($sku, new SkuTransformer());
    }

    public function show(Sku $sku)
    {
        return $this->response->item($sku, new SkuTransformer());
    }

    public function index(Request $request, Sku $sku)
    {
        $query = $sku->withOrder($request->order, $request->order_type?:'desc');

        if ($categoryId = $request->category_id) {
            $query = $query->whereHas('product', function($query) use($categoryId) {
                return $query->where('category_id', $categoryId);
            });
        }

        if ($searchKey = $request->searchKey) {
            $query = $query->whereHas('product', function($query) use($searchKey) {
                return $query->where('name', 'like', '%'.$searchKey.'%');
            });
        }
        if ($searchKey = $request->searchKey) {
            $query = $query->orWhere('bar_code', $searchKey);
        }

        $skus = $query->paginate($request->pageSize?:20);

        return $this->response->paginator($skus, new SkuTransformer());
    }

    public function update(SkuRequest $request, Product $product, Sku $sku)
    {
        // if (!$product->id) {
        //     $phash = md5($request->name . $request->category_id . $request->description);
        //     if ($p = Product::where(['hash'=>$phash])->first()) {
        //         $product = $p;
        //     } else {
        //         $product->fill($request->all());
        //         $product->hash = $phash;
        //         $product->save();
        //     }
        //     $request->offsetSet('product_id', $product->id);
        // }
        $phash = md5($request->name . $request->category_id . $request->description);
        if (!$p = Product::where(['hash'=>$phash])->first()) {
            $product->fill($request->all());
            $product->hash = $phash;
            $product->save();
        } else {
            if ($p->id !== $product->id) {
                return $this->response->error('已经存在该spu', 400);
            } else {
                $product->fill($request->all());
                $product->save();
            }
        }
        $request->offsetSet('product_id', $product->id);
        $skuHash = md5($request->bar_code . $request->unit_id . $request->product_id);
        $sku->fill($request->all());
        if (!$s = Sku::where(['sku_hash'=>$skuHash])->first()) {
            $sku->sku_hash = $skuHash;
            $sku->save();
        } else {
            if ($s->id !== $sku->id) {
                return $this->response->error('已经存在该sku', 400);
            } else {
                $sku->save();
            }
        }
        return $this->response->item($sku, new SkuTransformer());
    }
}
