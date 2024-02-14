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

if (isset($_POST["btnEditar"])) {
    $url = DIR_SERV . "/obtenerHorarioDiaHora/" . $_POST["profesor"];
    $datos["api_session"] = $_SESSION["api_session"];
    $datos["dia"] = $_POST["dia"];
    $datos["hora"] = $_POST["hora"];
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj3 = json_decode($respuesta);
    if (!$obj3) {
        session_destroy();
        die(error_page("Horarios profesores", $url));
    }
    if (isset($obj3->error)) {
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

        .enlace {
            background: none;
            border: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer;
        }
        .t_dia_hora{
            border:1px solid black;
            border-collapse: collapse;
            text-align: center;
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
    if (isset($_POST["profesor"]) || isset($_POST["btnEditar"])) {
        $url = DIR_SERV . "/horario/" . $_POST["profesor"];
        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj2 = json_decode($respuesta);
        if (!$obj2) {
            session_destroy();
            die("<p>" . $url . "</p>");
        }
        if (isset($obj2->error)) {
            session_destroy();
            die("<p>" . $obj->error . "</p>");
        }

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
                    if (isset($horario[$dia][$hora])) {
                        echo "<td class='centrar'>" . $horario[$dia][$hora] . "<form method='post' action='index.php'>";
                        echo "<button class='enlace' name='btnEditar'>Editar</button>";
                        echo "<input type='hidden' name='profesor' value='" . $_POST["profesor"] . "'/>";
                        echo "<input type='hidden' name='dia' value='" . $dia . "'/>";
                        echo "<input type='hidden' name='hora' value='" . $hora . "'/>";
                        echo "</form></td>";
                    } else {
                        echo "<td class='centrar'><form method='post' action='index.php'>";
                        echo "<button class='enlace' name='btnEditar'>Editar</button>";
                        echo "<input type='hidden' name='profesor' value='" . $_POST["profesor"] . "'/>";
                        echo "<input type='hidden' name='dia' value='" . $dia . "'/>";
                        echo "<input type='hidden' name='hora' value='" . $hora . "'/>";
                        echo "</form></td>";
                    }
                }
            }
            echo "</tr>";
        }
        echo "</table>";

        if (isset($_POST["btnEditar"])) {
            $dia_semana[1] = "Lunes";
            $dia_semana[] = "Martes";
            $dia_semana[] = "Miércoles";
            $dia_semana[] = "Jueves";
            $dia_semana[] = "Viernes";

            if ($_POST["hora"] < 4) {
                echo "<h2>Editando la " . $_POST["hora"] . "º hora (" . $horas[$_POST["hora"]] . ") del día " . $dia_semana[$_POST["dia"]] . "</h2>";
            } else {
                echo "<h2>Editando la " . ($_POST["hora"] - 1) . "º hora (" . $horas[$_POST["hora"]] . ") del día " . $dia_semana[$_POST["dia"]] . "</h2>";
            }

            echo "<table class='t_dia_hora'>";
            echo "<tr><th>Grupo</th><th>Acción</th></tr>";
            foreach ($obj->horario as $tupla) {
                echo "<tr>";

                echo "<td>" . $tupla->nombre . "</td>";
                echo "<td><form method='post' action='index.php'>";
                echo "<button name='btnQuitar' value='".$tupla->id_horario."'>Quitar</button>";
                echo "<input type='hidden' name='profesor' value='" . $_POST["profesor"] . "'/>";
                echo "<input type='hidden' name='dia' value='" . $_POST["dia"] . "'/>";
                echo "<input type='hidden' name='hora' value='" . $_POST["hora"] . "'/>";
                echo "</form></td>";

                echo "</tr>";
            }
            echo "</table>";
        }
    }
    ?>
</body>

</html>