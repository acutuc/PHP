<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login PDO</title>
</head>

<body>
    <div>
        Bienvenido <strong>
            <?php $datos_usuario_log["usuario"]; ?>
        </strong> -
        <form style="display:inline" action="index.php" method="post">
            <button type="submit" name="btnSalir">Salir</button>
        </form>
    </div>

    <?php
    try {
        $consulta = "SELECT * FROM usuarios WHERE tipo <> 'admin'";

        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();

        $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia = null;
        echo "<h2>Listado de los usuarios no admin</h2>";
        echo "<table>";
        echo "<tr><th>NOMBRE</th><th>USUARIO</th></tr>";
        foreach ($respuesta as $tupla) {
            echo "<tr>";
            echo "<td>" . $tupla["nombre"] . "</td>";
            echo "<td>" . $tupla["usuario"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

    } catch (PDOException $e) {
        $sentencia = null; //Libera sentencia
        $conexion = null; //Cierra conexión
        die("<p>Imposible realizar la consulta. Error: " . $e->getMessage() . "</p></body></html>");
    }
    ?>
</body>

</html>