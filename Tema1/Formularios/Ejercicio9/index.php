<?php
if (isset($_POST["btnReset"])) {
    $_POST = array();
}

if (isset($_POST["btnEnviar"])) {
    $error_titulo = $_POST["titulo"] == "";
    $error_actores = $_POST["actores"] == "";
    $error_director = $_POST["director"] == "";
    $error_guion = $_POST["guion"] == "";
    $error_produccion = $_POST["produccion"] == "";
    $error_anio = $_POST["anio"] == "" || !is_numeric($_POST["anio"]);
    $error_nacionalidad = $_POST["nacionalidad"] == "";
    $error_duracion = $_POST["duracion"] == "" || !is_numeric($_POST["duracion"]);
    $error_restricciones = !isset($_POST["restricciones"]);
    $error_sinopsis = $_POST["sinopsis"] == "";

    $error_archivo = $_FILES["caratula"]["name"] == "" || $_FILES["caratula"]["error"] || $_FILES["caratula"]["type"] != "image/jpeg";

    $error_formulario = $error_titulo || $error_actores || $error_director || $error_guion || $error_produccion || $error_anio || $error_nacionalidad || $error_duracion || $error_restricciones || $error_sinopsis;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 9</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Ejercicio 9</h1>
    <p>
        Diseñar un formulario para introducir datos de películas. La sección Género contiene los siguientes datos: Comedia, Drama, Acción, Terror, Suspense, Otras.
        El año ha de ser un campo que ha de permitir como máximo 4 caracteres, duración como máximo ha de permitir 3 caracteres. El campo Carátula será de tipo archivo. Al clicar sobre el botón Enviar se ha de mostrar la información recogida en el formulario.
        El archivo solo podrá ser una imagen JPEG, sino ha de mostrar un error y no mostrar los datos de la imagen, si la imagen supera el máximo permitido también mostrará un error, y si la imagen no se ha cargado bien,
        o está vacía también ha de mostrar un error. En caso de que no ocurra nada de lo mencionado anteriormente, entonces se mostrarán los datos de la imagen, nombre, archivo temporal, tamaño... y se mostrará la imagen con un tamaño de 200 píxeles de alto y ancho.
    </p>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="titulo">Título</label></td>
                <td><label for="actores">Actores</label></td>
            </tr>
            <tr>
                <td><input type="text" id="titulo" name="titulo" value="<?php if (isset($_POST["titulo"])) echo $_POST["titulo"] ?>"></td>
                <td><input type="text" id="actores" name="actores" value="<?php if (isset($_POST["actores"])) echo $_POST["actores"] ?>"></td>
            </tr>
            <tr>
                <td><label for="director">Director</label></td>
                <td><label for="guion">Guión</label></td>
            </tr>
            <tr>
                <td><input type="text" id="director" name="director" value="<?php if (isset($_POST["director"])) echo $_POST["director"] ?>"></td>
                <td><input type="text" id="guion" name="guion" value="<?php if (isset($_POST["guion"])) echo $_POST["guion"] ?>"></td>
            </tr>
            <tr>
                <td><label for="produccion">Producción</label></td>
                <td><label for="anio">Año</label></td>
            </tr>
            <tr>
                <td><input type="text" id="produccion" name="produccion" value="<?php if (isset($_POST["produccion"])) echo $_POST["produccion"] ?>"></td>
                <td><input type="text" id="anio" name="anio" maxlength="4" size="4" value="<?php if (isset($_POST["anio"])) echo $_POST["anio"] ?>"></td>
            </tr>
            <tr>
                <td><label for="nacionalidad">Nacionalidad</label></td>
                <td><label for="genero">Género</label></td>
            </tr>
            <tr>
                <td><input type="text" id="nacionalidad" name="nacionalidad" value="<?php if (isset($_POST["nacionalidad"])) echo $_POST["nacionalidad"] ?>"></td>
                <td>
                    <select id="genero" name="genero">
                        <option value="0">Comedia</option>
                        <option value="1">Drama</option>
                        <option value="2">Acción</option>
                        <option value="3">Terror</option>
                        <option value="4">Suspense</option>
                        <option value="5">Otras</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="duracion">Duración</label></td>
                <td><label>Restricciones de edad</label></td>
            </tr>
            <tr>
                <td><input type="text" id="duracion" name="duracion" size="3" maxlength="3" value="<?php if (isset($_POST["duracion"])) echo $_POST["duracion"] ?>"><span>(minutos)</span></td>
                <td>
                    <input type="radio" id="todos-los-publicos" name="restricciones" value="todos los publicos" <?php if(isset($_POST["restricciones"]) && $_POST["restricciones"] == "todos los publicos") echo "checked"?>><label for="todos-los-publicos">Todos los públicos</label>&nbsp;
                    <input type="radio" id="mayores-7-anios" name="restricciones" value="mayores 7 años" <?php if(isset($_POST["restricciones"]) && $_POST["restricciones"] == "mayores 7 años") echo "checked"?>><label for="mayores-7-anios">Mayores de 7 años</label>&nbsp;
                    <input type="radio" id="mayores-18-anios" name="restricciones" value="mayores 18 años" <?php if(isset($_POST["restricciones"]) && $_POST["restricciones"] == "mayores 18 años") echo "checked"?>><label for="mayores-18-anios">Mayores de 18 años</label>
                </td>
            </tr>
            <tr>
                <td colspan="2"><label for="sinopsis">Sinopsis</label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" id="sinopsis" name="sinopsis" style="width:400px; height:150px" value="<?php if (isset($_POST["sinopsis"])) echo $_POST["sinopsis"] ?>"></td>
            </tr>
            <tr>
                <td><label for="caratula">Carátula</label></td>
                <td><input type="file" id="caratula" name="caratula" accept="image/*"></td>
            </tr>
            <tr>
                <td align=center><button type="submit" name="btnEnviar">Enviar</button></td>
                <td align=center><button type="submit" name="btnReset">Borrar</button></td>
            </tr>
        </table>
    </form>
    <?php
    if (isset($_POST["btnEnviar"]) && $error_formulario) {
        echo "<p class='error'>* HAY CAMPOS VACÍOS *</p>";
    }
    if (isset($_POST["btnEnviar"]) && $error_archivo) {
        if ($_FILES["caratula"]["name"] != "") {
            if ($_FILES["caratula"]["type"] != "image/jpeg") {
                echo "<span class='error'>El archivo subido no es JPEG.</span>";
            }
        }
    }
    if (isset($_POST["btnEnviar"]) && !$error_formulario && !$error_archivo) {
        echo "<h2>La película introducida es:</h2>";
        echo "<p><strong>Título: </strong>" . $_POST["titulo"] . "</p>";
        echo "<p><strong>Actores: </strong>" . $_POST["actores"] . "</p>";
        echo "<p><strong>Director: </strong>" . $_POST["director"] . "</p>";
        echo "<p><strong>Guión: </strong>" . $_POST["guion"] . "</p>";
        echo "<p><strong>Producción: </strong>" . $_POST["produccion"] . "</p>";
        echo "<p><strong>Año: </strong>" . $_POST["anio"] . "</p>";
        echo "<p><strong>Nacionalidad: </strong>" . $_POST["nacionalidad"] . "</p>";
        echo "<p><strong>Género: </strong>" . $_POST["genero"] . "</p>";
        echo "<p><strong>Duración: </strong>" . $_POST["duracion"] . "</p>";
        echo "<p><strong>Restricciones de edad: </strong>" . $_POST["restricciones"] . "</p>";
        echo "<p><strong>Carátula: </strong></p>";
        echo "<ul>";

        echo "<li><strong>Nombre: </strong>" . $_FILES["caratula"]["name"] . "</li>";
        echo "<li><strong>Tamaño: </strong>" . $_FILES["caratula"]["size"] . " bytes</li>";
        echo "<li><strong>Fichero temporal: </strong>" . $_FILES["caratula"]["tmp_name"] . "</li>";
        echo "<li><strong>Tipo: </strong>" . $_FILES["caratula"]["type"] . "</li>";
        echo "<li><strong>Error: </strong>" . $_FILES["caratula"]["error"] . "</li>";

        echo "</ul>";

        $array_nombre = explode(".", $_FILES["caratula"]["name"]);

        $extension = "";

        if (count($array_nombre) > 1) {
            $extension = "." . strtolower(end($array_nombre));
        }

        $extension = end($array_nombre);

        $nombre_unico = "img_" . md5(uniqid(uniqid(), true));

        $nombre_nuevo_archivo = $nombre_unico . $extension;

        @$var = move_uploaded_file($_FILES["caratula"]["tmp_name"], "images/" . $nombre_nuevo_archivo);

        if (!$var) {
            echo "<p>La imagen no ha posidio ser movida por falta de permisos.</p>";
        } else {
            echo "<h3>La imagen ha sido subida con éxito</h3>";
            echo "<img height = '200' width= '200' src='images/" . $nombre_nuevo_archivo . "'/>";
        }

        echo "<p><strong>Sinopsis: </strong></p>";
        echo "<p>".$_POST["sinopsis"]."</p>";
    }


    ?>
</body>

</html>