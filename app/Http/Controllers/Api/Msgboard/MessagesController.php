<?php

namespace App\Http\Controllers\Api\Msgboard;

use Carbon\Carbon;
use App\Models\Msgboard\Message;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Msgboard\MessageRequest;
use App\Transformers\Msgboard\MessageTransformer;

class MessagesController extends \App\Http\Controllers\Api\Controller
{
    public function index(Request $request)
    {
        $messages = Message::with('user')->orderBy('created_at', 'desc')->paginate($request->pageSize?:10);

        $yearArr = [];
        $monthDayArr = [];

        foreach ($messages as $message) {
            $ykey = date("Y", strtotime($message->created_at));
            $mdkey = date("Y-m-d", strtotime($message->created_at));
            $monthDay = date("m-d", strtotime($message->created_at));
            if ($ykey != date("Y")) {
                if (!in_array($ykey, $yearArr)) {
                    $ykey = date("Y", strtotime($message->created_at));
                    $message->year = $ykey;
                    array_push($yearArr, $ykey);
                }
            }
            if (!in_array($mdkey, $monthDayArr)) {
                if (Carbon::now() <= Carbon::parse($message->created_at)->addDays(15)) {
                    $monthDay =  Carbon::parse($message->created_at)->diffForHumans();
                }
                $mdkey = date("Y-m-d", strtotime($message->created_at));
                if (date("Y-m-d") == $mdkey ) {
                    $monthDay =  '今天';
                }
                if (date("Y-m-d", strtotime("-1 day")) == $mdkey ) {
                    $monthDay =  '昨天';
                }
                $message->monthDay = $monthDay;
                array_push($monthDayArr, $mdkey);
            }
            $message->time = date("H:i", strtotime($message->created_at));
            if (Carbon::now() <= Carbon::parse($message->created_at)->addHours(24)) {
                $message->time =  Carbon::parse($message->created_at)->diffForHumans();
            }
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
