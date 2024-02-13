<?php
$url = DIR_SERV . "/usuarios";
$datos["api_session"] = $_SESSION["api_session"];
$respuesta = consumir_servicios_REST($url, "GET", $datos);
$obj = json_decode($respuesta);
if (!$obj) {
    session_destroy();
    die(error_page("Horarios profesores", $url));
}
if (isset($obj->error)) {
    session_destroy();
    die(error_page("Horarios profesores", $obj->error));
}

if (isset($_POST["btnVerHorario"])) {
    $url = DIR_SERV . "/horario/" . $_POST["btnVerHorario"];
    $datos["api_session"] = $_SESSION["api_session"];
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj2 = json_decode($respuesta);
    if (!$obj2) {
        session_destroy();
        die(error_page("Horarios profesores", $url));
    }
    if (isset($obj2->error)) {
        session_destroy();
        die(error_page("Horarios profesores", $obj->error));
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Final PHP</title>
    <style>
        .centrar {
            text-align: center;
        }

        td,
        th {
            border: 1px solid black;
        }

        th {
            background-color: lightgrey;
        }

        table {
            border-collapse: collapse;
            margin: 0 auto;
            width: 80%;
        }
    </style>
</head>

<body>
    <h1>Examen Final PHP</h1>
    <form method="post" action="index.php">
        Bienvenido <strong><?php echo $datos_usu_log->usuario ?></strong> - <button name="btnSalir">Salir</button>
    </form>
    <h2>Horario de los Profesores</h2>
    <form action="index.php" method="post">
        <p>
            <label for="profesor">Horario del Profesor: </label>
            <select name="profesor" id="profesor">
                <?php
                foreach ($obj->usuarios as $tupla) {
                    if (isset($_POST["profesor"]) && $_POST["profesor"] == $tupla->id_usuario) {
                        echo "<option value='" . $tupla->id_usuario . "' selected>" . $tupla->nombre . "</option>";
                        $nombre_profesor = $tupla->nombre;
                    } else {
                        echo "<option value='" . $tupla->id_usuario . "'>" . $tupla->nombre . "</option>";
                    }
                }
                ?>
            </select>
            <button name="btnVerHorario">Ver Horario</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnVerHorario"])) {

        foreach ($obj2->horario as $tupla) {
            if (isset($horario[$tupla->dia][$tupla->hora])) {
                $horario[$tupla->dia][$tupla->hora] .= "/" . $tupla->nombre;
            } else {
                $horario[$tupla->dia][$tupla->hora] = $tupla->nombre;
            }
        }
        echo "<h3 class='centrar'>Horario del profesor " . $nombre_profesor . "</h3>";

        $horas = array(1 => "8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45");

        echo "<table>";
        echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";

        for ($hora = 1; $hora <= 7; $hora++) {
            echo "<tr>";
            echo "<th>" . $horas[$hora] . "</th>";
            if ($hora == 4) {
                echo "<td colspan='5' class='centrar'>RECREO</td>";
            } else {
                for ($dia = 1; $dia <= 5; $dia++) {
                    echo "<td></td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
</body>

</html>