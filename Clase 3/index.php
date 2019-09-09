<?php
    INCLUDE './clases/persona.php';
    INCLUDE './clases/personaDao.php';

   // $archivo = fopen("./prueba.txt", "a");
   // $rta=fwrite($archivo,"hol1a");
   // fclose($archivo);


    $request = ($_SERVER['REQUEST_METHOD']);

    $dao = new personaDao();
switch($request){
    case "POST" : 
        if(isset($_POST["Nombre"]) && isset($_POST["Apellido"]) && isset($_POST["Legajo"]))
        {
            $persona = new Persona($_POST["Nombre"], $_POST["Apellido"], $_POST["Legajo"]);
            $dao->guardar($persona);

        }
        break;
    case "GET" :

        break;
       
        
}

?>