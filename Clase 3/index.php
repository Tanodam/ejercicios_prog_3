<?php
    INCLUDE './clases/persona.php';

   // $archivo = fopen("./prueba.txt", "a");
   // $rta=fwrite($archivo,"hol1a");
   // fclose($archivo);


    $request = ($_SERVER['REQUEST_METHOD']);


switch($request){
    case "POST" : 
        if(isset($_POST["Nombre"]) && isset($_POST["Apellido"]))
        {
            $archivo = fopen("./prueba.txt", "a");
            $rta=fwrite($archivo, PHP_EOL.$_POST["Nombre"]. ' - '. $_POST["Apellido"]);
            $rta2=fclose($archivo);
        }
        break;
    case "GET" :
        $archivo = fopen("./prueba.txt", "r");
        while(!feof($archivo))
        {
            //echo fgets($archivo);
            $personaAux = explode(' - ', fgets($archivo));
            $persona = new Persona($personaAux[0], $personaAux[1]);
            $persona->saludar();
        }
        $rta2=fclose($archivo);
        break;
       
        
}

?>