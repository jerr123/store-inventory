<?php

namespace App\Http\Requests\Api;

class SalesRecordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    // 'bar_code'
                    'sku_id' => 'exists:sku,id',
                    'num' => 'required',
                ];
                break;

            case 'PATCH':
            case 'PUT':
                return [
                    'sku_id' => 'exists:sku,id',
                ];
                break;
        }

    }
}
