<?php

namespace App\Http\Requests\Api;

class CategoryRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string',
                    'description' => 'string',
                ];
                break;
            case 'PATCH':
                return [
                    'name' => 'string',
                    'description' => 'string',
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
            'name' => '名称',
            'description' => '描述',
        ];
    }
}
