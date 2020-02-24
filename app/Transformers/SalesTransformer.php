<?php

namespace App\Transformers;

use App\Models\SalesRecord;
use League\Fractal\TransformerAbstract;

class SalesRecordTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['skus'];

    public function transform(SalesRecord $salesRecord)
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

    public function includeSkus(SalesRecord $salesRecord)
    {
        return $this->collection($salesRecord->skus, new SkuTransformer());
    }
}
