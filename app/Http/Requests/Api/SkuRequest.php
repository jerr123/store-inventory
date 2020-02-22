<?php

namespace App\Http\Requests\Api;

class SkuRequest extends FormRequest
{
    public function rules()
    {
        if ($this->product_id) {
            switch ($this->method()) {
                case 'POST':
                    return [
                        'product_id' => 'required|exists:products,id',
                        'bar_code' => 'required|string',
                        'unit_id' => 'required|exists:units,id',
                        // 'cost_price' => 'required',
                        'sell_price' => 'required',
                    ];
                    break;
                case 'PATCH':
                case 'PUT':
                    return [
                        'product_id' => 'required|exists:products,id',
                        'bar_code' => 'required|string',
                        'unit_id' => 'required|exists:units,id',
                        // 'cost_price' => 'required',
                        'sell_price' => 'required',
                    ];
                break;
            }
        }else {
            switch ($this->method()) {
                case 'POST':
                    return [
                        // spu
                        'name' => 'required|string',
                        'img' => 'required|string',
                        'description' => 'string',
                        // sku
                        'bar_code' => 'required|string',
                        'unit_id' => 'required|exists:units,id',
                        // 'cost_price' => 'required',
                        'sell_price' => 'required',
                    ];
                    break;
                case 'PATCH':
                case 'PUT':
                    return [
                        // spu
                        'name' => 'required|string',
                        'img' => 'string',
                        'description' => 'string',
                        // sku
                        'bar_code' => 'required|string',
                        'unit_id' => 'required|exists:units,id',
                        // 'cost_price' => 'required',
                        'sell_price' => 'required',
                    ];
                break;
            }
        }
    }

    public function attributes()
    {
        return [
            'name' => '名称',
            'img' => '主图',
            'description' => '描述',
            'product_id' => '描述',

            'bar_code' => '条形码',
            'unit_id' => '单位id',
            'cost_price' => '成本价',
            'sell_price' => '销售价格',
        ];
    }
}
