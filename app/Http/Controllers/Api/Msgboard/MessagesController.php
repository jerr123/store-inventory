<?php

namespace App\Http\Controllers\Api\Msgboard;

use App\Models\Msgboard\Message;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Msgboard\MessageRequest;
use App\Transformers\Msgboard\MessageTransformer;

class MessagesController extends \App\Http\Controllers\Api\Controller
{
    public function index(Request $request)
    {
        $messages = Message::with('user')->orderBy('updated_at', 'desc')->paginate($request->pageSize?:10);

        $yearArr = [];
        $monthDayArr = [];

        foreach ($messages as $message) {
            $ykey = date("Y", strtotime($message->updated_at));
            $mdkey = date("Y-m-d", strtotime($message->updated_at));
            $monthDay = date("m-d", strtotime($message->updated_at));
            if ($ykey != date("Y")) {
                if (!in_array($ykey, $yearArr)) {
                    $ykey = date("Y", strtotime($message->updated_at));
                    $message->year = $ykey;
                    array_push($yearArr, $ykey);
                }
            }
            if (!in_array($mdkey, $monthDayArr)) {
                $mdkey = date("Y-m-d", strtotime($message->updated_at));
                $message->monthDay = $monthDay;
                array_push($monthDayArr, $mdkey);
            }
            $message->time = date("H:i", strtotime($message->updated_at));
        }

        return $this->response->paginator($messages, new MessageTransformer());
    }

    public function store(MessageRequest $request, Message $message)
    {
        $message->fill($request->all());
        $message->user_id = $this->user()->id;
        $message->save();
        return $this->response->item($message, new MessageTransformer())->setStatusCode(201);
    }
}
