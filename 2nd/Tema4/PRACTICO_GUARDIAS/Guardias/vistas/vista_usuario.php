<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            border-collapse: collapse;
            margin: 0 auto;
            width: 80%;
        }

        th,
        td {
            border: 1px solid black;
        }

        th {
            background-color: lightgrey;
        }
    </style>
    <title>Gestión de Guardias</title>
</head>

<body>
    <h1>Gestión de Guardias</h1>
    <form method="post" action="index.php">
        <p>
            Bienvenido <strong><?php echo $datos_usu_log->usuario ?></strong> - <button name="btnSalir">Salir</button>
        </p>
    </form>
    <h2>Equipos de Guardia del IES Mar de Alborán</h2>
    <?php
    $dias_semana[0] = "";
    $dias_semana[1] = "Lunes";
    $dias_semana[2] = "Martes";
    $dias_semana[3] = "Miércoles";
    $dias_semana[4] = "Jueves";
    $dias_semana[5] = "Viernes";

    echo "<table'>";
    echo "<tr>";
    for ($i = 0; $i < 6; $i++) {
        echo "<th>" . $dias_semana[$i] . "</th>";
    }
    echo "</tr>";

    $cont = 1;
    for ($horas = 1; $horas <= 7; $horas++) {
        echo "<tr>";

        if ($horas == 4) {
            echo "<td colspan='6'>RECREO</td>";
        } else {
            if ($horas <= 3)
                echo "<td>" . $horas . "º Hora" . "</td>";
            else
                echo "<td>" . ($horas - 1) . "º Hora" . "</td>";
            for ($dias = 1; $dias <= 5; $dias++) {
                echo "<td>";
                echo "<form action='index.php' method='post'>";
                echo "<input type='hidden' name='dia' value='" . $dias . "'/>";
                echo "<input type='hidden' name='hora' value='" . $horas . "'/>";
                echo "<input type='hidden' name='equipo' value='" . $cont . "'/>";
                echo "<button class='enlace' name='btnVerEquipo'>Equipo " . $cont . "</button>";
                echo "</form>";
                echo "</td>";
                $cont++;
            }
        }

        echo "</tr>";
    }

    echo "</table>";
    ?>
</body>

</html>