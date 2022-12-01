<?php

function error_page($title, $body)
{
    $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>' . $title . '</title></head>';
    $html .= '<body>' . $body . '</body></html>';
    return $html;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        table {
            width: 100%;
        }

        td {
            height: 40px;
        }

        th {
            background-color: lightgrey;
        }

        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los Profesores</h2>
    <?php
    //1. CONECTAMOS CON LA BD.
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_horarios_exam");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>Imposible conectar a la base de datos. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error() . "</p></body></html>");
    }

    //2. HACEMOS LA CONSULTA
    try {
        $consulta = "SELECT id_usuario, nombre FROM usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        $mensaje = "<p>No se ha podido realiza la conexión. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . "</p>";
        mysqli_close($conexion);
        die($mensaje);
    }

    ?>
    <form action="index.php" method="post">
        <p>
            <label for="profesor">Horario del profesor: </label>
            <select name="profesor" id="profesor">
                <?php
                while ($tupla = mysqli_fetch_assoc($resultado)) {
                    if (isset($_POST["profesor"]) && $_POST["profesor"] == $tupla["id_usuario"]) {
                        echo "<option value='" . $tupla["id_usuario"] . "' selected >" . $tupla["nombre"] . "</option>";
                        $nombre_profesor = $tupla["nombre"];
                    } else {
                        echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
                    }
                }
                ?>
            </select>
            <button type="submit" name="btnVerHorario">Ver Horario</button>
        </p>
    </form>
    <?php

    //Cuando se pulse el botón "Ver horario" o "Editar" en la tabla:
    if (isset($_POST["btnVerHorario"]) || isset($_POST["btnEditar"])) {
        echo "<h2>Horario del Profesor : <em>" . $nombre_profesor . "</em></h2>";

        //Hacemos consulta a la base de datos (DESPUÉS DE PINTAR LA TABLA)
        try {
            $consulta = "SELECT horario_lectivo.dia, horario_lectivo.hora, grupos.nombre FROM horario_lectivo, grupos WHERE grupos.id_grupo = horario_lectivo.grupo AND usuario = '" . $_POST["profesor"] . "'";
            $resultado = mysqli_query($conexion, $consulta);

            while ($tupla = mysqli_fetch_assoc($resultado)) {
                if (isset($horario[$tupla["dia"]][$tupla["hora"]])) {
                    $horario[$tupla["dia"]][$tupla["hora"]] .= "/" . $tupla["nombre"];
                } else {
                    $horario[$tupla["dia"]][$tupla["hora"]] = $tupla["nombre"];
                }
            }
        } catch (Exception $e) {
            $mensaje = "<p>No se ha podido realiza la conexión. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . "</p>";
            mysqli_close($conexion);
            die($mensaje);
        }

        //Pintamos la tabla:
        $horas = ["8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45"];
        echo "<table>";
        echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
        for ($hora = 0; $hora < count($horas); $hora++) {
            echo "<tr>";
            echo "<th>" . $horas[$hora] . "</th>";
            if ($hora == 3) {
                echo "<td colspan='5'>RECREO</td>";
            } else {
                for ($dia = 0; $dia < 5; $dia++) { //Creamos un botón por cada tramo horario, de cada día
                    echo "<td>";
                    if (isset($horario[$dia][$hora])) {
                        echo "<p>".$horario[$dia][$hora]."</p>";
                    }
                        echo "<form action='index.php' method='post'>";
                        //Hidden que envían el dia, hora y profesor.
                        echo "<input type='hidden' name='profesor' value='" . $_POST["profesor"] . "'/>
                        <input type='hidden' name='dia' value='" . $dia . "'>
                        <input type='hidden' name='hora' value='" . $hora . "'>";
                        echo "<button class='enlace' name='btnEditar'>Editar</button>";
                        echo "</form>";
                        echo "</td>";
                    }
                }
            }
            echo "</tr>";
            echo "</table>";
        }
        
    //IMPORTANTE FREE RESULT Y CERRAR CONEXION.
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>

</html>