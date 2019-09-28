<?php
class AlumnoController
{
    //TODO deberia ser estatico la clase y el atributo
    public $alumnosDao;

    
    public function __construct()
    {
        $this->alumnosDao = new GenericDao('./alumnos.txt');
    }

    function cargarAlumno($nombre, $apellido, $email, $foto)
    {
        //Valido que el objeto no existe en el objeto   
        $alumnoExistente = $this->alumnosDao->getObjectByKeyCaseInsensitive("email", $email);
        if ($this->isImage($foto) && $this->tamanoValidoEnMb($foto, 2) && is_null($alumnoExistente)) {
            $tmpName = $foto["tmp_name"];
            $extension = pathinfo($foto["name"], PATHINFO_EXTENSION);
            $filename = "./imagenes/" . $email . "." . $extension;
            $rta = move_uploaded_file($tmpName, $filename);
            if ($rta === true) {
                $alumno = new Alumno($nombre, $apellido, $email, $filename);
                $rta = $this->alumnosDao->guardar($alumno);
                if ($rta === true) {
                    echo 'Se cargo el alumno ' . $alumno->nombre . " " . $alumno->apellido;
                } else {
                    echo 'Hubo un error al guardar';
                }
            } else {
                echo 'Hubo un error con la fotos';
            }
        } else {
            echo "No se puede cargar el alumno";
        }
    }

    function consultarAlumno($apellido)
    {
        return $this->alumnosDao->getObjtecsByKeyCaseInsensitive("apellido", $apellido);
    }

    function modificarAlumno($POST, $FILES)
    {
            $alumnoAModificar = $this->alumnosDao->getObjectByKeyCaseInsensitive("email", $POST["email"]);
            if(!is_null($alumnoAModificar))
            {

                /// Me guardo el valor actual de todas la claves del usuario, si el usuario deseará modificarlas, se pisaran.
                $nombreAux = $alumnoAModificar->nombre;
                $apellidoAux = $alumnoAModificar->apellido;
                $fotoAux = $alumnoAModificar->foto;
                if (array_key_exists("apellido", $POST) && $apellidoAux != $POST["apellido"]) {
                    $apellidoAux = $POST["apellido"];
                }
                if (array_key_exists("nombre", $POST)&& $nombreAux != $POST["nombre"]) {
                    $nombreAux = $POST["nombre"];
                }
                if (array_key_exists("foto", $FILES)) {
                    $rta = true;
                    $fechaBkp = date("d-m-Y_H_i");// Me guardo la hora actual
                    $array = explode(".", $alumnoAModificar->foto); //transormo en un array todo lo que este separado por un punto
                    $rutaParaBkp = "./imagenes/backUpFotos/" . 
                    $alumnoAModificar->apellido . $fechaBkp . "." . end($array);//Genero la ruta para almacenar la foto de backup
                    //Backup Imagen
                    rename($alumnoAModificar->foto, $rutaParaBkp);// Hago backup de la foto
                    //Modificacion
                    $tmpName = $FILES["foto"]["tmp_name"];
                    $extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
                    $fotoAux = "./imagenes/" . $POST["email"] . "." . $extension; // Cambio el nombre de la foto y coloco email.extension
                    $rta = move_uploaded_file($tmpName, $fotoAux);
                } 
                if($rta === true)
                {
                    $alumnoAux = new Alumno($nombreAux, $apellidoAux, $POST["email"], $fotoAux);
                    $rta = $this->alumnosDao->modificar("email", $POST["email"], $alumnoAux);
                    if($rta)
                    {
                        echo "Modificacion realizada";
                    }
                    else{
                        echo "No se pudo realizar la modificacion";
                    }
                }
                else
                {
                    echo "Hubo un problema con la foto";
                }
            }
            else{
                echo "No se encontro el alumno";
            }
                
    }

    function mostrarAlumnos()
    {
        echo $this->alumnosDao->listar();
    }

    function isImage($imagen): bool
    {
        if (explode("/", $imagen["type"])[0] == "image") {
            return true;
        } else {
            throw new Exception("No es un archivo de imagen");
        }
    }

    function tamanoValidoEnMb($archivo, $mb): bool
    {
        if (($archivo["size"]) < ($mb * 1024 * 1024)) {
            return true;
        } else {
            throw new Exception("Tamaño maximo $mb mb");
        }
    }
}
