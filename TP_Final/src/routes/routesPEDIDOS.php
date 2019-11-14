<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\pedidoController;

include_once __DIR__ . '/../../src/app/modelORM/pedidoController.php';
return function (App $app) {


    $app->group('/pedidos', function () {

        $this->post('/', pedidoController::class . ':CargarUno');

        $this->post('/baja', pedidoController::class . ':BorrarUno');
        
        $this->post('/modificar', pedidoController::class . ':ModificarUno');
        
        $this->get('/', pedidoController::class . ':TraerTodos');
        
        $this->get('/{id}', pedidoController::class . ':TraerUno');
    });
};