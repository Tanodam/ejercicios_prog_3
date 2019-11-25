<?php

use App\Models\ORM\listadoController;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\userController;

include_once __DIR__ . '/../../src/app/modelORM/user.php';
include_once __DIR__ . '/../../src/app/modelORM/userController.php';
include_once __DIR__ . '/../../src/app/modelPDO/listadoController.php';

return function (App $app) {
    $container = $app->getContainer();

     $app->group('/login', function () {   

        $this->post('/',userController::class . ':IniciarSesion')->add(Middleware::class . ":log");
    });

    $app->group('/ingreso', function () {   

        $this->put('/',userController::class . ':ingresoUsuario')->add(Middleware::class . ":log")->add(Middleware::class . ":validarToken");

        $this->get('/ingresosUsuario',listadoController::class . ':traerIngresosUsuarios')->add(Middleware::class . ":log")->add(Middleware::class . ":validarToken");
        
        $this->get('/ingresosAdmin',listadoController::class . ':traerUltimosIngresos')->add(Middleware::class . ":log")->add(Middleware::class . ":validarToken");
    });
    $app->group('/egreso', function () {   

        $this->put('/',userController::class . ':egresoUsuario')->add(Middleware::class . ":log")->add(Middleware::class . ":validarToken");

    });



};