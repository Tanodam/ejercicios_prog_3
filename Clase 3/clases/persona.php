<?php
    class Persona
    {
        public $Nombre;
        public $Apellido;
        public $Legajo;

        public function __construct($Nombre, $Apellido, $Legajo)
        {
            $this->Nombre = $Nombre;
            $this->Apellido = $Apellido;
            $this->Legajo = $Legajo;
        }

        public function saludar()
        {
             echo 'Hola, '.$this->Nombre.' '.$this->Apellido.' '.$this->Legajo;
        }
    }
?>