<?php

namespace App\Http\Controllers\Api;

use App\Models\PurchaseRecord;
use App\Http\Requests\Api\PurchaseRecordRequest;
use App\Transformers\PurchaseRecordTransformer;

class PurchaseRecordsController extends Controller
{
    public function store(PurchaseRecordRequest $request, PurchaseRecord $$purchaseRecord)
    {
        // 通过 sku_id 或者 bar_code 找 sku
        if ($sku_id = $request->sku_id) {
            $sku = Sku::find($sku_id);
        }
        if ($bar_code = $request->bar_code) {
            $sku = Sku::where('bar_code', $bar_code)->first();
        }
        if (false == $sku) $this->response->error('必须有sku', 400);

        $purchaseRecord->cost_price = $sku->cost_price;
        $purchaseRecord->sell_price = $sku->sell_price;

        $purchaseRecord->fill($request->all());
        $purchaseRecord->save();

        return $this->response->item($purchaseRecord, new PurchaseRecordTransformer())
            ->setStatusCode(201);
    }
}
