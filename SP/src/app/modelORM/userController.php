<?php

namespace App\Models\ORM;

use App\Models\ORM\User;
use App\Models\ORM\Password;
use App\Models\AutentificadorJWT;
use App\Models\ORM\Ingreso;
use App\Models\ORM\Egreso;

include_once __DIR__ . '/user.php';
include_once __DIR__ . '/password.php';
include_once __DIR__ . '/ingreso.php';
include_once __DIR__ . '/egreso.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';
include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class userController
{
  public function CargarUno($request, $response, $args)
  {
    $arrayDeParametros = $request->getParsedBody();
    $arrayArchivos = $request->getUploadedFiles();

    if ( 
      array_key_exists("email", $arrayDeParametros) && array_key_exists("clave", $arrayDeParametros)
      && array_key_exists("legajo", $arrayDeParametros) && array_key_exists("fotoUno", $arrayArchivos)
      && array_key_exists("fotoDos", $arrayArchivos) && !User::where('legajo', '=', $arrayDeParametros["legajo"])->exists()
      && !User::where('email', '=', $arrayDeParametros["email"])->exists()
      && $arrayDeParametros["legajo"] > 1 && $arrayDeParametros["legajo"] <= 1000
    ) {

      $clave = Password::hash($arrayDeParametros["clave"]);
      $user = new User;
      $user->email = $arrayDeParametros["email"];
      $user->legajo = $arrayDeParametros["legajo"];
      $user->clave = $clave;
      //Foto Uno
      $extension = $arrayArchivos["fotoUno"]->getClientFilename();
      $extension = explode(".", $extension);
      $filenameUno = "./images/users/" . $user->email . "1." . $extension[1];
      $arrayArchivos["fotoUno"]->moveTo($filenameUno);
      $user->fotoUno =  $filenameUno;
      //Foto Dos
      $extension = $arrayArchivos["fotoDos"]->getClientFilename();
      $extension = explode(".", $extension);
      $filenameDos = "./images/users/" . $user->email . "2." . $extension[1];
      $arrayArchivos["fotoDos"]->moveTo($filenameDos);
      $user->fotoDos =  $filenameDos;

      $user->save();

      $userAMostrar = User::find($user->id);
      unset($userAMostrar["clave"]);
      unset($userAMostrar["created_at"]);
      unset($userAMostrar["updated_at"]);
      $newResponse = $response->withJson($userAMostrar, 200);
    } else {
      $newResponse = $response->withJson("Ocurrio un error al generar el nuevo usuario. Verificar", 200);
    }
    return $newResponse;
  }

  public function IniciarSesion($request, $response)
  {
    $arrayDeParametros = $request->getParsedBody();
    $user = User::where('legajo', '=', $arrayDeParametros["legajo"])
      ->select("users.id", "email", "legajo", "clave")
      ->get()
      ->toArray();
    $claveDecodificada = Password::verify($arrayDeParametros["clave"], $user[0]["clave"]);
    $emailValido = strcasecmp($user[0]["email"], $arrayDeParametros["email"]);


    if (count($user) == 1 && $claveDecodificada == 1 && $emailValido == 0) {
      unset($user[0]["clave"]);
      if ($arrayDeParametros["legajo"] < 100 && $arrayDeParametros["legajo"] > 0) {
        $user[0]["rol"] = "admin";
      } else {
        $user[0]["rol"] = "user";
      }
      $token = AutentificadorJWT::CrearToken($user[0]);
      $newResponse = $response->withJson($token, 200);
    } else {
      $newResponse = $response->withJson("Ocurrio un error al generar el token", 200);
    }
    return $newResponse;
  }


  public function ingresoUsuario($request, $response, $args)
  {
      $token = $request->getHeader("token")[0];
      $data = AutentificadorJWT::ObtenerData($token);
      $ingreso = new Ingreso;
      $ingreso->usuario = $data->email;
      $ingreso->legajo = $data->legajo;
      //Asi obtengo el ultimo Ingreso::where("usuario", "=", $data->email)->latest('created_at')->get()->first()->toArray();
      $contadorIngresos = Ingreso::where("usuario", "=", $data->email)->select('created_at')->get()->toArray();
      $contadorEgresos = Egreso::where("usuario", "=", $data->email)->select('created_at')->get()->toArray();
      if(count($contadorEgresos) == count($contadorIngresos))
      {
        $ingreso->save();
        $newResponse = $response->withJson("Usuario ingresado correctamente", 200);
      }
      else
      {
        $newResponse = $response->withJson("El usuario ya tiene una sesion iniciada", 200);
      }
      return $newResponse;  
      
  }
  public function egresoUsuario($request, $response, $args)
  {
      $token = $request->getHeader("token")[0];
      $data = AutentificadorJWT::ObtenerData($token);
      $egreso = new Egreso;
      $egreso->usuario = $data->email;
      $egreso->legajo = $data->legajo;
      $contadorIngresos = Ingreso::where("usuario", "=", $data->email)->select('created_at')->get()->toArray();
      $contadorEgresos = Egreso::where("usuario", "=", $data->email)->select('created_at')->get()->toArray();
      //No se puede egresar un usuario si no existe un ingreso previo o si la cantidad de ingresos es menor a la de egresos
      if(count($contadorIngresos) <= count($contadorEgresos))
      {
        $newResponse = $response->withJson("El usuario no inició sesion", 200);
      }
      else{
        $egreso->save();
        $newResponse = $response->withJson("Usuario egresado correctamente", 200);
      }
      return $newResponse;  
      
    }
}
