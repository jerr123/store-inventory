<?php

namespace App\Http\Controllers\Api\Msgboard;

use EasyWeChat\Factory;
use Auth;
use App\Models\Msgboard\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Msgboard\WeappAuthorizationRequest;

class AuthorizationsController extends \App\Http\Controllers\Api\Controller
{
    public function weappStore(WeappAuthorizationRequest $request)
    {
        $code = $request->code;

        $config = [
            'app_id'  => 'wx76f9e723e337ee4a',
            'secret'  => '58e18a4a0bbc1eb8998cd86766623a45',
        ];

        // 根据 code 获取微信 openid 和 session_key
        $miniProgram = Factory::miniProgram($config);
        // $miniProgram = \EasyWeChat::miniProgram();
        $data = $miniProgram->auth->session($code);

        // 如果结果错误，说明 code 已过期或不正确，返回 401 错误
        if (isset($data['errcode'])) {
            return $this->response->errorUnauthorized('code 不正确');
        }

        // 找到 openid 对应的用户
        $user = User::where('weapp_openid', $data['openid'])->first();

        $attributes['weixin_session_key'] = $data['session_key'];

        if (!empty($request->nick))
            $attributes['nick'] = $request->nick;

        if (!empty($request->avatar))
            $attributes['avatar'] = $request->avatar;

        if (!empty($request->gender))
            $attributes['gender'] = $request->gender;

        if (!empty($request->country))
            $attributes['country'] = $request->country;

        if (!empty($request->province))
            $attributes['province'] = $request->province;

        if (!empty($request->city))
            $attributes['city'] = $request->city;

        if (!$user) {
            // 没有用户自动插入用户
            $attributes['weapp_openid'] = $data['openid'];
            $user = new User($attributes);
            $user->save();
            $status_code = 201;
        }else{
            $user->update($attributes);
            $status_code = 201;
        }

        $token = Auth::guard('boardmsg_api')->fromUser($user);

        return $this->respondWithToken($token)->setStatusCode($status_code);
    }

    public function socialStore($type, SocialAuthorizationRequest $request)
    {
        if (!in_array($type, ['weixin'])) {
            return $this->response->errorBadRequest();
        }

        $driver = \Socialite::driver($type);

        try {
            if ($code = $request->code) {
                $response = $driver->getAccessTokenResponse($code);
                $token = array_get($response, 'access_token');
            } else {
                $token = $request->access_token;

                if ($type == 'weixin') {
                    $driver->setOpenId($request->openid);
                }
            }

            $oauthUser = $driver->userFromToken($token);
        } catch (\Exception $e) {
            return $this->response->errorUnauthorized('参数错误，未获取用户信息');
        }

        switch ($type) {
            case 'weixin':
                $unionid = $oauthUser->offsetExists('unionid') ? $oauthUser->offsetGet('unionid') : null;

                if ($unionid) {
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where('weixin_openid', $oauthUser->getId())->first();
                }

                // 没有用户，默认创建一个用户
                if (!$user) {
                    $user = User::create([
                        'name' => $oauthUser->getNickname(),
                        'avatar' => $oauthUser->getAvatar(),
                        'weixin_openid' => $oauthUser->getId(),
                        'weixin_unionid' => $unionid,
                    ]);
                }

                break;
        }

        $token = Auth::guard('boardmsg_api')->fromUser($user);
        return $this->respondWithToken($token)->setStatusCode(201);
    }

    public function update()
    {
        $token = Auth::guard('boardmsg_api')->refresh();
        return $this->respondWithToken($token);
    }

    public function destroy()
    {
        Auth::guard('boardmsg_api')->logout();
        return $this->response->noContent();
    }

    protected function respondWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('boardmsg_api')->factory()->getTTL() * 60
        ]);
    }
}
