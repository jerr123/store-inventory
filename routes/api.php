<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings']
], function ($api) {

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {
        // 小程序登录
        $api->post('weapp/authorizations', 'AuthorizationsController@weappStore')
            ->name('api.weapp.authorizations.store');
        // 小程序注册
        $api->post('weapp/users', 'UsersController@weappStore')
            ->name('api.weapp.users.store');
        // 刷新token
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.update');
        // 删除token
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('api.authorizations.destroy');
        $api->get('users/{user}', 'UsersController@show')
            ->name('api.users.show');

        // 需要 token 的的接口
        $api->group(['middleware' => 'api.auth'], function($api) {
            // 当前登录用户信息
            $api->get('current-user', 'UsersController@me')
            ->name('api.user.show');

            // 新增sku
            $api->post('skus', 'SkusController@store')
                ->name('api.skus.store');
            // 获取skus
            $api->get('skus', 'SkusController@index')
                ->name('api.skus.index');
            // 获取sku
            $api->get('skus/{sku}', 'SkusController@show')
                ->name('api.skus.show');
            // 新增product
            $api->post('products', 'ProductsController@store')
                ->name('api.products.store');
        });
    });

});
