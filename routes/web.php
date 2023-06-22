<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\PostController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api'], function () use ($router) 
{
    $router->group(['middleware' => 'hasToken'], function () use ($router)
    {
        $router->get('/posts', 'PostController@index');
        $router->post('/posts', 'PostController@store');
        $router->get('/posts/{id}', 'PostController@show');
        $router->put('/posts/{id}', 'PostController@update');
        $router->delete('/posts/{id}', 'PostController@destroy');
    });

    $router->get('/users', function ()
    {
        return response()->json(
            User::all()
        );
    });
});