<?php
    class Lote
    {
        public $numeroLote;
        public $numeroSLRG;
        public $numeroCUFE;
        public $nombreSLRG;
        public $modulo;

        public function __construct($numeroLote, $numeroSLRG, $numeroCUFE,$nombreSLRG, $modulo)
        {
            $this->numeroLote = $numeroLote;
            $this->numeroSLRG = $numeroSLRG;
            $this->numeroCUFE = $numeroCUFE;
            $this->nombreSLRG = $nombreSLRG;
            $this->modulo = $modulo;
        }

        public function saludar()
        {
             echo $this->numeroLote.' - '.$this->numeroSLRG.' - '.$this->numeroCUFE.' - '.$this->nombreSLRG.' - '.$this->modulo;
        }
    }
?>