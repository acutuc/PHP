<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
            text-align: center;
            padding: 4px;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <h1>Ejercicio 6</h1>
    <p>
        Modificar el ejercicio anterior realizando una web con un formulario que contenga un select con las iniciales de un país y muestre el PIB per cápita de
        todos los años disponibles del país seleccionado.
    </p>

    <?php
    @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");
    if (!$fd) {
        die("<h3>No se ha podido abrir el fichero <em>'http://dwese.icarosproject.com/PHP/datos_ficheros.txt'</em></h3>");
    }

    $primera_linea = fgets($fd);

    while ($linea = fgets($fd)) {
        $datos_linea = explode("\t", $linea);
        $datos_primera_columna = explode(",", $datos_linea[0]);
        $paises[] = $datos_primera_columna[2];

        if (isset($_POST["pais"]) && $_POST["pais"] == $datos_primera_columna[2]) {
            $datos_pais_seleccionado = $datos_linea;
        }
    }

    fclose($fd);
    ?>
    <form action="ejercicio6.php" method="post">
        <p>
            <label for="pais">Seleccione un país</label>
            <select name="pais" id="pais">
                <?php
                for ($i = 0; $i < count($paises); $i++) {
                    if (isset($_POST["pais"]) && $_POST["pais"] == $paises[$i]) {
                        echo "<option value='" . $paises[$i] . "' selected>" . $paises[$i] . "</option>";
                    }
                    echo "<option value='" . $paises[$i] . "'>" . $paises[$i] . "</option>";
                }
                ?>
            </select>
        </p>
        <p>
            <button type="submit" name="btnBuscar">Buscar</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnBuscar"])) {
        echo "<h2>PIB per cápita de " . $_POST["pais"] . "</h2>";

        $datos_primera_linea = explode("\t", $primera_linea);

        $n_anios = count($datos_primera_linea) - 1;
        echo "<table>";

        echo "<tr>";
        for ($i = 1; $i <= $n_anios; $i++) {
            echo "<th>" . $datos_primera_linea[$i] . "</th>";
        }
        echo "</tr>";
        echo "<tr>";
        for ($i = 1; $i <= $n_anios; $i++) {
            if (isset($datos_pais_seleccionado[$i])) {
                echo "<td>" . $datos_pais_seleccionado[$i] . "</td>";
            } else {
                echo "<td></td>";
            }
        }
        echo "</tr>";

        echo "</table>";
    }
    ?>
</body>

</html>