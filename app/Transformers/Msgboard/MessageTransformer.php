<?php

namespace App\Transformers\Msgboard;

use App\Models\Msgboard\Message;
use League\Fractal\TransformerAbstract;

class MessageTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user'];
    public function transform(Message $message)
    {
        return [
            'id' => $message->id,
            'content' => $message->content,
            'year' => $message->year ?: false,
            'monthDay' => $message->monthDay ?: false,
            'time' => $message->time,
            'created_at' => $message->created_at->toDateTimeString(),
            'updated_at' => $message->updated_at->toDateTimeString(),
        ];
    }


    public function includeUser(Message $message)
    {
        return $this->item($message->user, new UserTransformer());
    }
}
