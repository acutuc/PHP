<?php
require "src/bd_config.php";

//FUNCIONES:
function repetido($conexion, $tabla, $columna, $valor, $columna_clave = null, $valor_clave = null){
    if (isset($columna_clave))
        $consulta = "select " . $columna . " from " . $tabla . " where " . $columna . "='" . $valor . "' AND " . $columna_clave . "<>'" . $valor_clave . "'";
    else
        $consulta = "select " . $columna . " from " . $tabla . " where " . $columna . "='" . $valor . "'";
    try {
        $resultado = mysqli_query($conexion, $consulta);
        $respuesta = mysqli_num_rows($resultado) > 0;
        mysqli_free_result($resultado);
    } catch (Exception $e) {
        $respuesta = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . " : " . mysqli_error($conexion);
    }
    return $respuesta;
}

function pag_error($title, $encabezado, $mensaje){
    return "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'/><title>" . $title . "</title></head><body><h1>" . $encabezado . "</h1><p>" . $mensaje . "</p></body></html>";
}


//3.2.1. Volvemos a conectar con la base de datos:
try {
    $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_videoclub");
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    $mensaje = "No se ha podido realizar la conexión. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion);
}

//3.2.2. Confirmación borrado.
if (isset($_POST["btnContinuarBorrar"])) {
    $consulta = "DELETE FROM peliculas WHERE idPelicula = '" . $_POST["btnContinuarBorrar"] . "'";
    //Borrado de la imagen si es diferente a no_imagen.jpg :
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
        die($mensaje);
    }
}

//3.3.1. Confirmación agregar:
if (isset($_POST["btnConfirmarAgregar"])) {

    $error_titulo = $_POST["titulo"] == "";
    $error_director = $_POST["director"] == "";

    if (!$error_titulo && !$error_director) {

        $titulo_repetido = repetido($conexion, "peliculas", "titulo", $_POST["titulo"]);
        $director_repetido = repetido($conexion, "peliculas", "director", $_POST["director"]);

        $error_titulo = $titulo_repetido && $director_repetido;
        $error_director = $titulo_repetido && $director_repetido;

        if (is_string($error_titulo)) {
            mysqli_close($conexion);
            die(pag_error("Práctica 9 - Javier Parodi", "Videoclub", $error_titulo));
        }
    }

    $error_tematica = $_POST["tematica"] == "";
    $error_sinopsis = $_POST["sinopsis"] == "";
    $error_caratula = $_FILES["caratula"]["name"] != "" &&
        ($_FILES["caratula"]["error"] || !getimagesize($_FILES["caratula"]["tmp_name"]) || $_FILES["caratula"]["size"] > 1000000);



    $error_form = $error_titulo || $error_director || $error_tematica || $error_sinopsis || $error_caratula;

    if (!$error_form) {

        $consulta = "INSERT INTO peliculas (titulo, director, tematica, sinopsis)
                VALUES ('" . $_POST["titulo"] . "','" . $_POST["director"] . "','" . $_POST["tematica"] . "','" . $_POST["sinopsis"] . "')";

        try {
            mysqli_query($conexion, $consulta);
            $mensaje_accion = "Película insertada con éxito";

            //Si hay foto:
            if ($_FILES["caratula"]["name"] != "") {
                //Trataremos de moverla
                $ultimo_id = mysqli_insert_id($conexion);
                $extension = "";
                //Separamos por puntos:
                $arr_nombre = explode(".", $_FILES["caratula"]["name"]);
                //Si tiene extension:
                if (count($arr_nombre) > 1)
                    $extension = "." . strtolower(end($arr_nombre));
                $nueva_imagen = "img_" . $ultimo_id . $extension;
                // Intentamos moverla a la carpeta Img:
                @$var = move_uploaded_file($_FILES["caratula"]["tmp_name"], "Img/" . $nueva_imagen);

                if ($var) {
                    try {
                        $consulta = "UPDATE peliculas SET caratula = '" . $nueva_imagen . "' WHERE idPelicula ='" . $ultimo_id . "'";
                        mysqli_query($conexion, $consulta);
                    } catch (Exception $e) {
                        if (is_file("Img/" . $nueva_imagen))
                            unlink("Img/" . $nueva_imagen);

                        $mensaje = "Ha sido imposible añadir la carátula. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
                        mysqli_close($conexion);
                        die(pag_error("Práctica 9", "Práctica 9", $mensaje));
                    }
                } else {
                    $mensaje_accion = "Película añadida con imagen por defecto. No ha sido posbile subir la imagen al servidor";
                }
            }
        } catch (Exception $e) {

            $mensaje = "Imposible realizar la inserción. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
            mysqli_close($conexion);
            die(pag_error("Práctica 9", "Videoclub", $mensaje));
        }
    }
}

//3.4.1 Confirmación editar
if(isset($_POST[""]))

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
            text-align: center;
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
    //ENVIAMOS EL VALUE DEL HIDDEN (MIRAR ARRIBA).
}

