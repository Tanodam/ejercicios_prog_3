<?php
    class Persona
    {
        public $Nombre;
        public $Apellido;
        public $Legajo;
        public $Foto;

        public function __construct($Nombre, $Apellido, $Legajo, $Foto)
        {
            $this->Nombre = $Nombre;
            $this->Apellido = $Apellido;
            $this->Legajo = $Legajo;
            $this->Foto = $Foto;
        }

        public function saludar()
        {
             echo 'Hola, '.$this->Nombre.' '.$this->Apellido.' '.$this->Legajo;
        }
    }
?>