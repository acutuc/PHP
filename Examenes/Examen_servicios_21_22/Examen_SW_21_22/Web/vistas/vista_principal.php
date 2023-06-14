<?php
$url = DIR_SERV . "/usuarios";
$respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
$obj = json_decode($respuesta);

if (!$obj) {
    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Examen4 PHP", "Examen4 PHP", $url . $respuesta));
}

if (isset($obj->error)) {
    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
    session_destroy();
    die(error_page("Examen4 PHP", "Examen4 PHP", $obj->error));
}

if (isset($obj->no_auth)) {
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 PHP</title>
    <style>
        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        .enlinea {
            display: inline
        }

        table {
            border-collapse: collapse;
            width: 80vw;
            margin: 0 auto;
        }

        th {
            background-color: grey;
        }

        th,
        td {
            text-align: center;
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1>Examen4 PHP</h1>
    <div>
        Bienvenido <strong>
            <?php echo $datos_usu_log->usuario; ?>
        </strong> - <form class="enlinea" method="post" action="index.php"><button class="enlace"
                name="btnCerrarSesion">Salir</button></form>
    </div>

    <form method="post" actiond="index.php">
        <p>
            <label for="profesores">Seleccione un profesor: </label>
            <select id="profesores" name="profesor">
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
        </p>
        <p>
            <button name="btnVerHorario">Ver Horario</button>
        </p>

    </form>

    <?php
    if (isset($_POST["profesor"])) {
        $url = DIR_SERV . "/horario/" . $_POST["profesor"];
        $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
        $obj = json_decode($respuesta);

        if (!$obj) {
            $url = DIR_SERV . "/salir";
            consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
            session_destroy();
            die(error_page("Examen4 PHP", "Examen4 PHP", $url . $respuesta));
        }

        if (isset($obj->error)) {
            $url = DIR_SERV . "/salir";
            consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
            session_destroy();
            die(error_page("Examen4 PHP", "Examen4 PHP", $obj->error));
        }

        if (isset($obj->no_auth)) {
            session_destroy();
            die("<p>El tiempo de sesión ha expirado. Vuelva a loguearse</p></body></html>");
        }

        foreach ($obj->horario as $tupla) {
            if (isset($horario[$tupla->dia][$tupla->hora])) {
                $horario[$tupla->dia][$tupla->hora] .= "/" . $tupla->nombre;
            } else {
                $horario[$tupla->dia][$tupla->hora] = $tupla->nombre;
            }
        }

        echo "<h2>Horario del Profesor: " . $nombre_profesor . "</h2>";

        $dias_semana[] = "";
        $dias_semana[] = "Lunes";
        $dias_semana[] = "Martes";
        $dias_semana[] = "Miércoles";
        $dias_semana[] = "Jueves";
        $dias_semana[] = "Viernes";

        $horas[] = "8:15 - 9:15";
        $horas[] = "9:15 - 10:15";
        $horas[] = "10:15 - 11:15";
        $horas[] = "11:15 - 11:45";
        $horas[] = "11:45 - 12:45";
        $horas[] = "12:45 - 13:45";
        $horas[] = "13:45 - 14:45";

        echo "<table>";

        echo "<tr>";

        for ($i = 0; $i < count($dias_semana); $i++) {
            echo "<th>" . $dias_semana[$i] . "</th>";
        }

        echo "</tr>";

        for ($hora = 1; $hora < 7; $hora++) {
            echo "<tr>";
            echo "<th>" . $horas[$hora] . "</th>";
            if ($hora == 4) {
                echo "<td colspan='5'>RECREO</td>";
            } else {
                for ($dia = 1; $dia < 6; $dia++) {
                    if (isset($horario[$dia][$hora])) {
                        echo "<td>" . $horario[$dia][$hora];
                    } else {
                        echo "<td>";
                    }
                    echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='hora' value='" . $hora . "'/>";
                    echo "<input type='hidden' name='dia' value='" . $dia . "'/>";
                    echo "<input type='hidden' name='hora' value='" . $_POST["profesor"] . "'/>";
                    echo "<button name='btnEditar'>Editar</button>";
                    echo "</form>";
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