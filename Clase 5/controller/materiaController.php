<?php
class MateriaController
{
    //TODO deberia ser estatico la clase y el atributo
    public $materiasDao;

    public function __construct()
    {
        $this->materiasDao = new GenericDao('./materias.txt');
    }

    function cargarMateria($nombre, $codigo, $cupo, $aula) {                           
        $materia = new Materia($nombre, $codigo, $cupo, $aula);
        $materiaExistente = $this->materiasDao->getByAttributeCaseInsensitive("codigo", $codigo);
        $rta = $this->materiasDao->guardar($materia);
        if ($rta === true && $materiaExistente === null) {
            echo 'Se cargo la materia ' . $materia->nombre;
        } else {
            echo 'Hubo un error al guardar';
        }
    }
    
}