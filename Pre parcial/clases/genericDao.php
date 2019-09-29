<?php
class GenericDao
{
    //TODO deberia ser estatico
    public $archivo;

    public function __construct($archivo)
    {
        $this->archivo = $archivo;
    }

    public function listar()
    {
        if (file_exists($this->archivo) && filesize($this->archivo) != 0) {
            try {
                $archivo = fopen($this->archivo, "r");
                return fread($archivo, filesize($this->archivo));
            } catch (Exception $e) {
                throw new Exception("No se pudo listar", 0, $e);
            } finally {
                fclose($archivo);
            }
        } else {
            return "";
        }
    }

    public function getObjectByKeyCaseInsensitive($attrKey, $attrValue)
    {
        //Valido que el archivo este creado y que el size sea distinto de 0
        if (file_exists($this->archivo) && filesize($this->archivo) != 0) {
            try {
                $objects = json_decode($this->listar());
                foreach ($objects as $object) {
                    if (strtolower($object->$attrKey) == strtolower($attrValue)) {
                        return $object;
                    }
                }
                return null;
            } catch (Exception $e) {
                throw new Exception("No se pudo listar", 0, $e);
            }
        }
    }

    public function getObjtecsByKeyCaseInsensitive($attrKey, $attrValue)
    {
        //Valido que el archivo este creado y que el size sea distinto de 0
        if (file_exists($this->archivo) && filesize($this->archivo) != 0) {

            try {
                $objects = json_decode($this->listar());
                $retorno = array();
                foreach ($objects as $object) {
                    //Comparo todo en minuscula
                    if (strtolower($object->$attrKey) == strtolower($attrValue)) {
                        array_push($retorno, $object);
                    }
                }
                if (count($retorno) > 0) {
                    return json_encode($retorno);
                } else {
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception("No se pudo listar", 0, $e);
            }
        } else {
            //Si no esta creado retorno null
            return null;
        }
    }

    public function guardar($object): bool
    {

        try {
            $objects = [];
            if (file_exists($this->archivo) && filesize($this->archivo) != 0) {
                $jsonDecoded = json_decode($this->listar());
                //Valido si el array de json esta vacio
                if (count($jsonDecoded) > 0) {
                    //Si no está vacio, copio el contenido de json decode a $objects.
                    $objects = $jsonDecoded;
                }
            }
            //Abro el archivo
            $archivo = fopen($this->archivo, "w");
            //Pusheo mi objeto creado al array de objetos json
            array_push($objects, $object);
            //Codifico el array como json
            fwrite($archivo, json_encode($objects));
            return true;
        } catch (Exception $e) {
            throw new Exception("No se pudo guardar", 0, $e);
        } finally {
            fclose($archivo);
        }
    }

    public function borrar($idKey, $idValue): bool
    {
        $rta = false;
        $archivo = null;
        try {
            $objects = json_decode($this->listar());
            for ($i = 0; $i < count($objects); $i++) {
                if ($objects[$i]->$idKey == $idValue) {
                    array_splice($objects, $i, 1);
                    $archivo = fopen($this->archivo, "w");
                    $rta = fwrite($archivo, json_encode($objects));
                    break;
                }
            }
            return $rta;
        } catch (Exception $e) {
            throw new Exception("No se pudo borrar", 0, $e);
        } finally {
            if ($archivo !== null) {
                fclose($archivo);
            }
        }
    }

    public function modificar($idKey, $idValue, $objeto): bool
    {
        try {
            $objects = json_decode($this->listar());
            $rta = false;
            for ($i = 0; $i < count($objects); $i++) {
                if ($objects[$i]->$idKey == $idValue) {
                    $objects[$i] = $objeto;
                    $rta = true;
                    break;
                }
            }
            if ($rta === true) {
                $archivo = fopen($this->archivo, "w");
                return fwrite($archivo, json_encode($objects));
            } else {
                return $rta;
            }
        } catch (Exception $e) {
            throw new Exception("No se pudo modificar", 0, $e);
        } finally {
            fclose($archivo);
        }
    }
}
