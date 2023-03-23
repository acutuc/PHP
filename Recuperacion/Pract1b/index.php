<?php
if(isset($_POST["btnBorrar"])){
    unset($_POST);
}
if (isset($_POST["btnEnviar"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_sexo = !isset($_POST["sexo"]);
    $error_comentarios = $_POST["comentarios"] == "";
    $error_foto = $_FILES["foto"]["name"] == "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500000);

    $error_formulario = $error_nombre || $error_sexo || $error_comentarios || $error_foto;
}

if (isset($_POST["btnEnviar"]) && !$error_formulario) {
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Segundo Formulario</title>
    </head>

    <body>
        <h1>Estos son los datos enviados:</h1>
        <p>
            El nombre enviado ha sido:
            <?php echo $_POST["nombre"] ?>
        </p>
        <p>
            Ha nacido en:
            <?php echo $_POST["nacido"] ?>
        </p>
        <p>
            El sexo es:
            <?php echo $_POST["sexo"] ?>
        </p>
        <p>
            Las aficiones seleccionadas han sido: 
        <?php
        if (isset($_POST["aficiones"])) {
            $numero_aficiones = count($_POST["aficiones"]);
            echo "<ol>";
            for ($i = 0; $i < $numero_aficiones; $i++) {
                
                    echo "<li>" . $_POST["aficiones"][$i] . "</li>";
                
            }
            echo "</ol>";
        } else {
            echo "No has seleccionado ninguna afición";
        }
        ?>
        </p>
        <p>
            El comentario enviado ha sido:
            <?php echo $_POST["comentarios"] ?>
        </p>
        <h3>Información de la imagen seleccionada</h3>
        <p>
            Error:
            <?php echo $_FILES["foto"]["error"] ?><br>
            Nombre:
            <?php echo $_FILES["foto"]["name"] ?><br>
            Ruta en Servidor:
            <?php echo $_FILES["foto"]["tmp_name"] ?><br>
            Tipo archivo:
            <?php echo $_FILES["foto"]["type"] ?><br>
            Tamaño archivo:
            <?php echo $_FILES["foto"]["size"] ?> bytes
        </p>
        <p>
            <?php
            if ($_FILES["foto"]["name"] != "") {
                $uniq = md5(uniqid(uniqid(), true));
                $arr_nombre = explode(".", $_FILES["foto"]["name"]);
                $ext = "";
                if (count($arr_nombre) > 1) {
                    $ext = "." . end($arr_nombre);
                }

                $nuevo_nombre = "img_" . $uniq . $ext;
                @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "images/" . $nuevo_nombre);
            }
            if ($var) {
                echo "La imagen ha sido subida con éxito";
                echo "<p>
                    <img src='images/" . $nuevo_nombre . "' alt='Imagen' tittle='Imagen'>
                </p>";
            } else {
                echo "Ha habido un fallo al cargar la imagen";
            }
            ?>
        </p>
    </body>

    </html>
    <?php
} else {

    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .oculta {
                display: none;
            }

            .error {
                color: red;
            }
        </style>
        <title>Segundo Formulario</title>
    </head>

    <body>
        <h1>Segundo Formulario</h1>
        <form method="post" action="index.php" enctype="multipart/form-data">
            <p>
                <label for="nombre">Nombre: </label><input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST["nombre"]))
                    echo $_POST["nombre"] ?>">
                    <?php
                if (isset($_POST["btnEnviar"]) && $error_nombre) {
                    echo "<span class='error'>* Campo obligatorio *</span>";
                }
                ?>
            </p>
            <p>
                <label for="nacido">Nacido en: </label>
                <select id="nacido" name="nacido">
                    <option value="Málaga">Málaga</option>
                    <option value="Cádiz" <?php if (isset($_POST["nacido"]) && $_POST["nacido"] == "Cádiz")
                        echo "selected"; ?>>Cádiz</option>
                    <option value="Granada" <?php if (isset($_POST["nacido"]) && $_POST["nacido"] == "Granada")
                        echo "selected"; ?>>Granada</option>
                </select>
            </p>
            <p>
                Sexo:
                <label for="hombre">Hombre</label><input type="radio" name="sexo" id="hombre" value="hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre")
                    echo "checked"; ?>>
                <label for="mujer">Mujer</label><input type="radio" name="sexo" id="mujer" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer")
                    echo "checked"; ?>>
                <?php
                if (isset($_POST["btnEnviar"]) && $error_sexo) {
                    echo "<span class='error'>* Campo obligatorio *</span>";
                }
                ?>
            </p>
            <p>
                Aficiones:
                <?php
                if (isset($_POST["aficiones"]) && in_array("Deportes",$_POST["aficiones"])) {
                    echo "<label for='deportes'>Deportes</label><input type='checkbox' id='deportes' name='aficiones[]' value='Deportes' checked>";
                } else {
                    echo "<label for='deportes'>Deportes</label><input type='checkbox' id='deportes' name='aficiones[]' value='Deportes'>";
                }
                if (isset($_POST["aficiones"]) && in_array("Lectura", $_POST["aficiones"])) {
                    echo "<label for='lectura'>Lectura</label><input type='checkbox' id='lectura' name='aficiones[]' value='Lectura' checked>";
                } else {
                    echo "<label for='lectura'>Lectura</label><input type='checkbox' id='lectura' name='aficiones[]' value='Lectura'>";
                }
                if (isset($_POST["aficiones"])  && in_array("Otros", $_POST["aficiones"])) {
                    echo "<label for='otros'>Otros</label><input type='checkbox' id='otros' name='aficiones[]' value='Otros' checked>";
                } else {
                    echo "<label for='otros'>Otros</label><input type='checkbox' id='otros' name='aficiones[]' value='Otros'>";
                }
                ?>
            </p>
            <p>
                <label for="comentarios">Comentarios: </label>
                <textarea id="comentarios" name="comentarios"><?php if (isset($_POST["comentarios"]))
                    echo $_POST["comentarios"]; ?></textarea>
                <?php
                if (isset($_POST["btnEnviar"]) && $error_comentarios) {
                    echo "<span class='error'>* Campo obligatorio *</span>";
                }
                ?>
            </p>
            <p>
                <label for="foto">Incluir mi foto (Archivo de tipo imagen Máx. 500KB): </label>
                <button type="submit" onclick="document.getElementById('foto').click();return false;">Seleccionar
                    archivo</button><input class="oculta"
                    onchange="document.getElementById('nombre_archivo').innerHTML=' '+document.getElementById('foto').files[0].name+' ';"
                    type="file" name="foto" id="foto" accept="image/*"><span id="nombre_archivo"></span>
                <?php
                if (isset($_POST["btnEnviar"]) && $error_foto) {
                    echo "<span class='error'>* Error: debes seleccionar un archivo *</span>";
                }
                ?>
            </p>
            <p>
                <button type="submit" name="btnEnviar">Enviar</button> <button type="submit" name="btnBorrar">Borrar
                    Campos</button>
            </p>
        </form>
    </body>

    </html>
    <?php
}
?>