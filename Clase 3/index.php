<?php
    INCLUDE './clases/persona.php';
    INCLUDE './clases/genericDao.php';

    $request = ($_SERVER['REQUEST_METHOD']);
    
//     // var_dump($_POST);
//  var_dump($_FILES);

  $archivoTmp = $_FILES["imagen"]["name"];
  //Maneras de obtener la extension
  //$extension = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
//  echo "<br> $extension ";
 
 $rta = move_uploaded_file($archivoTmp, "$archivoTmp");

    $dao = new GenericDao('./prueba.txt');
    
    switch($request){
        case "POST" : 
            if(isset($_POST["Nombre"]) && isset($_POST["Apellido"]) && isset($_POST["Legajo"])&& isset($_POST["Imagen"])) {
                $persona = new Persona($_POST["Nombre"], $_POST["Apellido"], $_POST["Legajo"], $_POST["Imagen"]);
                $dao->guardar($persona);
            }
            break;
        case "GET" : 
            echo $dao->listar();
            break;
        
    }
?>