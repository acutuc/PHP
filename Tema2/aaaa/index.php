<?php
require "src/datos.php";
//CONEXIÓN
try {
    $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, PASSWORD_BD, BBDD);
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    die("<p>Imposible realizar la conexión. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error() . "</p>");
}

//CONFIRMAR BORRADO
if (isset($_POST["btnConfirmarBorrar"])) {
    try {
        $consulta = "DELETE FROM peliculas WHERE idPelicula = " . $_POST["btnConfirmarBorrar"];
        mysqli_query($conexion, $consulta);
        $mensaje_accion = "Película borrada con éxito";
    } catch (Exception $e) {
        $mensaje = "<p>Imposible realizar la conexión. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_connect_error() . "</p>";
        mysqli_close($conexion);
        die($mensaje);
    }
}

//CONFIRMAR EDICIÓN:
if (isset($_POST["btnConfirmarEditar"])) {
    try {
        $consulta = "UPDATE peliculas SET titulo = '".$_POST["titulo"]."', director = '".$_POST["director"]."', sinopsis = '".$_POST["sinopsis"]."', tematica = '".$_POST["tematica"]."' WHERE idPelicula = ".$_POST["btnConfirmarEditar"]."";
        mysqli_query($conexion, $consulta);
        $mensaje_accion = "Película editada con éxito";
    } catch (Exception $e) {
        $mensaje = "<p>Imposible realizar la conexión. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_connect_error() . "</p>";
        mysqli_close($conexion);
        die($consulta);
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <h1>PRUEBAS</h1>
    <?php
    try {
        $consulta = "SELECT * FROM peliculas";
        $resultado = mysqli_query($conexion, $consulta);

        echo "<table>";

        echo "<tr><th>ID</th><th>Título</th><th>Carátula</th><th><form action='index.php' method='post'><button type='submit' name='btnAgregar'>Películas +</button></form></th></tr>";

        while ($tupla = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";

            echo "<td>" . $tupla["idPelicula"] . "</td>";
            echo "<td><form action='index.php' method='post'><button type='submit' name='btnListar' value='" . $tupla["idPelicula"] . "'>" . $tupla["titulo"] . "</button></form></td>";
            echo "<td><img src='Img/" . $tupla["caratula"] . "' title='Carátula' alt='Carátula'></td>";
            echo "<td><form action='index.php' method='post'><button type='submit' name='btnBorrar' value='" . $tupla["idPelicula"] . "'>Borrar</button> - <button type='submit' name='btnEditar' value='" . $tupla["idPelicula"] . "'>Editar</button></form></td>";

            echo "</tr>";
        }

        echo "</table>";
        mysqli_free_result($resultado);
    } catch (Exception $e) {
        $mensaje = "<p>Imposible realizar la conexión. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_connect_error() . "</p>";
        mysqli_close($conexion);
        die($mensaje);
    }

    //LISTADO
    if (isset($_POST["btnListar"])) {
        echo "<h2>Listado de la película con ID: " . $_POST["btnListar"] . "</h2>";
        try {
            $consulta = "SELECT * FROM peliculas WHERE idPelicula = " . $_POST["btnListar"];
            $resultado = mysqli_query($conexion, $consulta);

            while ($datos = mysqli_fetch_assoc($resultado)) {
                echo "<p><strong>ID: </strong>" . $datos["idPelicula"] . "</p>";
                echo "<p><strong>Título: </strong>" . $datos["titulo"] . "</p>";
                echo "<p><strong>Director: </strong>" . $datos["director"] . "</p>";
                echo "<p><strong>Sinopsis: </strong>" . $datos["sinopsis"] . "</p>";
                echo "<p><strong>Temática: </strong>" . $datos["tematica"] . "</p>";
                echo "<img src='Img/" . $datos["caratula"] . "' alt='Carátula' title='Carátula'>";
            }
        } catch (Exception $e) {
            $mensaje = "<p>Imposible realizar la conexión. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_connect_error() . "</p>";
            mysqli_close($conexion);
            die($mensaje);
        }
    }

    //BORRADO.
    if (isset($_POST["btnBorrar"])) {
        echo "<form action='index.php' method='post'>";
        echo "<p><button type='submit'>Volver</button><button type='submit' name='btnConfirmarBorrar' value='" . $_POST["btnBorrar"] . "'>Confirmar</button></p>";
        echo "</form>";
    }

    //EDITAR.
    if (isset($_POST["btnEditar"])) {
        $id_pelicula = $_POST["btnEditar"];
        try {
            $consulta = "SELECT * FROM peliculas WHERE idPelicula = " . $id_pelicula;
            $resultado = mysqli_query($conexion, $consulta);

            if (mysqli_num_rows($resultado) > 0) {
                $datos_pelicula = mysqli_fetch_assoc($resultado);

                $titulo = $datos_pelicula["titulo"];
                $director = $datos_pelicula["director"];
                $sinopsis = $datos_pelicula["sinopsis"];
                $tematica = $datos_pelicula["tematica"];
            }
            mysqli_free_result($resultado);
        } catch (Exception $e) {
            $mensaje = "<p>Imposible realizar la conexión. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_connect_error() . "</p>";
            mysqli_close($conexion);
            die($mensaje);
        }

        echo "<h2>Editando la película con ID: " . $id_pelicula . "</h2>";
    ?>
        <form action="index.php" method="post">
            <p>
                <label for="titulo"><strong>Título: </strong></label>
                <input type="text" name="titulo" id="titulo">
            </p>
            <p>
                <label for="director"><strong>Director: </strong></label>
                <input type="text" name="director" id="director">
            </p>
            <p>
                <label for="sinopsis"><strong>Sinopsis: </strong></label>
                <input type="text" name="sinopsis" id="sinopsis">
            </p>
            <p>
                <label for="tematica"><strong>Temática: </strong></label>
                <input type="text" name="tematica" id="tematica">
            </p>

            <p>
                <button type="submit">Volver</button>&nbsp;
                <button type="submit" name="btnConfirmarEditar" value="<?php $id_pelicula ?>">Confirmar</button>
            </p>
        </form>

    <?php
    }

    if (isset($mensaje_accion)) {
        echo "<p>" . $mensaje_accion . "</p>";
    }


    mysqli_close($conexion);
    ?>
</body>

</html>