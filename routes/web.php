<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1/'], function () use ($router) {
    $router->get('chamados/aberto/hoje', 'ChamadoController@getAllAbertoHoje');

    $router->get('chamado/', 'ChamadoController@getChamadoStatus');

    $router->get('chamado/{id}', 'ChamadoController@get');

    $router->post('aluno', 'ChamadoController@getAluno');

    $router->post('chamado/criar', 'ChamadoController@store');

    $router->patch('chamado/atualizar/{id}', 'ChamadoController@update');

    $router->post('enviaremail/resposta/{id}', 'ChamadoController@SendEmail');

});
