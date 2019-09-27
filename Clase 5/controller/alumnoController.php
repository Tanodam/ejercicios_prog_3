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
        $alumnoExistente = $this->alumnosDao->getAttributeByKeyCaseInsensitive("email", $email);
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
        }
        else{
            echo "No se puede cargar el alumno";
        }
    }

    function consultarAlumno($apellido)
    {
        return $this->alumnosDao->getAttributeByKeyCaseInsensitive("apellido", $apellido);
    }

    function modificarAlumno($email, $POST, $FILES)
    {
        $alumnoAModificar = $this->alumnosDao->getAttributeByKeyCaseInsensitive("email", $email);
        //  var_dump($FILES);
          var_dump($POST);
          //var_dump($alumnoAModificar);
        if (!is_null($alumnoAModificar)) {

            //IMAGEN
            if (!is_null($FILES) && array_key_exists("foto", $FILES)) {
                $fechaBkp = date("d-m-Y_H_i");
                $array = explode(".", $alumnoAModificar->foto); //transormo en un array todo lo que este separado por un punto
                $rutaNueva = "./imagenes/backUpFotos/" . $alumnoAModificar->apellido . $fechaBkp . "." . end($array);
                //Backup Imagen
                rename($alumnoAModificar->foto, $rutaNueva);
                //Modificacion
                $tmpName = $FILES["foto"]["tmp_name"];
                $extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
                $filename = "./imagenes/" . $email . "." . $extension;
                $rta = move_uploaded_file($tmpName, $filename);
                if ($rta === true) {
                    $rta = $this->alumnosDao->modificar("email", $email, "foto", $filename);
                    if ($rta === true) {
                        echo 'Imagen modificada';
                    } else {
                        echo 'Hubo un error al modificar la imagen';
                    }
                } else {
                    echo 'Hubo un error con la imagen';
                }
            }
            // )

            //NOMBRE
            if (array_key_exists("nombre", $POST)) {
                $rta = $this->alumnosDao->modificar("email", $POST["email"], "nombre", $POST["nombre"]);
                if ($rta === true && $alumnoAModificar->nombre !== $POST["nombre"]) {
                    echo PHP_EOL . 'Nombre modificado';
                } else {
                    echo PHP_EOL . 'Hubo un error al modificar el nombre';
                }
            }
            //APELLIDO
            if (array_key_exists("apellido", $POST)) {
                $rta = $this->alumnosDao->modificar("email", $POST["email"], "apellido", $POST["apellido"]);
                if ($rta === true && $alumnoAModificar->apellido !== $POST["apellido"]) {
                    echo PHP_EOL . 'Apellido modificado';
                } else {
                    echo PHP_EOL . 'Hubo un error al modificar el apellido';
                }
            }
        }
        else
        {
            echo "La persona buscada no existe";
        }

    }

    function modificarAlumno2($email, $POST, $FILES)
    {
        
        $alumnoAModificar = $this->alumnosDao->getAttributeByKeyCaseInsensitive("email", $email);
        if (!is_null($alumnoAModificar)){
            $nombreAux = $alumnoAModificar->nombre;
            $apellidoAux = $alumnoAModificar->apellido;
            $fotoAux = $alumnoAModificar->foto;
            if(array_key_exists("apellido", $POST))
            {
                $apellidoAux = $POST["apellido"];
            }
            if(array_key_exists("nombre", $POST))
            {
                $nombreAux = $POST["nombre"];
            }
            $alumnoAux = new Alumno($nombreAux, $apellidoAux, $POST["email"], $fotoAux);
            $this->alumnosDao->modificar2($alumnoAux);

        }

    }

    function mostrarAlumnos(){
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
