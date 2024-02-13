<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Final PHP</title>
    <style>
        #centrar {
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
        }
    </style>
</head>

<body>
    <h1>Examen Final PHP</h1>
    <form method="post" action="index.php">
        Bienvenido <strong><?php echo $datos_usu_log->usuario ?></strong> - <button name="btnSalir">Salir</button>
    </form>
    <h2>Su horario</h2>
    <?php
    echo "<h3 id='centrar'>Horario del Profesor: <em>" . $datos_usu_log->nombre . "</em></h3>";
    $url = DIR_SERV . "/horario/" . $datos_usu_log->id_usuario;
    $datos["api_session"] = $_SESSION["api_session"];
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die("<p>" . $url . "</p>");
    }
    if (isset($obj->error)) {
        session_destroy();
        die("<p>" . $obj->error . "</p>");
    }
    $horas = array("8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45");

    echo "<table>";
    echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";

    for ($hora = 0; $hora < 7; $hora++) {
        echo "<tr>";
        for ($dia = 0; $dia < 5; $dia++) {
            if ($dia == 0) {
                echo "<th>" . $horas[$hora] . "</th>";
            }
            echo "<td></td>";
        }
        echo "</tr>";
    }

    echo "</table>";

    ?>
</body>

</html>