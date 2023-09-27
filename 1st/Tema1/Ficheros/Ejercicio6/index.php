<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 6</title>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse
        }

        table,
        th,
        td {
            border: 1px solid black
        }
    </style>
</head>

<body>
    <h1>Ejercicio 6</h1>
    <p>
        Modificar el ejercicio anterior realizando una web con un formulario que contenga un select con las iniciales de un país y muestre el PIB per cápita de
        todos los años disponibles del país seleccionado.
    </p>
    <form action="index.php" method="post" enctype="multipart/form-data">

        <?php
        @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");

        if (!$fd) {
            echo "<p>El fichero no existe</p>";
        }
        ?>

        <label for='pais'>Seleccione un país: </label>

        <select name='pais' id='pais'>

            <?php
            $fila = fgets($fd);

            $contador = 1;
            while ($fila = fgets($fd)) {
                $datos_fila = explode("\t", $fila);
                $array_datos = explode(",", $datos_fila[0]);
                $zona = end($array_datos);
                if (isset($_POST["pais"]) && $_POST["pais"] == $contador) {
                    echo "<option value='$contador' selected>" . $zona . "</option>";
                }
                echo "<option value='$contador'>" . $zona . "</option>";
                $contador++;
            }

            echo "</select>";
            fclose($fd);
            ?>
            <p>
                <button type="submit" name="btnBuscar">Buscar</button>
            </p>

    </form>
    <?php
    if (isset($_POST["btnBuscar"])) {
        @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");

        if (!$fd) {
            echo "<p>El fichero no existe</p>";
        }

        echo "<table>";

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

        //Avanzamos hasta la fila oportuna.
        $i = 1;
        while ($i <= $_POST["pais"]) {
            $fila = fgets($fd);
            $i++;
        }

        //Pintamos fila oportuna.
        $datos_fila = explode("\t", $fila);

        echo "<tr>";

        for ($i = 0; $i < $n_columns; $i++) {
            if (isset($datos_fila[$i])) {
                echo "<td>" . $datos_fila[$i] . "</td>";
            } else {
                echo "<td></td>";
            }
        }

        echo "</tr>";

        echo "</table>";
        fclose($fd);
    }
    ?>

</body>

</html>