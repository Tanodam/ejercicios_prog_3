<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;


return function (App $app) {
    $container = $app->getContainer();  

    
    $app->group('/cdPDO', function () {   

       $this->get('/', function ($request, $response, $args) {

            return  json_encode(cd::TraerTodoLosCds());
            $todosLosCds=cd::TraerTodoLosCds();
            $newResponse = $response->withJson($todosLosCds, 200);  
            return $newResponse;
        });

    });
   
    $app->group('/cdPDO2', function () {   

        $this->get('/',cdControler::class . ':TraerTodos');   

    });

};
