<?php
require "src/bd_config.php";


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Práctica 9</title>
    <meta charset="UTF-8">
    <style>

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
        h1 {
            text-align:center;
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
        echo "<td><form action='index.php' method='post'><button type='submit' name='btnListar' class='enlace' value='" . $tupla["idPelicula"] . "'>" . $tupla["titulo"] . "</button></form></td>";
        echo "<td><img src='Img/" . $tupla["caratula"] . "' title='Imagen carátula' alt='Imagen carátula'</td>";
        echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_caratula' value='" . $tupla["caratula"] . "'><button type='submit' name='btnBorrar' value='" . $tupla["idPelicula"] . "' class='enlace'>Borrar</button>&nbsp; - &nbsp; <button type='submit' name='btnEditar' value='" . $tupla["idPelicula"] . "' class='enlace'>Editar</button></form></td>";
        //ATENCIÓN ARRIBA. Input hidden.

        echo "</tr>";
    }

    echo "</table>";

    mysqli_free_result($resultado);
} catch (Exception $e) {
    $mensaje = "Imposible realizar la consulta. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . ".";
    mysqli_close($conexion);
    die($conexion);
}

//3. Operaciones CRUD.

//3.1 Listar:
if (isset($_POST["btnListar"])) {
    echo "<h3>Película con ID: " . $_POST["btnListar"] . "</h3>";

    $consulta = "SELECT * FROM peliculas WHERE idPelicula='" . $_POST["btnListar"] . "'";

    try {
        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {

            $datos_usuario = mysqli_fetch_assoc($resultado);

            echo "<p><strong>Título: </strong>" . $datos_usuario["titulo"] . "</p>";
            echo "<p><strong>Director: </strong>" . $datos_usuario["director"] . "</p>";
            echo "<p><strong>Sinopsis: </strong>" . $datos_usuario["sinopsis"] . "</p>";
            echo "<p><strong>Temática: </strong>" . $datos_usuario["tematica"] . "</p>";
            echo "<p><strong>Carátula: </strong></p>";
            echo "<p><img src='Img/" . $datos_usuario["caratula"] . "' alt='Carátula' title='Carátula'></img></p>";
        }
    } catch (Exception $e) {
        $mensaje = "Imposible realizar la consulta. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . ".";
        mysqli_close($conexion);
        die($conexion);
    }
}

//3.2 Borrar:
if (isset($_POST["btnBorrar"])) {
    echo "<h3>Borrado de la película con ID: " . $_POST["btnBorrar"] . "</h3>";
    echo "<p>¿Seguro?</p>";
    echo "<p>";
    echo "<form action='index.php' method='post'><input type='hidden' name='nombre_caratula' value='" . $_POST["nombre_caratula"] . "'" . $_POST["nombre_caratula"] . "'><button type='submit' action='index.php'>Volver</button><button type='submit' value='" . $_POST["btnBorrar"] . "' name='btnContinuarBorrar'>Continuar</button></form>"; //ATENCIÓN. Input hidden.
    echo "</p>";
    //VAMOS ARRIBA
}

//3.2.1 Confirmación borrado.
if (isset($_POST["btnContinuarBorrar"])) {
    $consulta = "DELETE FROM peliculas WHERE idPelicula = '" . $_POST["btnContinuarBorrar"] . "'";

    try {
        mysqli_query($conexion, $consulta);
        $mensaje_accion = "Usuario borrado con éxito"; //MENSAJE ACCIÓN.
        //BORRAMOS FOTO SI ES DIFERENTE A no_imagen.jpg
        if ($_POST["nombre_caratula"] != "no_imagen.jpg" && is_file("Img/" . $_POST["nombre_caratula"])) {
            unlink("Img/" . $_POST["nombre_caratula"]);
        }
    } catch (Exception $e) {
        $mensaje = "Imposible realizar la consulta. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . ".";
        mysqli_close($conexion);
        die($conexion);
    }
}

//Mensaje acción:
if (isset($mensaje_accion)) {
    echo "<p>" . $mensaje_accion . "</p>";
}

//Cerramos conexión
mysqli_close($conexion);

?>

</html>