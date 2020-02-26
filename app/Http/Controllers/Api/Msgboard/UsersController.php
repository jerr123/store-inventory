<?php

namespace App\Http\Controllers\Api\Msgboard;

use App\Models\Msgboard\User;
use Illuminate\Http\Request;
use App\Transformers\Msgboard\UserTransformer;

class UsersController extends \App\Http\Controllers\Api\Controller
{
    public function me()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }
}
