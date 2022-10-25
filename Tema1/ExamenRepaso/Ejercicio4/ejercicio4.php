<?php
function mi_strlen($texto)
{
    $contador = 0;
    while (isset($texto[$contador])) {
        $contador++;
    }
    return $contador;
}

function mi_explode($separador, $texto)
{
    $aux = [];
    $longitud_texto = mi_strlen($texto);

    $i = 0;
    while ($i < $longitud_texto && $texto[$i] == $separador) {
        $i++;
    }

    if ($i < $longitud_texto) {
        $j = 0;
        $aux[$j] = $texto[$i];
        for ($k = $i + 1; $k < $longitud_texto; $k++) {
            if ($texto[$k] != $separador) {
                $aux[$j] .= $texto[$k];
            } else {
                while ($k < $longitud_texto && $texto[$k] == $separador) {
                    $k++;
                }
                if ($k < $longitud_texto) {
                    $j++;
                    $aux[$j] = $texto[$k];
                }
            }
        }
    }

    return $aux;
}

if (isset($_POST["btnEnviar"])) {
    $error_fichero = $_FILES["archivo"]["size"] > 1000000 || $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"] != "text/plain";

    if (!$error_fichero) {
        @$var = move_uploaded_file($_FILES["archivo"]["tmp_name"], "Horario/horarios.txt");
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 4</title>
    <meta charset="UTF-8">
    <style>
        th{
            background-color: lightgrey;
        }
        td{
            text-align:center;
        }
    </style>
</head>

<body>
    <h1>Ejercicio 4</h1>
    <?php
    @$fd = fopen("Horario/horarios.txt", "r");

    if (!$fd) { ?>
        <h2>No se ha encontrado el archivo <em>Horario/horarios.txt</em></h2>
        <form action="ejercicio4.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="archivo">Introduce un archivo: (No mayor de 1MB)</label> <br>
                <input type="file" name="archivo" id="archivo" accept=".txt">
                <?php
                if (isset($_POST["subir"]) && $error) {
                    if ($_FILES["archivo"]["type"] != "text/plain") {
                        echo "<span class='error'>*El archivo no es de tipo texto*</span>";
                    }

                    if ($_FILES["archivo"]["size"] > 1 * 1000000) {
                        echo "<span class='error'>*El archivo es superior a 1MB*</span>";
                    }

                    if ($_FILES["archivo"]["name"] != "horarios.txt") {
                        echo "<span class='error'>*No es horarios.txt*</span>";
                    }
                }
                ?>
            </p>

            <p>
                <button type="submit" name="subir">Subir fichero</button>
            </p>
        </form>

        <?php
        if (isset($_POST["subir"]) && !$error) {
            echo "No se ha podido subir el archivo";
        }
    } else {    ?>
        <h2>Horario de los profesores</h2>

        <form action="ejercicio4.php" method="post">
            <p>
                <label for="profesor">Horario del profesor:</label>
                <select name="profesor" id="profesor">
                    <?php
                    while ($linea = fgets($fd)) {
                        $fila_datos = mi_explode("\t", $linea);
                        if (isset($_POST["profesor"]) && $_POST["profesor"] == $fila_datos[0]) {
                            echo "<option selected value='" . $fila_datos[0] . "'>" . $fila_datos[0] . "</option>";
                            $profesor = $fila_datos[0];
                        } else {
                            echo "<option value='" . $fila_datos[0] . "'>" . $fila_datos[0] . "</option>";
                        }
                    }
                    ?>
                </select>
                <button type="submit" name="verHorario">Ver horario</button>
            </p>
        </form>
    <?php

        if (isset($_POST["verHorario"])) {
            
            
            echo "<table border='1'>";

            echo "<caption>Horario del Profesor: <em>".$_POST["profesor"]."</em></caption>";

            echo "<tr>";
            echo "<th></th>";
            echo "<th>Lunes</th>";
            echo "<th>Martes</th>";
            echo "<th>Miercoles</th>";
            echo "<th>Jueves</th>";
            echo "<th>Viernes</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>8:15 - 9:15</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>9:15 - 10:15</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>10:15 - 11:15</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>11:15 - 11:45</th>";
            echo "<td colspan='5'>RECREO</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>11:45 - 12:45</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>12:45 - 13:45</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<th>13:45 - 14:45</th>";
            echo "</tr>";
            
            echo "</table>";
        }

        fclose($fd);
    } ?>
</body>

</html>