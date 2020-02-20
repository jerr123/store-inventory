<?php

namespace App\Http\Request\Api;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string',
                    'img' => 'required|string',
                    'description' => 'string',
                ];
                break;
            case 'PATCH':
                return [
                    'name' => 'string',
                    'img' => 'string',
                    'description' => 'string',
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
            'name' => '名称',
            'img' => '主图',
            'description' => '描述',
        ];
    }
}
