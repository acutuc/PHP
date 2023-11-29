<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP</title>
</head>

<body>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los Profesores</h2>
    <?php
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_horarios_exam");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>Imposible realizar la conexión. Error: " . $e->getMessage() . "</p></body></html>");
    }
    ?>
    <p>

        <?php

        try {
            $consulta = "SELECT * FROM usuarios";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die("<p>Imposible realizar la consulta. Error: " . $e->getMessage() . "</p></body></html>");
        }

        echo "<form method='post' action='index.php'>";
        echo "<label for='profesor'>Horario del Profesor: </label>";
        echo "<select id='profesor' name='profesor'>";
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
        echo "</form>";

        if (isset($_POST["btnVerHorario"])){
            echo "<h3>Horario del Profesor: <em>".$nombre_profesor."</em></h3>";
        }
        ?>
    </p>
</body>

</html>