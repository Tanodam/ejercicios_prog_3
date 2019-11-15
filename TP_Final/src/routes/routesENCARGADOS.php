<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\encargadoController;



include_once __DIR__ . '/../../src/app/modelORM/encargadoController.php';
//include_once __DIR__ . '/../../src/app/modelORM/middleware.php';
include_once __DIR__ . '/../../src/middleware.php';

return function (App $app) {


    $app->group('/encargados', function () {

        $this->post('/', encargadoController::class . ':CargarUno')->add(Middleware::class . ":EsSocio")
                                                                    ->add(Middleware::class . ":validarToken");

        $this->post('/logIn', encargadoController::class . ':IniciarSesion');

        $this->post('/baja', encargadoController::class . ':BorrarUno');
        
        $this->post('/modificar', encargadoController::class . ':ModificarUno');
        
        $this->get('/', encargadoController::class . ':TraerTodos');
        
        $this->get('/{id}', encargadoController::class . ':TraerUno');
    });
};
