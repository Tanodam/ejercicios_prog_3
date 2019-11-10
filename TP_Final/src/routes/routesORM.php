<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\pedido;
use App\Models\ORM\cdApi;


include_once __DIR__ . '/../../src/app/modelORM/pedido.php';
include_once __DIR__ . '/../../src/app/modelORM/pedidoController.php';

return function (App $app) {
    $container = $app->getContainer();

     $app->group('/cdORM', function () {   
         
        $this->get('/', function ($request, $response, $args) {
          //return cd::all()->toJson();
          $todosLosCds=pedido::all();
          $newResponse = $response->withJson($todosLosCds, 200);  
          return $newResponse;
        });
    });


     $app->group('/cdORM2', function () {   

        $this->get('/',cdApi::class . ':traerTodos');
   
    });

};