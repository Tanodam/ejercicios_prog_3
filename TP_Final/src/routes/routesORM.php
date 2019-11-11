<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\Pedido;
use App\Models\ORM\Producto;
use App\Models\ORM\pedidoController;
use App\Models\ORM\productoController;
use App\Models\ORM\cdApi;


include_once __DIR__ . '/../../src/app/modelORM/pedido.php';
include_once __DIR__ . '/../../src/app/modelORM/pedidoController.php';
include_once __DIR__ . '/../../src/app/modelORM/producto.php';
include_once __DIR__ . '/../../src/app/modelORM/productoController.php';

return function (App $app) {
  $container = $app->getContainer();

  $app->group('/pedidos', function () {

    $this->post('/', pedidoController::class . ':CargarUno');
    $this->post('/baja', pedidoController::class . ':BorrarUno');
    $this->post('/modificar', pedidoController::class . ':ModificarUno');
    $this->get('/', pedidoController::class . ':TraerTodos');
    $this->get('/{id}', pedidoController::class . ':TraerUno');
  });

  $app->group('/productos', function () {

    $this->post('/', productoController::class . ':CargarUno');
    $this->post('/baja', productoController::class . ':BorrarUno');
    $this->post('/modificar', productoController::class . ':ModificarUno');
    $this->get('/', productoController::class . ':TraerTodos');
    $this->get('/{id}', productoController::class . ':TraerUno');
  });


  $app->group('/cdORM2', function () {

    $this->get('/', cdApi::class . ':traerTodos');
  });
};
