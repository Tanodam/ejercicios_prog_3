<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\pedido;
use App\Models\ORM\pedidoController;
use App\Models\ORM\cdApi;
use App\Models\ORM\pedido_producto;

include_once __DIR__ . '/../../src/app/modelORM/pedido.php';
include_once __DIR__ . '/../../src/app/modelORM/pedido_producto.php';
include_once __DIR__ . '/../../src/app/modelORM/pedidoController.php';

return function (App $app) {
  $container = $app->getContainer();

  $app->group('/pedidos', function () {

    $this->post('/', pedidoController::class . ':CargarUno');
    $this->post('/baja', pedidoController::class . ':BorrarUno');
    $this->post('/modificar', pedidoController::class . ':ModificarUno');
    $this->get('/', pedidoController::class . ':TraerTodos');
    $this->get('/{id}', pedidoController::class . ':TraerUno');
  });


  $app->group('/cdORM2', function () {

    $this->get('/', cdApi::class . ':traerTodos');
  });
};
