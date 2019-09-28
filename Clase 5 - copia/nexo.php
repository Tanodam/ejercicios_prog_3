<?php
include './clases/alumno.php';
include './clases/materia.php';
include './clases/inscripcion.php';
include './controller/alumnoController.php';
include './controller/materiaController.php';
include './controller/inscripcionController.php';
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
                        echo '';
                    }
                    break;
                    case "":
                    if(isset($_GET[""]) && !isset($_GET[""]) || !isset($_GET[""]) && isset($_GET[""]) ||
                    isset($_GET["codigoMateria"]) && isset($_GET["apellidoAlumno"]))
                    {
                        echo $inscripcionController->mostrarInscripcionesFiltro($_GET);
                    }
                    else
                    {
                        echo 'Indique apellido o materia a buscar';
                    }
                    break;
                    case "inscribirAlumno":
                    if (isset($_GET["nombreAlumno"]) && isset($_GET["apellidoAlumno"]) && isset($_GET["emailAlumno"]) && isset($_GET["nombreMateria"]) && isset($_GET["codigoMateria"])) {
                        $inscripcionController->inscribirAlumno($_GET["nombreAlumno"], $_GET["apellidoAlumno"], $_GET["emailAlumno"], $_GET["nombreMateria"], $_GET["codigoMateria"]);
                    } else {
                        echo "Hubo un error en los datos enviados";
                    }
                    break;
                    case "mostrarAlumnos":
                    $alumnoController->mostrarAlumnos();
                
                }
            } else {
                echo 'Indique el case correctamente';
            }
            break;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
