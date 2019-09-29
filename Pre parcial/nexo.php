<?php
include './clases/';
include './clases/';
include './clases/';
include './controller/';
include './controller/';
include './controller/';
include './clases/genericDao.php';

$request = ($_SERVER['REQUEST_METHOD']);


try {
    switch ($request) {
        case "POST":
            if (isset($_POST["case"])) {
                switch ($_POST["case"]) {
                    case "":
                        if (isset($_POST[""]) && isset($_POST[""]) && isset($_POST[""]) && isset($_FILES[""])) {

                        } else {
                            echo "Hubo un error en los datos enviados";
                        }
                        break;
                    case "":
                        if (isset($_POST[""]) && isset($_POST[""]) && isset($_POST[""]) && isset($_POST[""])) {
                        
                        } else {
                            echo "Hubo un error en los datos enviados";
                        }
                        break;
                    case "":
                        if (isset($_POST[""])){
                            
                        } else {
                            echo "Hubo un error en los datos enviados";
                        }
                }
            } else {
                echo 'Indique el case correctamente';
            }
            break;
        case "GET":
            if (isset($_GET["case"])) {
                switch ($_GET["case"]) {
                    case "":
                        if(isset($_GET[""])) {
                        } else {
                            echo '';
                        }
                        break;
                    case "":
                    if(isset($_GET[""])) {
                    } else {
                    }
                    break;
                    case "":
                    if(isset($_GET[""]))
                    {
                    }
                    else
                    {
                    }
                    break;
                    case "":
                    if (isset($_GET[""]))
                    {
                    }
                    else {

                    }
                    break;
                    case "":
                    break;
                
                }
            } else {
                echo 'Indique el case correctamente';
            }
            break;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
