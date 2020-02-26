<?php

namespace App\Http\Requests\Api\Msgboard;

class WeappAuthorizationRequest extends \App\Http\Requests\Api\FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|string',
        ];
    }
}
