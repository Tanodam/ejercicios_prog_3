<?php
    class Persona
    {
        public $Nombre;
        public $Apellido;

        public function __construct($Nombre, $Apellido)
        {
            $this->Nombre = $Nombre;
            $this->Apellido = $Apellido;
        }

        public function saludar()
        {
             echo 'Hola '.$this->Nombre.' '.$this->Apellido;
        }
    }
?>