//3.3. Insertar
if (isset($_POST["btnAgregar"])) {
?>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <label for="titulo">Título de la película: </label><br>
        <input type="text" name="titulo" id="titulo" value="<?php if (isset($_POST["titulo"])) echo $_POST["titulo"] ?>"><br><br>

        <label for="director">Director: </label><br>
        <input type="text" name="director" id="director" value="<?php if (isset($_POST["director"])) echo $_POST["director"] ?>"><br><br>

        <label for="sinopsis">Sinopsis: </label><br>
        <textarea name="sinopsis" id="sinopsis"><?php if (isset($_POST["sinopsis"])) echo $_POST["sinopsis"] ?></textarea><br><br>

        <label for="tematica">Temática: </label><br>
        <input type="text" name="tematica" id="tematica" value="<?php if (isset($_POST["tematica"])) echo $_POST["tematica"] ?>"><br><br>

        <label for="caratula">Inserte la carátula de la película: </label><br>
        <input type="file" name="caratula" id="caratula" accept="image/*"><br><br>

        <button type="submit" name="btnConfirmarAgregar">Añadir película</button>
    </form>
    <!--VOLVEMOS ARRIBA-->
<?php
}

//3.4 Editar
if(isset($_POST["btnEditar"])){
    $consulta = "SELECT * FROM peliculas WHERE idPelicula = '" . $_POST["btnEditar"] . "'";

    try {
        $resultado = mysqli_query($conexion, $consulta);
            $tupla = mysqli_fetch_assoc($resultado);
            $titulo = $tupla["titulo"];
            $director = $tupla["director"];
            $tematica = $tupla["tematica"];
            $sinopsis = $tupla["sinopsis"];
            $caratula = $tupla["caratula"];
    } catch (Exception $e) {
        $mensaje = "Imposible realizar la consulta. Error Nº " . mysqli_errno($conexion) . ": " . mysqli_error($conexion);
        mysqli_close($conexion);
        die($mensaje);
    }

    ?>
    <div class='centrar'>
        <h3>Editar película</h3>
        <form action="index.php" method="post" enctype="multipart/form-data">


            <table>
                <tr>
                    <td>
                        <p>
                            <label for="titulo" class="negrita">Título</label><br />
                            <input type="text" name="titulo" id="titulo" maxlength="15" placeholder="Título de la película" value="<?php echo $titulo; ?>" />
                            <?php
                            if (isset($_POST["boton_confirmar_editar"]) && $error_titulo)
                                if ($_POST["titulo"] == "")
                                    echo "<span class='error'>* Campo vacío</span>";
                                else
                                    echo "<span class='error'>* Película repetida, seleccione otro título o director</span>"; ?>
                        </p>
                    </td>
                    <td rowspan="3" class="texto-centrado">
                        <p id="borrar-foto">
                            <img src="Img/<?php echo $caratula; ?>" alt="Carátula" title="Carátula"><br /><br />
                            <?php if ($caratula != "no_imagen.jpg") echo "<button type='submit' name='boton_borrar_caratula'>Borrar carátula</button>" ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            <label for="director" class="negrita">Director</label><br />
                            <input type="text" name="director" id="director" maxlength="20" placeholder="Nombre del director" value="<?php echo $director; ?>" />
                            <?php if (isset($_POST["boton_confirmar_editar"]) && $error_director)
                                if ($_POST["director"] == "")
                                    echo "<span class='error'>* Campo vacío</span>";
                                else
                                    echo "<span class='error'>* Película repetida, seleccione otro título o director</span>"; ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            <label for="tematica" class="negrita">Temática</label><br />
                            <input type="text" name="tematica" id="tematica" maxlength="15" placeholder="Temática de la película" value="<?php echo $tematica; ?>" />
                            <?php if (isset($_POST["boton_confirmar_editar"]) && $error_tematica)
                                echo "<span class='error'>* Campo vacío</span>"; ?>
                        </p>
                    </td>
                </tr>
            </table>

            <p>
                <label for="sinopsis" class="negrita">Sinopsis</label><br />
                <textarea name="sinopsis" id="sinopsis" cols="30" rows="10" placeholder="Sinopsis de la película"><?php echo $sinopsis; ?></textarea>
                <?php if (isset($_POST["boton_confirmar_editar"]) && $error_sinopsis)
                    echo "<span class='error'>* Campo vacío</span>"; ?>
            </p>
            <p>
                <label for="caratula" class="negrita">Incluir carátula de la película (opcional)</label>
                <input type="file" accept="image/*" name="caratula" id="caratula" />
                <?php if (isset($_POST["boton_confirmar_editar"]) && $error_caratula) {

                    if ($_FILES["caratula"]["error"])
                        echo "<span class='error'>* Error en la subida del archivo</span>";
                    elseif (!getimagesize($_FILES["caratula"]["tmp_name"]))
                        echo "<span class='error'>* El archivo seleccionado no es una imagen</span>";
                    else
                        echo "<span class='error'>* El tamaño no puede superar 1 MB</span>";
                }

                ?>
            </p>

            <p>
                <button type='sumbit'>Volver</button>
                <button type='submit' name='boton_confirmar_editar'>Continuar</button>
                <input type="hidden" name="idPelicula" value="<?php echo $idPelicula; ?>">
                <input type="hidden" name="caratula" value="<?php echo $caratula; ?>">
            </p>
        </form>
    </div>
<?php
}

//Mensaje acción:
if (isset($mensaje_accion)) {
    echo "<p>" . $mensaje_accion . "</p>";
}

//Cerramos conexión
mysqli_close($conexion);

?>

</html>