<?php

namespace App\Transformers;

use App\Models\Sku;
use League\Fractal\TransformerAbstract;

class SkuTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['product', 'unit'];

    public function transform(Sku $sku)
    {
        return [
            'id' => $sku->id,
            'bar_code' => $sku->bar_code,
            'cost_price' => $sku->cost_price,
            'sell_price' => $sku->sell_price,
            'market_price' => $sku->market_price,
            'remark' => $sku->remark,
            'created_at' => $sku->created_at->toDateTimeString(),
            'updated_at' => $sku->updated_at->toDateTimeString(),
        ];
    }

    public function includeProduct(Sku $sku)
    {
        return $this->item($sku->product, new ProductTransformer());
    }

    public function includeUnit(Sku $sku)
    {
        return $this->item($sku->unit, new UnitTransformer());
    }
}
