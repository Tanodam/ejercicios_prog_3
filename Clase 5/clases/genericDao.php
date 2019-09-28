<?php
class GenericDao
{
    //TODO deberia ser estatico
    public $archivo;

    public function __construct($archivo)
    {
        $this->archivo = $archivo;
    }

    public function obtenerPorId($idKey, $idValue)
    {
        $objects = json_decode($this->listar());
        foreach ($objects as $object) {
            if ($object->$idKey == $idValue) {
                return $object;
            }
        }
        return null;
    }

    public function listar()
    {
        if (file_exists($this->archivo) && trim(file_get_contents($this->archivo)) != false) {
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

    public function getAttributeByKeyCaseInsensitive($attrKey, $attrValue)
    {
        $rta = null;
        if (file_exists($this->archivo)) {
            try {
                $objects = json_decode($this->listar());
                foreach ($objects as $object) {
                    if (strtolower($object->$attrKey) == strtolower($attrValue)) {
                        $rta = $object;
                    }
                }
                return $rta;
            } catch (Exception $e) {
                throw new Exception("No se pudo listar", 0, $e);
            }
        } else {
            return $rta;
        }
    }

    public function getAttributesByKeyCaseInsensitive($attrKey, $attrValue)
    {
        //Valido que el archivo este creado
        if (file_exists($this->archivo)) {

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
            if (file_exists($this->archivo)) {

                $jsonDecoded = json_decode($this->listar());
                //Valido si el array de json esta vacio
                if (count($jsonDecoded) >= 0) {
                    //Si está vacio, lo formateo para que sea un array de objetos json.
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
        try {
            $retorno = false;
            $objects = json_decode($this->listar());
            $archivo = fopen($this->archivo, "w");
            foreach ($objects as $key => $object) {
                if ($object->$idKey == $idValue) {
                    unset($objects[$key]);
                    break;
                }
            }

            return fwrite($archivo, json_encode($objects));;
        } catch (Exception $e) {
            throw new Exception("No se pudo borrar", 0, $e);
        } finally {
            fclose($archivo);
        }
    }

    public function modificar2($idKey, $idValue, $changeKey, $changeValue): bool
    {
        try {
            $retorno = false;
            $objects = json_decode($this->listar());
            $archivo = fopen($this->archivo, "w");
            foreach ($objects as $object) {
                if ($object->$idKey == $idValue) {
                    $object->$changeKey == $changeValue;
                    $retorno = true;
                    break;
                }
            }
            fwrite($archivo, json_encode($objects));
            return $retorno;
        } catch (Exception $e) {
            throw new Exception("No se pudo modificar", 0, $e);
        } finally {
            fclose($archivo);
        }
    }


    public function modificar($idKey, $idValue, $objeto): bool
    {
        $objects = json_decode($this->listar());
        for ($i = 0; $i < count($objects); $i++) {
            if ($objects[$i]->$idKey == $idValue) {
                $objects[$i] = $objeto;
            }
        }
        try {
            $archivo = fopen($this->archivo, "w");
            return fwrite($archivo, json_encode($objects));
        } catch (Exception $e) {
            throw new Exception("No se pudo modificar", 0, $e);
        }
        finally
        {
            fclose($archivo);
        }
    }
}
