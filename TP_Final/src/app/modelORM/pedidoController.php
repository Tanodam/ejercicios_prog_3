<?php
namespace App\Models\ORM;

use App\Models\ORM\pedido;
use App\Models\IApiControler;

include_once __DIR__ . '/pedido.php';
include_once __DIR__ . '/pedido_producto.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class pedidoController implements IApiControler
{
 	public function Beinvenida($request, $response, $args) {
      $response->getBody()->write("GET => Bienvenido!!! ,a UTN FRA SlimFramework");
    
    return $response;
    }
    
     public function TraerTodos($request, $response, $args) {
       //return cd::all()->toJson();
       $todosLasPedidos=Pedido::all();
       $newResponse = $response->withJson($todosLasPedidos, 200);  
        return $newResponse;
    }
    public function TraerUno($request, $response, $args) {
       //complete el codigo
       $id = $args["id"];
       $todosLasPedidos=Pedido::find($id);
       $newResponse = $response->withJson($todosLasPedidos, 200);  
        return $newResponse;
    }
   
      public function CargarUno($request, $response, $args) {
        $arrayDeParametros = $request->getParsedBody();
        $pedidoNuevo = new Pedido;
        $pedidoNuevo->idEstadoPedido = 1;
        $pedidoNuevo->codigoMesa = $arrayDeParametros["codigoMesa"];
        $pedidoNuevo->idProductos = $arrayDeParametros["productos"];
        $pedidoNuevo->idEncargado = $arrayDeParametros["idEncargado"];
        $pedidoNuevo->nombreCliente = $arrayDeParametros["nombreCliente"];
        $archivos = $request->getUploadedFiles();
        $pedidoNuevo->imagen = $archivos["imagen"]->file;
        $pedidoNuevo->tiempo  = $arrayDeParametros["tiempo"];
        $pedidoNuevo->save();
        $idPedidoCargado = $pedidoNuevo->id;
        $productos = explode(",", $arrayDeParametros["productos"]);
        for ($i = 0; $i < count($productos); $i++) {
          $pedido_producto = new pedido_producto;
          $pedido_producto->idPedido = $idPedidoCargado;
          $pedido_producto->idProducto = $productos[$i];
          $pedido_producto->save();
         }
         $newResponse = $response->withJson('Pedido '.$idPedidoCargado.' cargado', 200);
        return $newResponse;
    }
    public function BorrarUno($request, $response, $args) {
      //complete el codigo
      $parametros = $request->getParsedBody();
      $id = $parametros['id'];
      $pedido = Pedido::find($id);
      $pedido->delete();
      $newResponse = $response->withJson('Pedido '.$id.' borrado', 200);
      return $newResponse;
    }
     
    public function ModificarUno($request, $response, $args) {
      //Validar cada parametro
     $arrayDeParametros = $request->getParsedBody();
     $id = $arrayDeParametros['id'];
     $pedido = Pedido::find($id);
     $pedido->idEstadoPedido = 1;
     $pedido->codigoMesa = $arrayDeParametros["codigoMesa"];
     $pedido->idProductos = $arrayDeParametros["productos"];
     $pedido->idEncargado = $arrayDeParametros["idEncargado"];
     $pedido->nombreCliente = $arrayDeParametros["nombreCliente"];
     $archivos = $request->getUploadedFiles();
     $pedido->imagen = $archivos["imagen"]->file;
     $pedido->tiempo  = $arrayDeParametros["tiempo"];
     $pedido->save();
     pedido_producto::where("idPedido", "=", $id)->delete();
     $productos = explode(",", $arrayDeParametros["productos"]);
     for ($i = 0; $i < count($productos); $i++) {
      $pedido_producto = new pedido_producto;
      $pedido_producto->idPedido = $pedido->id;
      $pedido_producto->idProducto = $productos[$i];
      $pedido_producto->save();
     }
     $newResponse = $response->withJson('Pedido '.$id.' modificado', 200);
     return $newResponse;
   }


  
}