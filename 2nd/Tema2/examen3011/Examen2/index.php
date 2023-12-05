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
        th {
            background-color: lightgrey;
        }

        th,
        td {
            border: 1px solid black;
            text-align: center;
        }

        table {
            border: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
            width: 90%;
        }

        .centrar {
            text-align: center;
        }

        .enlace {
            color: blue;
            border: 0px;
            text-decoration: underline;
            background: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los Profesores</h2>
    <p>
    <form action="index.php" method="post">
        <label for="profesor">Horario del Profesor: </label>
        <?php
        try {
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_horarios_exam");
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die("<p>Imposible conectar. Error: " . $e->getMessage() . "</p></body></html>");
        }

        try {
            $consulta = "SELECT * FROM usuarios";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die("<p>Imposible realizar la consulta. Error: " . $e->getMessage() . "</p></body></html>");
        }

        echo "<select name='profesor' id='profesor'>";
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            if (isset($_POST["profesor"]) && $_POST["profesor"] == $tupla["id_usuario"]) {
                echo "<option value='" . $tupla["id_usuario"] . "' selected>" . $tupla["nombre"] . "</option>";
                $nombre_profesor = $tupla["nombre"];
            } else {
                echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
            }
        }
        echo "</select> ";
        echo "<button name='btnVerHorario'>Ver Horario</button>";

        if (isset($_POST["btnVerHorario"]) || isset($_POST["btnEditar"])) {
            echo "<h3 class='centrar'>Horario del Profesor: " . $nombre_profesor . "</h3>";

            $dias[1] = "Lunes";
            $dias[] = "Martes";
            $dias[] = "Miércoles";
            $dias[] = "Jueves";
            $dias[] = "Viernes";

            $hora[] = "8:15 - 9:15";
            $hora[] = "9:15 - 10:15";
            $hora[] = "10:15 - 11:15";
            $hora[] = "11:15 - 11:45";
            $hora[] = "11:45 - 12:45";
            $hora[] = "12:45 - 13:45";
            $hora[] = "13:45 - 14:45";

            try {
                $consulta = "SELECT horario_lectivo.dia, horario_lectivo.hora, grupos.nombre 
                            FROM horario_lectivo, grupos
                            WHERE grupos.id_grupo = horario_lectivo.grupo AND usuario = '" . $_POST["profesor"] . "'";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die("<p>Imposible realizar la consulta. Error: " . $e->getMessage() . "</p></body></html>");
            }

            while ($tupla = mysqli_fetch_assoc($resultado)) {
                if (isset($horario[$tupla["dia"]][$tupla["hora"]])) {
                    $horario[$tupla["dia"]][$tupla["hora"]] .= "/" . $tupla["nombre"];
                } else {
                    $horario[$tupla["dia"]][$tupla["hora"]] = $tupla["nombre"];
                }
            }

            echo "<table>";
            echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
            for ($i = 0; $i < count($hora); $i++) {
                echo "<tr>";
                if ($i == 3) {
                    echo "<tr><th>" . $hora[$i] . "</th><td colspan='5' class='centrar'>RECREO</td></tr>";
                } else {
                    echo "<th>" . $hora[$i] . "</th>";
                    for ($j = 1; $j <= count($dias); $j++) {
                        echo "<td>";
                        if (isset($horario[$j][$i + 1])) echo $horario[$j][$i + 1];
                        if ($i < 4) {
                            echo "<form method='post' action='index.php'><input type='hidden' name='profesor' value='" . $_POST["profesor"] . "'/><input type='hidden' value='" . $hora[$i] . "' name='valorHora'/><input type='hidden' name='valorDia' value='" . $dias[$j] . "'/><input type='hidden' value='" . ($i + 1) . "' name='hora'/><button name='btnEditar' value='" . $j . "' class='enlace'>Editar</button></form>";
                        } else {
                            echo "<form method='post' action='index.php'><input type='hidden' name='profesor' value='" . $_POST["profesor"] . "'/><input type='hidden' value='" . $hora[$i] . "' name='valorHora'/><input type='hidden' name='valorDia' value='" . $dias[$j] . "'/><input type='hidden' value='" . $i . "' name='hora'/><button name='btnEditar' value='" . $j . "' class='enlace'>Editar</button></form>";
                        }
                        echo "</td>";
                    }
                    echo "</tr>";
                }
            }
            echo "</table>";
        }

        if (isset($_POST["btnEditar"])) {
            echo "<h2>Editando la " . $_POST["hora"] . "º hora (" . $_POST["valorHora"] . ") del " . $_POST["valorDia"] . "</h2>";

            if ($_POST["hora"] > 3) {
                $hor = $_POST["hora"] + 1;
            } else {
                $hor = $_POST["hora"];
            }

            try {
                $consulta = "SELECT grupos.nombre
                FROM grupos, usuarios, horario_lectivo
                WHERE horario_lectivo.usuario = " . $_POST["profesor"] . " AND usuarios.id_usuario = horario_lectivo.usuario AND horario_lectivo.hora = " . $hor . " AND horario_lectivo.dia = " . $_POST["btnEditar"] . " AND grupos.id_grupo = horario_lectivo.grupo;";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die("<p>Imposible realizar la consulta. Error: " . $e->getMessage() . "</p></body></html>");
            }

            echo "<table>";

            echo "<tr><th>Grupo</th><th>Acción</th></tr>";
            while($tupla = mysqli_fetch_assoc($resultado)){
                echo "<tr>";
                echo "<td>".$tupla["nombre"]."</td>";
                echo "<td><form method='post' action='index.php'><button name='btnQuitar' class='enlace'>Quitar</button></form></td>";
                echo "</tr>";
            }
            echo "</table>";
        }

        

        ?>
    </form>
    </p>

    <?php
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>

</html>