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
        $materiaExistente = $this->materiasDao->getAttributeByKeyCaseInsensitive("codigo", $codigo);
        if (is_null($materiaExistente)) {
            $this->materiasDao->guardar($materia);
            echo 'Se cargo la materia ' . $materia->nombre;
        } else {
            echo 'Hubo un error al guardar';
        }
    }
    
}