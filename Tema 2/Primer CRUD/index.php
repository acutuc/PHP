<?php
//Importamos el archivo que contiene los datos de la BD.
require "src/bd_config.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Primer CRUD</title>
    <meta charset="UTF-8">
    <style>
        table,
        th,
        td {
            border: 1px solid black
        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            text-align: center
        }

        img {
            height: 75px
        }

        .centrado {
            text-align: center;
        }

        .centrar {
            width: 80%;
            margin: 0 auto
        }
    </style>
</head>

<body>
    <h1>Listado de los usuarios</h1>
    <?php
    //Intentamos conexión.
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>Imposible conectar. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error() . "</p>");
    }

    //Consultamos a la base de datos.
    $consulta = "SELECT * FROM usuarios";

    try {
        $resultado = mysqli_query($conexion, $consulta);
        echo "<table class='centrado centrar'>";
        echo "<tr><th>Nombre de usuario</th><th>Borrar</th><th>Editar</th></tr>";
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $tupla["nombre"] . "</td>";
            echo "<td><img src='img/borrar.png' alt='Borrar' title='Borrar usuario'</td>";
            echo "<td><img src='img/editar.png' alt='Editar' title='Editar usuario'</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "<form class='centrar' action='usuario_nuevo.php' method='post'>";
        echo "<p><button type='submit' name='btnNuevo'>Insertar nuevo usuario</button></p>";
        echo "</form>";

        mysqli_free_result($resultado);

        //Cerramos conexion
        mysqli_close($conexion);
    } catch (Exception $e) {
        $mensaje = "<p>Imposible conectar. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . "</p>";
        mysqli_close($conexion);
        die($mensaje);
    }
    ?>

</body>

</html>