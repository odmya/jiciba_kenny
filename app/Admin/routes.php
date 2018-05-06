<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    //laravel-admin 后台路由

    $router->resource('users', UserController::class);

    $router->resource('words', WordController::class);
    $router->resource('wordvoices', WordVoiceController::class);
    $router->resource('wordspeeh', WordSpeechController::class);
    $router->resource('root', RootController::class);

    $router->resource('rootcixing', RootcixingController::class);
    $router->resource('sentence', SentenceControllers::class);

    $router->resource('levelbase',LevelBaseController::class);

    $router->resource('novel',NovelController::class);
    $router->resource('novelchapter',NovelChapterController::class);
    $router->resource('novelcontent',NovelContentController::class);
    $router->resource('noveltype',NovelTypeController::class);


$router->any('/rootqueryapi', 'RootcixingController@rootqueryapi')->name('rootqueryapi');
    $router->any('/wordqueryapi', 'RootcixingController@wordqueryapi')->name('wordqueryapi');
    $router->any('/cixinglist', 'WordSpeechController@cixinglist')->name('cixinglist');

    $router->any('/sentencequeryapi', 'SentenceControllers@sentencequeryapi')->name('sentencequeryapi');
$router->any('/levelbasesapi', 'LevelBaseController@levelbasesapi')->name('levelbasesapi');



});
