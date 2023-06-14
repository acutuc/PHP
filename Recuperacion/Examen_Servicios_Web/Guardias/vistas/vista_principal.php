<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .tabla,
        th {
            border-collapse: collapse;
        }

        th {
            background-color: lightgrey;
        }
    </style>
    <title>Gestor de Guardias</title>
</head>

<body>
    <h1>Gestión de Guardias</h1>
    <p>
        Bienvenido <strong>
            <?php echo $datos_usu_log->usuario ?>
        </strong>
    <form method="post" action="index.php"><button name="btnSalir">Salir</button></form>
    </p>

    <?php
    echo "<h2>Equipos de Guardia del IES Mar de Alborán</h2>";

    $url = DIR_SERV . "/guardiasUsuario/" . $datos_usu_log->id_usuario;

    $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);

    $obj = json_decode($respuesta);

    if (!$obj) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
        session_destroy();
        die(error_page("Gestión de Guardias", "Gestión de Guardias", $url . $respuesta));
    }

    if (isset($obj->error)) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
        session_destroy();
        die(error_page("Gestión de Guardias", "Gestión de Guardias", $obj->error));
    }

    //Recorremos el objeto, si existe el dia y hora, asignamos true:
    foreach ($obj->guardias as $tupla) {
        $horario[$tupla->dia][$tupla->hora] = true;
    }

    $dias_semana[0] = "";
    $dias_semana[1] = "Lunes";
    $dias_semana[2] = "Martes";
    $dias_semana[3] = "Miércoles";
    $dias_semana[4] = "Jueves";
    $dias_semana[5] = "Viernes";

    $contador = 1;
    echo "<table>";

    echo "<tr>";
    for ($i = 0; $i < count($dias_semana); $i++) {
        echo "<th>" . $dias_semana[$i] . "</th>";
    }
    echo "</tr>";

    //Filas tantas horas hayan (6):
    for ($hora = 1; $hora < 7; $hora++) {
        if ($hora == 4) {
            echo "<tr><td colspan='6'>RECREO</td></tr>";
        }
        echo "<tr>";
        echo "<td>" . $hora . "º Hora</td>";
        //Días de la semana:
        for ($dia = 1; $dia < 6; $dia++) {
            //Si existe la tupla dia/hora, imprimimos:
            if (isset($horario[$dia][$hora])) {
                echo "<td>";

                echo "<form action='principal.php' method='post'>";
                echo "<input type='hidden' name='dia' value='" . $dia . "'/>";
                echo "<input type='hidden' name='hora' value='" . $hora . "'/>";
                echo "<input type='hidden' name='equipo' value='" . $contador . "'/>";
                echo "<button name='btnVerEquipo'>Equipo " . $contador . "</button>";
                echo "</form>";

                echo "</td>";
            } else {
                echo "<td></td>";

                $contador++;
            }
        }
        echo "</tr>";
    }

    echo "</table>";


    if (isset($_POST["btnVerEquipo"]) || isset($_POST["btnDetallesUsuario"])) {
        echo "<h1>EQUIPO DE GUARDIA " . $_POST["equipo"] . "</h1>";
        echo "<h2>" . $dias_semana[$_POST["dia"]] . " a " . $_POST["hora"] . "º hora</h2>";

        $url = DIR_SERV . "/usuariosGuardia/" . $_POST["dia"] . "/" . $_POST["hora"];

        $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);

        $obj = json_decode($respuesta);

        if (!$obj) {
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
            session_destroy();
            die(error_page("Gestión de Guardias", "Gestión de Guardias", $url . $respuesta));
        }

        if (isset($obj->error)) {
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $_SESSION["api_session"]);
            session_destroy();
            die(error_page("Gestión de Guardias", "Gestión de Guardias", $obj->error));
        }

        echo "<table>";

        echo "<tr>";
        echo "<th>Profesores de guardia</th>";
        echo "<th>Información del profesor con id: ";
        if (isset($_POST["btnDetallesUsuario"])) {
            echo $_POST["btnDetallesUsuario"];
        }
        echo "</th>";
        $primera_fila = true;
        foreach ($obj->usuarios as $tupla) {
            echo "<tr>";
            echo "<td>";
            echo "<form action='principal.php' method='post'><button value='" . $tupla->id_usuario . "' name='btnDetallesUsuario'>" . $tupla->nombre . "</button>";
            //Metemos todos los hidden que llevamos arrastrando:
            echo "<input type='hidden' name='dia' value='" . $_POST["dia"] . "'/>";
            echo "<input type='hidden' name='hora' value='" . $_POST["hora"] . "'/>";
            echo "<input type='hidden' name='equipo' value='" . $_POST["equipo"] . "'/>";
            echo "</form>";
            echo "</td>";
            if ($primera_fila) {
                echo "<td rowspan='" . count($obj->usuarios) . "'></td>";
                $primera_fila = false;
            }

        }
        echo "</tr>";

        echo "</table>";

        if (isset($_POST["btnDetalleUsuario"])) {

        }
    }
    ?>

</body>

</html>