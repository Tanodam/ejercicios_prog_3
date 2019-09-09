<?php
    class PersonaDao
    {
        public function __construct()
        {
            session_start();
            if(!isset($_SESSION["Personas"])){
                $_SESSION["Personas"] = array();
            }
        }
        
        function guardar($persona){
            $archivo = fopen("./prueba.txt", "a");
            $rta=fwrite($archivo, PHP_EOL.$persona->Nombre. ' - '.$persona->Apellido. ' - '.$persona->Legajo);
            $rta2=fclose($archivo);
            //array_push($_SESSION["Personas"], $alumno);
        }

        function borrar($personaLegajo){
            foreach($_SESSION["Personas"] as $key => $persona){
                if($persona->legajo == $personaLegajo){
                    unset($_SESSION["Personas"][$key]);
                }
            }
        }

        function listar(){
            $arrayPersona = array();
            $archivo = fopen("./prueba.txt", "r");
            while(!feof($archivo))
            {
                //echo fgets($archivo);
                $personaAux = explode(' - ', fgets($archivo));
                if(count($personaAux) > 1)
                {
                    $persona = new Persona($personaAux[0], $personaAux[1], $personaAux[2]);
                    //$persona->saludar();
                    array_push($arrayPersona, $persona);
                    //echo json_encode($arrayPersona);
                }
            }
            //$arrayAux = json_encode($_SESSION["Personas"]);
            return json_encode($arrayPersona);
        }

        function modificar($personaLegajo, $personaNombre){
            foreach($_SESSION["Personas"] as $key => $persona){
                if($persona->legajo == $personaLegajo){
                    $persona->nombre = $personaNombre;
                }
            }
        }

    }

?>