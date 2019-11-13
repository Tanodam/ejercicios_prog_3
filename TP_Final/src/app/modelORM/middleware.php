<?php


namespace App\Models\ORM;
use App\Models\AutentificadorJWT;

include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';



class Middleware
{
	public function validarToken($request,$response,$next){
        
		$parametros=$request->getParsedBody();
        $token = $parametros["token"];

        if(count($token) > 0){
            if(AutentificadorJWT::VerificarToken($token)){
                $newResponse = $next($request,$response);
            }else{
                $newResponse = $response->withJson("Token invalido",200);
            }
        }else{
            $newResponse = $response->withJson("No se ha recibido un token. Verificar",200);
        }
        return $newResponse;
    }

    public function EsSocio($request,$response,$next){
        
		$parametros=$request->getParsedBody();
        $token = $parametros["token"];

        if(count($token) > 0){
            $data = AutentificadorJWT::ObtenerData($token);
            if($data->cargo == "socio")
            {
                $newResponse = $response->withJson("Es Socio",200);
            }
            else{
                $newResponse = $response->withJson("Esta accion solo la puede cumplir un socio",200);
            }

        }else{
            $newResponse = $response->withJson("No se ha recibido un token. Verificar",200);
        }
        return $newResponse;
    }



}
