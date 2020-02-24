<?php

namespace App\Http\Controllers\Api;

use App\Models\SalesRecord;
use App\Http\Requests\Api\SalesRecordRequest;
use App\Transformers\SalesRecordTransformer;

class SalesRecordsController extends Controller
{
    public function store(SalesRecordRequest $request, SalesRecord $salesRecord)
    {
        // 通过 sku_id 或者 bar_code 找 sku
        if ($sku_id = $request->sku_id) {
            $sku = Sku::find($sku_id);
        }
        if ($bar_code = $request->bar_code) {
            $sku = Sku::where('bar_code', $bar_code)->first();
        }
        if (false == $sku) $this->response->error('必须有sku', 400);

        $salesRecord->cost_price = $sku->cost_price;
        $salesRecord->sell_price = $sku->sell_price;

        $salesRecord->fill($request->all());
        $salesRecord->save();

        return $this->response->item($salesRecord, new SalesRecordTransformer())
            ->setStatusCode(201);
    }
}
