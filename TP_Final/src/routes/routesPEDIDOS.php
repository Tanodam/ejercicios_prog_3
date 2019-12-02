<?php

use App\Models\ORM\pedido_productoController;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\pedidoController;

include_once __DIR__ . '/../../src/app/modelORM/pedidoController.php';
include_once __DIR__ . '/../../src/app/modelORM/pedido_productoController.php';
return function (App $app) {


    $app->group('/pedidos', function () {

        $this->post('/', pedidoController::class . ':CargarUno')->add(Middleware::class . ":EsMozo")
        ->add(Middleware::class . ":validarToken");

        $this->post('/baja', pedidoController::class . ':BorrarUno');
        
        $this->post('/modificar', pedidoController::class . ':ModificarUno');
        
        $this->get('/', pedidoController::class . ':TraerTodos');
        
        $this->get('/traerUno', pedidoController::class . ':TraerUno');

        $this->post('/prepararPedido', pedidoController::class . ':prepararPedido') ->add(Middleware::class . ":validarToken");
        
        $this->post('/terminarPedido', pedidoController::class . ':terminarPedido') ->add(Middleware::class . ":validarToken");

        $this->post('/servirPedido', pedidoController::class . ':servirPedido')->add(Middleware::class . ":EsMozo")
        ->add(Middleware::class . ":validarToken");;

        $this->get('/pedirCuenta', pedidoController::class . ':pedirCuenta')->add(Middleware::class . ":EsMozo")
        ->add(Middleware::class . ":validarToken");;

        $this->get('/cobrar', pedidoController::class . ':cobrar')->add(Middleware::class . ":EsMozo")
        ->add(Middleware::class . ":validarToken");;

    });
};
