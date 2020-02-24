<?php

namespace App\Transformers;

use App\Models\PurchaseRecord;
use League\Fractal\TransformerAbstract;

class PurchaseRecordTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['skus'];

    public function transform(PurchaseRecord $purchaseRecord)
    {
        return [
            'id' => $purchaseRecord->id,
            'sku_id' => $purchaseRecord->sku_id,
            'num' => $purchaseRecord->num,
            'cost_price' => $purchaseRecord->cost_price,
            'sell_price' => $purchaseRecord->sell_price,
            'created_at' => $product->created_at->toDateTimeString(),
            'updated_at' => $product->updated_at->toDateTimeString(),
        ];
    }

    public function includeCategory(Product $product)
    {
        return $this->item($product->category, new CategoryTransformer());
    }

    public function includeSkus(Product $product)
    {
        return $this->collection($product->skus, new SkuTransformer());
    }
}
