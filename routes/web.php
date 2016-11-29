<?php

/*
|--------------------------------------------------------------------------
| VanillaSSO Routes
|--------------------------------------------------------------------------
|
| This file defines the routes provided by the VanillaSSO Package.
|
*/

Route::group(Config::get('vanillasso.routes.bindings', [
    'middleware' => ['auth', 'web'],
]), function () {
    Route::get(Config::get('vanillasso.endpoint', 'login/forum'), [
            'uses' => 'ReliQArts\VanillaSSO\Http\Controllers\VanillaSSOController@jsonResponse',
            'as'   => 'vanillasso',
    ]);
});
