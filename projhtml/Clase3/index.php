<?php
    INCLUDE './clases/lote.php';
    INCLUDE './clases/loteDao.php';

   // $archivo = fopen("./prueba.txt", "a");
   // $rta=fwrite($archivo,"hol1a");
   // fclose($archivo);


   $numeroCUFE = $_GET['numerocufe'];
   $numeroSLRG = $_GET['numeroslrg'];

   echo $numeroCUFE." ".$numeroSLRG;
    $request = ($_SERVER['REQUEST_METHOD']);

    $dao = new LoteDao(".\lotemantis.csv");
switch($request){
    case "POST" : 
        if(isset($_POST["Lote"]) && isset($_POST["Numero SLRG"]) && isset($_POST["Numero CUFE"]) && isset($_POST["Nombre SLRG"])&& isset($_POST["Modulo"]))
        {
            $lote = new Lote($_POST["Lote"], $_POST["Numero SLRG"], $_POST["Numero CUFE"],$_POST["Nombre SLRG"],$_POST["Modulo"]);
            //$dao->guardar($lote); 
            $lote->saludar(); 

        }
        break;
    case "GET" :
        $archivo = $dao->listar();
        $array = json_decode($archivo);
        var_dump($archivo);
        break;
       
        
}
