
<?php
    function leerContenidoFichero($ruta){
        @$fd = fopen($ruta, "r");
        if(!$fd){
            die("No se ha podido abrir el fichero 'datosEjercicio.txt'");
        }
        while($linea = fgets($fd)){
            echo "<p>".$linea."</p>";
        }
        fclose($fd);
    }

    function escribirNumerosMod($numeros, $modo){
        if($modo == "Ampliar"){
            $modo = "a";
        }else{
            $modo = "w";
        }
        @$fd = fopen("datosEjercicio.txt", $modo);
        if(!$fd){
            die("No se ha podido abrir el fichero 'datosEjercicio.txt'");
        }

        for($i = 0; $i < count($numeros); $i++){
            fwrite($fd, $numeros[$i].PHP_EOL);
        }

        fclose($fd);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio Apuntes</title>
</head>
<body>
    <?php
        $numeros = array(54, -68, 34, 626);
        escribirNumerosMod($numeros, "Sobreescribir");
        echo "<h2>Mostrando el fichero</h2>";
        leerContenidoFichero("datosEjercicio.txt");

        $numeros2 = array(33, 11, 16);
        escribirNumerosMod($numeros2, "Ampliar");
        echo "<h2>Mostrando el fichero ampliado</h2>";
        leerContenidoFichero("datosEjercicio.txt");

        $numeros3 = array(4, 99, 12);
        escribirNumerosMod($numeros3, "sobreescribir");
        echo "<h2>Mostrando el fichero 3</h2>";
        leerContenidoFichero("datosEjercicio.txt");
        echo "<p>Adiós</p>";
    ?>
</body>
</html>