<?php

namespace App\Transformers\Msgboard;

use App\Models\Msgboard\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['message'];
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'nick' => $user->nick,
            'avatar' => $user->avatar,
            'gender' => $user->gender,
            'country' => $user->country,
            'province' => $user->province,
            'city' => $user->city,
            'bound_wechat' => ($user->weixin_unionid || $user->weixin_openid) ? true : false,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
        ];
    }


    public function includeMessage(User $user)
    {
        return $this->collation($user->messages, new MessageTransformer());
    }
}
