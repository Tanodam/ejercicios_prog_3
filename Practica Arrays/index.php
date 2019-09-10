<?php

/*//-----------------------------------Aplicación Nº 9 (Carga aleatoria)--------------------------
    $array = array();
    $numerosMayoresA6 = 0;
    $numerosMenoresA6 = 0;
    $numerosIgualesA6 = 0;

    for ($i=0; $i<5; $i++)
    {
        $array[$i] = rand(0,15);
    }
    foreach($array as $numero)
    {
        if($numero > 6)
        {
            $numerosMayoresA6++;
            echo $numero."\n";
        }
        if($numero < 6)
        {
            $numerosMenoresA6++;
            echo $numero."\n";
        }
        if($numero == 6)
        {
            $numerosIgualesA6++;
            echo $numero."\n";
        }
    }
    
    echo "Mayores: ".$numerosMayoresA6."\n"."Menores: ".$numerosMenoresA6."\n"."Iguales: ".$numerosIgualesA6;
     */ //------------------------------------------------FIN Aplicación Nº 9 (Carga aleatoria)------------------
/*//-----------------------------------Aplicación Nº 10 (Mostrar impares)-----------------------------------*/
    $array = array();
    $i = 0;
    for ($i=1;count($array)<10; $i++)
    {
        if($i%2 != 0)
        {
            $array[$i] = $i;
        }
    }
    echo "MOSTRANDO CON FOREACH <br/>";
    foreach ($array as $numero) {
        echo $numero."<br/>";
    }

     //-----------------------------------Aplicación Nº 10 (Mostrar impares)-----------------------------------


?>