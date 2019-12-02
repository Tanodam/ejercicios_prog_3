<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\productoController;

include_once __DIR__ . '/../../src/app/modelORM/productoController.php';
return function (App $app) {

    $app->group('/productos', function () {

        $this->get('/verPendientes', productoController::class . ':verPendientes')->add(Middleware::class . ":validarToken");
            
        $this->post('/', productoController::class . ':CargarUno');

        $this->post('/baja', productoController::class . ':BorrarUno');

        $this->post('/modificar', productoController::class . ':ModificarUno');

        $this->get('/', productoController::class . ':TraerTodos');

        $this->get('/{id}', productoController::class . ':TraerUno');

        
    });
};
