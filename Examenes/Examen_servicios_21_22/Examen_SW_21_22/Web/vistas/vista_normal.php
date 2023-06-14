<?php
$url = DIR_SERV . "/horario/" . $datos_usu_log->id_usuario;
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
$datos_horario = $obj->horario;
//var_dump($datos_horario);

foreach($datos_horario as $tupla){
    $horario[$tupla->dia][$tupla->hora] = true;
    echo $horario[$tupla->dia][$tupla->hora];
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
            margin:0 auto;
        }

        td,
        th {
            border: 1px solid black;
        }

        th {
            background-color: grey;
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
    <h2>Su horario</h2>

    <?php
    echo "<h2>Horario del Profesor: " . $datos_usu_log->nombre . "</h2>";

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
    for($o = 0; $o < count($horas); $o++){
        echo "<tr>";
        echo "<th>".$horas[$o]."</th>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
</body>

</html>