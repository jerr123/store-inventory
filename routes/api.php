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
        // 刷新token
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.update');
        // 删除token
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('api.authorizations.destroy');

            // Msgboard 小程序登录
        $api->post('msgboard/weapp/authorizations', 'Msgboard\AuthorizationsController@weappStore')
            ->name('api.msgboard.weapp.authorizations.store');
        // 刷新token
        $api->put('msgboard/authorizations/current', 'Msgboard\AuthorizationsController@update')
            ->name('api.msgboard.authorizations.update');
        // 删除token
        $api->delete('msgboard/authorizations/current', 'Msgboard\AuthorizationsController@destroy')
            ->name('api.msgboard.authorizations.destroy');


    });

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {

        $api->group(['middleware' => ['guard:boardmsg_api','api.auth']], function($api) {
            //Msgboard
            $api->get('msgboard/current-user', 'Msgboard\UsersController@me')
                ->name('api.msgboard.user.show');
            $api->get('msgboard/messages', 'Msgboard\MessagesController@index')
                ->name('api.msgboard.messages.index');
            $api->post('msgboard/messages', 'Msgboard\MessagesController@store')
                ->name('api.msgboard.messages.store');
        });
        // 需要 token 的的接口
        $api->group(['middleware' => ['guard:api','api.auth']], function($api) {
            // 当前登录用户信息
            $api->get('current-user', 'UsersController@me')
            ->name('api.user.show');

            // 图片资源
            $api->post('images', 'ImagesController@store')
                ->name('api.images.store');

            // 获取分类
            $api->get('categories', 'CategoriesController@index')
                ->name('api.categories.index');
            // 创建分类
            $api->post('categories', 'CategoriesController@store')
                ->name('api.categories.store');

            // 获取单位
            $api->get('units', 'UnitsController@index')
                ->name('api.units.index');

            // 新增sku
            $api->post('skus', 'SkusController@store')
                ->name('api.skus.store');
            // 更新
            $api->put('products/{product}/skus/{sku}', 'SkusController@update')
                ->name('api.skus.update');
            // 获取skus
            $api->get('skus', 'SkusController@index')
                ->name('api.skus.index');
            // 获取sku
            $api->get('skus/{sku}', 'SkusController@show')
                ->name('api.skus.show');
            // 新增product
            $api->post('products', 'ProductsController@store')
                ->name('api.products.store');

            // 通过 barcode 搜索
            $api->get('skus/barcode/search', 'SkusController@barcodeSearch')
                ->name('api.skus.barcode.search');

        });
    });

});
