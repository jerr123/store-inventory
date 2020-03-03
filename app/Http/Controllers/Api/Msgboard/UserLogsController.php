<?php

namespace App\Http\Controllers\Api\Msgboard;

use App\Models\Msgboard\UserLog;
use Illuminate\Http\Request;
use App\Transformers\Msgboard\UserTransformer;

class UserLogsController extends \App\Http\Controllers\Api\Controller
{
    public function store(Request $request,UserLog $ulog)
    {
        $ulog->fill($request->all());
        $ulog->user_id = $this->user()->id;
        $ulog->save();
        return $this->response->noContent();
    }
}
