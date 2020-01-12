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
    $router->get('chamados/aberto', 'ChamadoController@getAllAberto');
    $router->get('chamados/aberto/hoje', 'ChamadoController@getAllAbertoHoje');
    $router->get('chamados/pendente', 'ChamadoController@getAllPendente');
    $router->get('chamados/concluido/hoje', 'ChamadoController@getAllConcluidoHoje');

    $router->get('chamado/{id}', 'ChamadoController@get');
    $router->post('chamado/criar', 'ChamadoController@store');
    $router->put('chamado/atualizar/{id}', 'ChamadoController@update');
});