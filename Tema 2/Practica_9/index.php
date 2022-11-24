<?php
require "src/bd_config.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Práctica 9</title>
    <meta charset="UTF-8">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        img {
            height: 100px;
            width: auto;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .enlace {
            cursor: pointer;
            background: none;
            border: none;
            color: blue;
        }
    </style>
</head>

<body>
    <h1>Práctica 9</h1>
</body>
<?php
//1. Conectamos con la base de datos:
try {
    $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    die("No se ha podido realizar la conexión. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error() . ".");
}

//2. Consultamos los datos y pintamos la tabla.
try {
    $consulta = "SELECT * FROM peliculas";

    $resultado = mysqli_query($conexion, $consulta);

    echo "<h3>Listado de películas</h3>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Título</th><th>Carátula</th><th><form action='index.php' method='post'><button type='submit' name='btnAgregar' class='enlace'>Películas +</form></th></tr>";

    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";

        echo "<td>" . $tupla["idPelicula"] . "</td>";
        echo "<td><form action='index.php' method='post'><button type='submit' name='btnListar' class='enlace' value='" . $tupla["titulo"] . "'>" . $tupla["titulo"] . "</button></form></td>";
        echo "<td><img src='Img/" . $tupla["caratula"] . "' title='Imagen carátula' alt='Imagen carátula'</td>";
        echo "<td><form action='index.php' method='post'><button type='submit' name='btnBorrar' value='" . $tupla["idPelicula"] . "' class='enlace'>Borrar</button>&nbsp; - &nbsp; <button type='submit' name='btnEditar' value='" . $tupla["idPelicula"] . "' class='enlace'>Editar</button></form></td>";

        echo "</tr>";
    }

    echo "</table>";

    mysqli_free_result($resultado);
    mysqli_close($conexion);
} catch (Exception $e) {
    $mensaje = "Imposible realizar la consulta. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . ".";
    mysqli_close($conexion);
    die($conexion);
}

//3. Operaciones CRUD.

//Listar:
if (isset($_POST["btnListar"])) {
    echo "<h3>" . $_POST["btnListar"] . "</h3>";

    $consulta = "SELECT * FROM peliculas WHERE titulo='" . $_POST["btnListar"] . "'";

    try {
        $resultado = mysqli_query($conexion, $consulta);

        if(mysqli_num_rows($resultado) > 0){
            $datos_usuario = mysqli_fetch_assoc($resultado);

            echo "<p><strong>Título: </strong></p>";
            echo "<p><strong>Director: </strong></p>";
            echo "<p><strong>Sinopsis: </strong></p>";
            echo "<p><strong>Temática: </strong></p>";
        }
    } catch (Exception $e) {
        $mensaje = "Imposible realizar la consulta. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . ".";
        mysqli_close($conexion);
        die($conexion);
    }
}
?>

</html>