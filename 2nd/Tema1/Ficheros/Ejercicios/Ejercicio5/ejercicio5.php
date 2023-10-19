<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 5</title>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            border: 1px solid black;
        }
        table, th, td{
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1>Ejercicio 5</h1>
    <p>
        Realizar una web que abra el fichero con información sobre el PIB per cápita de los países de la Unión Europea y muestre todo el contenido en una tabla
        (<a href="http//dwese.icarosproject.com/PHP/datos_ficheros.txt">http://dwese.icarosproject.com/PHP/datos_ficheros.txt</a>)
    </p>
    <p>
        NOTA: Los datos del fichero datos_ficheros.txt vienen separados por un tabulador ("\t").
    </p>
    <?php
    @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");

    if (!$fd) {
        die("<p>No se ha podido abrir la fuente de datos</p>");
    }

    echo "<table>";
    echo "<caption>PIB per cápita de los países de la Unión Europea</caption>";

    //Almacenamos en $fila lo que lee fgets.
    $fila = fgets($fd);

    //Separamos en array los datos de la fila, separando por tabulador.
    $datos_fila = explode("\t", $fila);

    //Contamos el número de columnas.
    $n_columns = count($datos_fila);

    echo "<tr>";

    //Imprimimos la primera fila (los títulos).
    for ($i = 0; $i < $n_columns; $i++) {
        echo "<th>" . $datos_fila[$i] . "</th>";
    }

    echo "</tr>";

    while ($fila = fgets($fd)) {
        $datos_fila = explode("\t", $fila);

        echo "<tr>";

        for ($i = 0; $i < $n_columns; $i++) {
            if(isset($datos_fila[$i])){
                echo "<td>" . $datos_fila[$i] . "</td>";
            }else{
                echo "<td></td>";
            }
            
        }

        echo "</tr>";
    }

    echo "</table>";

    fclose($fd);
    ?>
</body>

</html>