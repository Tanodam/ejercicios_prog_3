<?php
class LoteDao
{
    public $rutaArchivo;
    public function __construct($rutaArchivo)
    {
        $this->rutaArchivo = $rutaArchivo;
        // session_start();
        // if(!isset($_SESSION["Personas"])){
        //     $_SESSION["Personas"] = array();
        // }
    }

    function guardar($object)
    {
        try {
            $objetoJson = $this->listar();
            $arrayJsonDecode = json_decode($objetoJson);
            array_push($arrayJsonDecode, $object);
            $archivo = fopen("./texto.txt", "w");
            fwrite($archivo, json_encode($arrayJsonDecode));
        } catch (Exception $e) {
            throw $e;
        } finally {
            fclose($archivo);
        }
    }

    function borrar($personaLegajo)
    {
        foreach ($_SESSION["Personas"] as $key => $persona) {
            if ($persona->legajo == $personaLegajo) {
                unset($_SESSION["Personas"][$key]);
            }
        }
    }
    function listar()
    {
        $personas = array();
        $archivo = fopen("./lotemantis.csv", "r");
        while (!feof($archivo)) {
            $loteAux = fgetcsv($archivo,250,",");
            echo $loteAux[0]." - ".$loteAux[1]." - ".$loteAux[2]." - ".$loteAux[3]." - ".$loteAux[4]."\n";
            //$lote = new Lote($loteAux[0], $loteAux[1], $loteAux[2], $loteAux[3], $loteAux[4]);
            //array_push($personas, $lote);
            //$lote->saludar();
        }
        fclose($archivo);
        return json_encode($personas);
    }
    // function listar()
    // {
    //     try {
    //         $archivo = fopen($this->rutaArchivo, "r");
    //         return fread($archivo, filesize($this->rutaArchivo));
    //     } catch (Exception $e) {
    //         throw $e;
    //     } finally {
    //         fclose($archivo);
    //     }
    // }
}
