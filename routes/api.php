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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});

$api = app('Dingo\Api\Routing\Router');


$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api'
], function($api) {
    // 短信验证码
    $api->get('version', function() {
        return response('this is version v1');
    });

    $api->get('roots/{root}', 'RootController@show')->name('api.RootController.show');

    $api->post('word', 'WordController@show')
        ->name('api.WordController.show');

    $api->post('wordsearch', 'WordController@wordsearch')
          ->name('api.WordController.wordsearch');

    $api->post('sentence', 'SentenceController@show')
        ->name('api.SentenceController.show');

    $api->post('sentenceSearch', 'SentenceController@search')
          ->name('api.SentenceController.search');

    $api->post('star', 'WordController@star')
          ->name('api.WordController.apistar');

    $api->group([
                 'middleware' => 'api.throttle',
                 'limit' => config('api.rate_limits.sign.limit'),
                 'expires' => config('api.rate_limits.sign.expires'),
             ], function($api) {
                 // 短信验证码
                 $api->post('verificationCodes', 'VerificationCodesController@store')
                     ->name('api.verificationCodes.store');
                 // 用户注册
                 $api->post('users', 'UsersController@store')
                     ->name('api.users.store');
                     // 图片验证码
                 $api->post('captchas', 'CaptchasController@store')
                     ->name('api.captchas.store');

                     // 第三方登录
                $api->post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
                     ->name('api.socials.authorizations.store');
                     // 登录
                $api->post('authorizations', 'AuthorizationsController@store')
                      ->name('api.authorizations.store');
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
    });


});

$api->version('v2', function($api) {
    $api->get('version', function() {
        return response('this is version v2');
    });
});



Route::get('/posts', 'PostsController@index');

Route::post('/query/', 'WordController@queryapi')->name('wordqueryapi');
Route::get('/root/', 'RootController@queryapi')->name('rootqueryapi');
Route::get('/sentence/', 'SentenceController@queryapi')->name('sentencequeryapi');

Route::any('/praise/', 'WordTipController@praise')->name('tipspraise');
