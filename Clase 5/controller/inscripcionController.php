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
        //Valido que la materia exista
        $materiaObtenida = $this->materiasDao->getAttributeByKeyCaseInsensitive("codigo", $codigoMateria);
        //Valido que el alumno exista
        $alumnoObtenido = $this->alumnosDao->getAttributeByKeyCaseInsensitive("email", $emailAlumno);
        if($materiaObtenida->codigo == $codigoMateria && $materiaObtenida->cupo > 0){
            $inscripcion = new Inscripcion($alumnoObtenido->nombre, $alumnoObtenido->apellido, $alumnoObtenido->email, $materiaObtenida->nombre, $codigoMateria);
            $rta = $this->inscripcionesDao->guardar($inscripcion);
            if ($rta === true) {
                //materia con cupo restado
                $cupoRestado = $materiaObtenida->cupo - 1;
                $materiaAux = new Materia($materiaObtenida->nombre, $materiaObtenida->codigo,  (string)$cupoRestado,$materiaObtenida->aula);
                $rta = $this->materiasDao->modificar("codigo",$codigoMateria, $materiaAux);
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
            $rta = "Alumnos filtrados por materia\n" . $this->inscripcionesDao->getAttributesByKeyCaseInsensitive("codigoMateria", $GET["codigoMateria"]);
        }
        elseif(array_key_exists("apellidoAlumno", $GET) && !array_key_exists("codigoMateria", $GET))
        {
            $rta = "Alumnos filtrados por apellido\n" . $this->inscripcionesDao->getAttributesByKeyCaseInsensitive("apellidoAlumno", $GET["apellidoAlumno"]);
        }
        elseif(array_key_exists("apellidoAlumno", $GET) && array_key_exists("codigoMateria", $GET))
        {
            $rta = "no se pueden filtrar los campos apellido y materia juntos";
        }

        echo $rta;
    }
}