<?php
session_name("examen_final");
session_start();

require "src/funciones_ctes.php";

//No podemos entrar a la página si no estamos logueados
if (!isset($_SESSION["usuario"])) {
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
            <?php echo $_SESSION["datos"]->usuario ?>
        </strong>
    <form method="post" action="index.php"><button name="btnSalir">Salir</button></form>
    </p>

    <?php
    echo "<h2>Equipos de Guardia del IES Mar de Alborán</h2>";

    $url = DIR_SERV . "/guardiasUsuario/" . $_SESSION["datos"]->id_usuario;

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

    $datos_guardia = $obj->guardias;

    foreach ($datos_guardia as $tupla) {
        $horario["dia"][] = $tupla->dia;
        $horario["hora"][] = $tupla->hora;
    }

    var_dump($horario);

    $dias_semana[0] = "";
    $dias_semana[1] = "Lunes";
    $dias_semana[2] = "Martes";
    $dias_semana[3] = "Miércoles";
    $dias_semana[4] = "Jueves";
    $dias_semana[5] = "Viernes";


    echo "<table class=''>";

    echo "<tr>";
    for ($i = 0; $i < 6; $i++) {
        echo "<th>" . $dias_semana[$i] . "</th>";
    }
    echo "</tr>";

    for ($i = 1; $i < 7; $i++) {
        switch ($i) {
            case 1:
                echo "<tr>";
                if ($i == 1) {
                    echo "<td>" . $i . "º Hora</td>";
                }
                for ($o = 1; $o < 7; $o++) {
                    if ($horario["dia"][$i + 1] == $i) {
                        echo "<td>si</td>";
                    }
                }
                echo "</tr>";
                break;
            case 2:
                echo "<tr>";
                if ($i == 2) {
                    echo "<td>" . $i . "º Hora</td>";
                }
                for ($o = 1; $o < 7; $o++) {
                    if ($horario["dia"][$i + 1] == $i) {
                        echo "<td>si</td>";
                    }
                }
                echo "</tr>";
                break;
            case 3:
                echo "<tr>";
                if ($i == 3) {
                    echo "<td>" . $i . "º Hora</td>";
                }
                for ($o = 1; $o < 7; $o++) {
                    if ($horario["dia"][$i] == $i) {
                        echo "<td>si</td>";
                    }
                }
                echo "</tr>";
                break;
            case 4:
                echo "<tr><td colspan='6'>RECREO</td></tr>";
                echo "<tr>";
                if ($i == 4) {
                    echo "<td>" . $i . "º Hora</td>";
                }
                echo "</tr>";
                break;
            case 5:
                echo "<tr>";
                if ($i == 5) {
                    echo "<td>" . $i . "º Hora</td>";
                }
                echo "</tr>";
                break;
            case 6:
                echo "<tr>";
                if ($i == 6) {
                    echo "<td>" . $i . "º Hora</td>";
                }
                
                echo "</tr>";
                break;
        }
    }


    echo "</table>";



    echo $horario["dia"][0];
    ?>

</body>

</html>