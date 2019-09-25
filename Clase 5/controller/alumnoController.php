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
        if ($this->isImage($foto) && $this->tamanoValidoEnMb($foto, 2)) {
            $tmpName = $foto["tmp_name"];
            $extension = pathinfo($foto["name"], PATHINFO_EXTENSION);
            $filename = "./imagenes/" . $email . "." . $extension;
            $rta = move_uploaded_file($tmpName, $filename);
            if ($rta === true) {
                $alumno = new Alumno($nombre, $apellido, $email, $filename);
                $alumnoExistente = $this->alumnosDao->getByAttributeCaseInsensitive("email", $email);
                $rta = $this->alumnosDao->guardar($alumno);
                if ($rta === true && $alumnoExistente === null) {
                    echo 'Se cargo el alumno ' . $alumno->nombre . " " . $alumno->apellido;
                } else {
                    echo 'Hubo un error al guardar';
                }
            } else {
                echo 'Hubo un error con la fotos';
            }
        }
    }

    function consultarAlumno($apellido)
    {
        return $this->alumnosDao->getByAttributeCaseInsensitive("apellido", $apellido);
    }

    function modificarAlumno($email, $POST, $FILES)
    {
        $alumnoAModificar = $this->alumnosDao->obtenerPorId("email", $email);
        var_dump($FILES);
        //IMAGEN
        if(!is_null($FILES) && array_key_exists("foto", $FILES))
        {
            $fechaBkp = date("d-m-Y_H_i");
            $array = explode(".", $alumnoAModificar->foto); //transormo en un array todo lo que este separado por un punto
            $rutaNueva = "./imagenes/backUpFotos/" .$alumnoAModificar->apellido. $fechaBkp. ".".end($array);
            //Backup Imagen
            echo rename($alumnoAModificar->foto, $rutaNueva);
            //Modificacion
            $tmpName = $FILES["foto"]["tmp_name"];
            $extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
            $filename = "./imagenes/" .$email. "." . $extension;
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
        // !is_null($dao->obtenerPorId("email", $_POST["email"]))

        //NOMBRE
        if (isset($_POST["nombre"])) {
            $rta = $dao->modificar("legajo", $_POST["legajo"], "nombre", $_POST["nombre"]);
            if ($rta === true) {
                echo PHP_EOL . 'Nombre modificado';
            } else {
                echo PHP_EOL . 'Hubo un error al modificar el nombre';
            }
        }
        //APELLIDO
        if (isset($_POST["apellido"])) {
            $rta = $dao->modificar("legajo", $_POST["legajo"], "apellido", $_POST["apellido"]);
            if ($rta === true) {
                echo PHP_EOL . 'Apellido modificado';
            } else {
                echo PHP_EOL . 'Hubo un error al modificar el apellido';
            }
        }
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
