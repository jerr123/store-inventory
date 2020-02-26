<?php

namespace App\Http\Requests\Api\Msgboard;

class MessageRequest extends \App\Http\Requests\Api\FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    // 'user_id' => 'required|exists:user,id',
                    'content' => 'required|string',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'content' => 'string',
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
            'content' => '内容',
        ];
    }
}
