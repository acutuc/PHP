<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer CRUD</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            background-color: lightgrey;
            padding: 0.5rem;
        }

        table {
            border-collapse: collapse;
            text-align: center;
        }

        img {
            width: 75px;
            height: 75px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Listado de los usuarios</h1>
    <?php
    //Nos conectamos:
    try {
        //Servidor, usuario, contraseña, BBDD.
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
        mysqli_set_charset($conexion, "utf8"); //Caracteres UTF-8
    } catch (Exception $e) {
        die("<p>Imposible conectar: " . $e->getMessage() . "</p></body></html>");
    }

    try {
        //Declaramos la consulta:
        $consulta = "SELECT * FROM usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido establecer conexión: " . $e->getMessage() . "</p></body></html>");
    }

    echo "<table>";
    echo "<tr><th>Nombre de usuario</th><th>Borrar</th><th>Editar</th></tr>";

    //Obtenemos las tuplas:
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";

        echo "<td><form action='index.php' method='post'><button type='submit' name='btnDetalle' class='enlace' value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</button></form></td>";
        echo "<td><img src='images/eliminar.jpg' alt='Borrar' title='Borrar Usuario'></td>";
        echo "<td><img src='images/editar.png' alt='Editar' title='Editar Usuario'></td>";

        echo "</tr>";
    }

    echo "</table>";

    if (isset($_POST["btnDetalle"])) {
        echo "<h3>Detalles de usuario con ID: " . $_POST["btnDetalle"] . "</h3>";
    } else {
        echo "<form action='usuario_nuevo.php' method='post'>";
        echo "<p><button type='submit' name='btnNuevoUsuario'>Insertar nuevo usuario</button></p>";
        echo "</form>";
    }



    //Cerramos conexion:
    mysqli_free_result($resultado);
    mysqli_close($conexion);

    ?>
</body>

</html>