<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 14</title>
    <meta charset="UTF-8">
</head>

<body>
    <?php
    $estadios_futbol = array("Barcelona" => "Camp Nou", "Real Madrid" => "Santiago Bernabeu", "Valencia" => "Mestalla", "Real Sociedad" => "Anoeta");
    $estadios_futbol2 = array("Barcelona" => "Camp Nou", "Real Madrid" => "", "Valencia" => "Mestalla", "Real Sociedad" => "Anoeta");

    echo "<table border='1'>";
    echo "<tr>";
    foreach ($estadios_futbol as $equipo => $campo) {
        echo "<td>" . $equipo . "</td>";
    }
    echo "</tr>";
    echo "<tr>";
    foreach ($estadios_futbol as $equipo => $campo) {
        echo "<td>" . $campo . "</td>";
    }
    echo "</tr>";
    echo "</table>";

    echo "<ol>";
    foreach ($estadios_futbol2 as $equipo => $campo) {
        echo "<li>" . $equipo . " --> " . $campo . "</li>";
    }
    echo "</ol>";


    ?>
</body>

</html>