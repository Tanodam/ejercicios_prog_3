<?php

namespace App\Models\ORM;

use App\Models\ORM\Pedido;
use App\Models\IApiControler;

include_once __DIR__ . '/pedido.php';
include_once __DIR__ . '/producto.php';
include_once __DIR__ . '/pedido_producto.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class pedidoController implements IApiControler
{
  public function Beinvenida($request, $response, $args)
  {
    $response->getBody()->write("GET => Bienvenido!!! ,a UTN FRA SlimFramework");

    return $response;
  }

  public function TraerTodos($request, $response, $args)
  {
    $todosLasPedidos = Pedido::all();
    if($todosLasPedidos != null)
    {
      $newResponse = $response->withJson($todosLasPedidos, 200);
    }
    else
    {
      $newResponse = $response->withJson("No hay pedidos", 200);
    }
    return $newResponse;
  }
  public function TraerUno($request, $response, $args)
  {
    //complete el codigo
    $id = $args["id"];
    $pedido = Pedido::find($id);
    if($pedido != null)
    {
      $newResponse = $response->withJson($pedido, 200);
    }
    else
    {
      $newResponse = $response->withJson("No existe pedido con ese ID", 200);
    }
    return $newResponse;
  }

  public function CargarUno($request, $response, $args)
  {
    $productoExistente = null;
    $arrayDeProductosExistentes = "";
    $arrayDeParametros = $request->getParsedBody();
    $pedidoNuevo = new Pedido;
    $pedidoNuevo->idEstadoPedido = 1;
    $pedidoNuevo->codigoMesa = $arrayDeParametros["codigoMesa"];
    $pedidoNuevo->productos = $arrayDeParametros["productos"];
    $pedidoNuevo->idEncargado = $arrayDeParametros["idEncargado"];
    $pedidoNuevo->nombreCliente = $arrayDeParametros["nombreCliente"];
    $archivos = $request->getUploadedFiles();
    $pedidoNuevo->imagen = $archivos["imagen"]->file;
    $pedidoNuevo->tiempo  = $arrayDeParametros["tiempo"];
    $pedidoNuevo->save();
    $idPedidoCargado = $pedidoNuevo->id;
    $productos = explode(",", $arrayDeParametros["productos"]);
    for ($i = 0; $i < count($productos); $i++) {
      $productoExistente = Producto::find($productos[$i]);
      if($productoExistente != null)
      {
        if($i == 0)
        {
          $arrayDeProductosExistentes = $arrayDeProductosExistentes.$productos[$i];
        }
        else
        {
          $arrayDeProductosExistentes = $arrayDeProductosExistentes . ",".$productos[$i];
        }
        $pedido_producto = new pedido_producto;
        $pedido_producto->idPedido = $idPedidoCargado;
        $pedido_producto->idProducto = $productos[$i];
        $pedido_producto->save();
      }
      else{
        echo 'El producto '. $productos[$i] . ' no existe';
      }
    }
    //Actualizado la verdadera cantidad de productos existentes
    $pedidoNuevo->productos = $arrayDeProductosExistentes;
    $pedidoNuevo->save();
    $newResponse = $response->withJson('Pedido ' . $idPedidoCargado . ' cargado', 200);
    return $newResponse;
  }
  public function BorrarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $id = $parametros['id'];
    $pedido = Pedido::find($id);
    if($pedido != null)
    {
      $pedido->delete();
      pedido_producto::where("idPedido", "=", $id)->delete();
      $newResponse = $response->withJson('Pedido ' . $id . ' borrado', 200);
    }
    else
    {
      $newResponse = $response->withJson('El pedido no existe', 200);
    }
    return $newResponse;
  }

  public function ModificarUno($request, $response, $args)
  {
    $arrayDeParametros = $request->getParsedBody();
    $id = null;
    $pedido = null;
    $contadorModificaciones = 0;
    $archivos = [];
    if (array_key_exists("id", $arrayDeParametros)) {
      $id = $arrayDeParametros['id'];
      $pedido = Pedido::find($id);
      $archivos = $request->getUploadedFiles();
    }
    if (array_key_exists("codigoMesa", $arrayDeParametros) && $id != null && $pedido != null) {
      $pedido->codigoMesa = $arrayDeParametros["codigoMesa"];
      $contadorModificaciones++;
    }
    if (array_key_exists("productos", $arrayDeParametros) && $id != null && $pedido != null) {
      $pedido->Productos = $arrayDeParametros["productos"];
      $contadorModificaciones++;
      //Borra el pedido de productos antiguo y lo reemplaza por el nuevo en 
      //la tabla producto_pedido
      pedido_producto::where("idPedido", "=", $id)->delete();
      $productos = explode(",", $arrayDeParametros["productos"]);
      for ($i = 0; $i < count($productos); $i++) {
        $pedido_producto = new pedido_producto;
        $pedido_producto->idPedido = $pedido->id;
        $pedido_producto->idProducto = $productos[$i];
        $pedido_producto->save();
      }
    }

    if (array_key_exists("idEncargado", $arrayDeParametros) && $id != null && $pedido != null) {
      $pedido->idEncargado = $arrayDeParametros["idEncargado"];
      $contadorModificaciones++;
    }

    if (array_key_exists("nombreCliente", $arrayDeParametros) && $id != null && $pedido != null) {
      $pedido->nombreCliente = $arrayDeParametros["nombreCliente"];
      $contadorModificaciones++;
    }

    if (array_key_exists("imagen", $archivos) && $id != null && $pedido != null && $archivos != null) {
      $pedido->imagen = $archivos["imagen"]->file;
      $contadorModificaciones++;
    }

    if (array_key_exists("tiempo", $arrayDeParametros) && $id != null && $pedido != null) {
      $pedido->tiempo  = $arrayDeParametros["tiempo"];
      $contadorModificaciones++;
    }
    if ($contadorModificaciones > 0 && $contadorModificaciones <= 4 && $id != null && $pedido != null) {
      $pedido->idEstadoPedido = 1;
      $pedido->save();
      $newResponse = $response->withJson('Pedido ' . $id . ' modificado', 200);
    } else if ($id == null) {
      $newResponse = $response->withJson('No se introducido un id valido', 200);
    } else if ($id != null && $pedido == null) {
      $newResponse = $response->withJson("No hay un pedido con ese ID", 200);
    } else {
      $newResponse = $response->withJson("No se ha modificado ningun campo ", 200);
    }
    return $newResponse;
  }
}
