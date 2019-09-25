<?php
class InscripcionController
{
    //TODO deberia ser estatico la clase y el atributo
    public $inscripcionesDao;
    public $materiasDao;

    public function __construct()
    {
        $this->inscripcionesDao = new GenericDao('./inscripciones.txt');
        $this->materiasDao = new GenericDao('./materias.txt');
        $this->alumnosDao = new GenericDao('./alumnos.txt');
    }

    function inscribirAlumno($nombreAlumno, $apellidoAlumno, $emailAlumno, $nombreMateria, $codigoMateria) {
        $materiaObtenida = $this->materiasDao->obtenerPorId("codigo", $codigoMateria);
        $alumnoObtenido = $this->alumnosDao->obtenerPorId("email", $emailAlumno);
        $alumnoYaInscripto =  $this->inscripcionesDao->getByAttributeCaseInsensitive("emailAlumno", $emailAlumno);
        if(!is_null($materiaObtenida) && $materiaObtenida->cupo > 0 && !is_null($alumnoObtenido) && is_null($alumnoYaInscripto)){
            $inscripcion = new Inscripcion($nombreAlumno, $apellidoAlumno, $emailAlumno, $nombreMateria, $codigoMateria);
            $rta = $this->inscripcionesDao->guardar($inscripcion);
            if ($rta === true) {
                $materiaObtenida->cupo--;
                $rta = $this->materiasDao->modificar("codigo",$codigoMateria, "cupo", $materiaObtenida->cupo);
                if($rta === true)
                {
                    echo 'Se inscribio el alumno';
                }
                else
                {
                    echo 'Hubo un error al restar el cupo de la materia';
                }
            } else {
                echo 'Hubo un error al inscribir el alumno';
            }
        }
        else
        {
            echo 'Hubo un error al inscribir el alumno  ';
        }
    }
    function mostrarInscripciones(){
        $rta = $this->inscripcionesDao->listar();
        if ($rta !== null) {
            echo $rta;
        } else {
            echo 'Hubo un error al mostrar la informacion';
        }
    }

    function mostrarInscripcionesFiltro($GET){
        $rta = "";
        if(array_key_exists("codigoMateria", $GET) && !array_key_exists("apellidoAlumno", $GET)) //poner primero el campo que esta en null para que no salte error por Undefined index
        {
            $rta = "Alumnos filtrados por materia\n</br>" . $this->inscripcionesDao->getByAttributeCaseInsensitive("codigoMateria", $GET["codigoMateria"]);
        }
        elseif(array_key_exists("apellidoAlumno", $GET) && !array_key_exists("codigoMateria", $GET))
        {
            $rta = "Alumnos filtrados por apellido\n</br>" . $this->inscripcionesDao->getByAttributeCaseInsensitive("apellidoAlumno", $GET["apellidoAlumno"]);
        }
        elseif(array_key_exists("apellidoAlumno", $GET) && array_key_exists("codigoMateria", $GET))
        {
            $rta = "no se pueden filtrar los campos apellido y materia juntos";
        }

        echo $rta;
    }
}