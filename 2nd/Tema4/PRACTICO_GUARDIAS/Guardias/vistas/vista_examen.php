<?php
//Primera tabla:
/*
$url = DIR_SERV . "/usuario/" . $datos_usu_log->id_usuario;
$respuesta = consumir_servicios_REST($url, "GET");
$obj = json_decode($respuesta);

if (!$obj) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_destroy();
    die(error_page("Gestión de Guardias", "<p>" . $url . "</p>"));
}
if (isset($obj->error)) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_destroy();
    die(error_page("Gestión de Guardias", "<p>" . $obj->error . "</p>"));
}
if (isset($obj->no_auth)) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_unset();
    $_SESSION["mensaje"] = "El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit();
}
if (isset($obj->mensaje)) {
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_unset();
    $_SESSION["mensaje"] = "Usted ha sido baneado de la base de datos.";
    header("Location:index.php");
    exit();
}
*/

//Segunda tabla:
if (isset($_POST["btnEquipo"])) {
    if ($_POST["hora"] < 4) {
        $url = DIR_SERV . "/usuariosGuardia/" . $_POST["dia"] . "/" . $_POST["hora"];
    } else {
        $url = DIR_SERV . "/usuariosGuardia/" . $_POST["dia"] . "/" . ($_POST["hora"] - 1);
    }
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj2 = json_decode($respuesta);

    if (!$obj2) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        session_destroy();
        die(error_page("Gestión de Guardias", "<p>" . $url . "</p>"));
    }
    if (isset($obj2->error)) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        session_destroy();
        die(error_page("Gestión de Guardias", "<p>" . $obj2->error . "</p>"));
    }
    if (isset($obj2->no_auth)) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        session_unset();
        $_SESSION["mensaje"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit();
    }
    if (isset($obj2->mensaje)) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
        session_unset();
        $_SESSION["mensaje"] = "Usted ha sido baneado de la base de datos.";
        header("Location:index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .enlace {
            color: blue;
            background: none;
            border: none;
            text-decoration: underline;
            cursor: pointer;
        }

        table {
            margin: 0 auto;
            width: 80%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid black;
        }

        th {
            background-color: lightgrey;
        }

        .centrar {
            text-align: center;
        }
    </style>
    <title>Gestión de Guardias</title>
</head>

<body>
    <h1>Gestión de Guardias</h1>
    <form method="post" action="index.php">
        Bienvenido <strong><?php echo $datos_usu_log->usuario ?></strong> - <button class='enlace' name="btnSalir">Salir</button>
    </form>
    <h2>Equipos de Guardia del IES Mar de Alborán</h2>
    <?php
    $dias = array("", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes");
    $horas = array(1 => "1º Hora", "2º Hora", "3º Hora", "4º Hora", "5º Hora", "6º Hora");
    $contador = 1;
    echo "<table>";
    echo "<tr>";
    for ($i = 0; $i < 6; $i++) {
        echo "<th>" . $dias[$i] . "</th>";
    }
    echo "</tr>";

    for ($hora = 1; $hora < 8; $hora++) {
        echo "<tr>";
        for ($dia = 0; $dia < 6; $dia++) {
            if ($dia == 0) {
                if ($hora == 4) {
                    echo "<td colspan='6' class='centrar'>RECREO</td>";
                } else if ($hora > 4) {
                    echo "<th>" . $horas[$hora - 1] . "</th>";
                } else {
                    echo "<th>" . $horas[$hora] . "</th>";
                }
            } else {
                if ($hora != 4) {
                    echo "<td class='centrar'><form method='post' action='index.php'>";
                    echo "<input type='hidden' name='dia' value='" . $dia . "'/>";
                    echo "<input type='hidden' name='hora' value='" . $hora . "'/>";
                    echo "<button name='btnEquipo' class='enlace' value='" . $contador . "'>Equipo " . $contador . "</button>";
                    echo "</form></td>";
                }
            }
            if ($dia != 0 && $hora != 4) {
                $contador++;
            }
        }
        echo "</tr>";
    }

    echo "</table>";

    if (isset($_POST["btnEquipo"])) {
        echo "<h2>EQUIPO DE GUARDIA " . $_POST["btnEquipo"] . "</h2>";
        if ($_POST["hora"] < 4) {
            echo "<h3>" . $dias[$_POST["dia"]] . " a " . $horas[$_POST["hora"]] . "</h3>";
        } else {
            echo "<h3>" . $dias[$_POST["dia"]] . " a " . $horas[($_POST["hora"] - 1)] . "</h3>";
        }

        $aux = false;
        foreach ($obj2->usuarios as $tupla) {
            if ($tupla->usuario == $datos_usu_log->usuario) {
                $aux = true;
            }
        }

        if ($aux) {
            foreach ($obj2->usuarios as $tupla) {
                $profesores[] = $tupla->nombre;
            }
            echo "<table>";
            echo "<tr><th>Profesores de Guardia</th><th>Información del Profesor con id_usuario: </th></tr>";
            for($i = 0; $i < count($profesores); $i++){
                echo "<tr>";
                echo "<td>".$profesores[$i]."</td>";
                if($i == 0){
                    echo "<td rowspan='".count($profesores)."'></td>";
                }                
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    ?>
</body>

</html>