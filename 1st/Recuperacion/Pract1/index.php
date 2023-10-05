<?php

function bien_escrito($texto)
{
    $dni = strtoupper($texto);
    return strlen($dni) == 9 && is_numeric(substr($dni, 0, 8)) && substr($dni, 8, 1) >= "A" && substr($dni, 8, 1) <= "Z";
}

//Si pulsamos Borrar, eliminamos todos los $_POST
if (isset($_POST["btnBorrar"])) {
    unset($_POST);
}

//Controlamos los errores
if (isset($_POST["btnGuardar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_nombre = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !bien_escrito($_POST["dni"]);
    $error_suscripcion = !isset($_POST["suscripcion"]);
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500000);

    $error_formulario = $error_usuario || $error_nombre || $error_clave || $error_dni || $error_suscripcion;
}
if (isset($_POST["btnGuardar"]) && !$error_formulario) {
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario CV</title>
    </head>

    <body>
        <h1>DATOS ENVIADOS</h1>
        <p>
            Usuario:
            <?php echo $_POST["usuario"] ?>
        </p>
        <p>
            DNI:
            <?php echo $_POST["dni"] ?>
        </p>
        <p>
            - - - - - - - - -
        </p>
        <?php
        if ($_FILES["foto"]["name"] != "") {
            $uniq = md5(uniqid(uniqid(), true));
            $arr_nombre = explode(".", $_FILES["foto"]["name"]);
            $ext = "";
            if (count($arr_nombre) > 1) {
                $ext = "." . end($arr_nombre);
            }

            $nuevo_nombre = "img_" . $uniq . $ext;
            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "img/" . $nuevo_nombre);

            ?>
            <p>
                <strong>Foto</strong>
            </p>
            <p>
                Nombre:
                <?php echo $_FILES["foto"]["name"] ?><br>
                Tipo:
                <?php echo $_FILES["foto"]["type"] ?><br>
                Tamaño:
                <?php echo $_FILES["foto"]["size"] ?>
            </p>
            <p>
                <?php if ($var) {
                    echo "La imagen se ha movido a la carpeta destino con éxito";
                } else {
                    echo "Ha habido un fallo al cargar la imagen";
                }
                ?>
            </p>

            <?php
            echo "<img src='img/" . $nuevo_nombre . "'>";
        }
        ?>
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
            .error{
                color:red;
            }
        </style>
        <title>Formulario CV</title>
    </head>

    <body>
        <h1>Rellena tu CV</h1>
        <form method="post" action="index.php" enctype="multipart/form-data">
            <p>
                <label for="usuario">Usuario:</label><br>
                <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"]))
                    echo $_POST["usuario"] ?>" placeholder="Usuario...">
                    <?php
                if (isset($_POST["btnGuardar"]) && $error_usuario) {
                    echo "<span class='error'>* Debes rellenar el usuario *</span>";
                }
                ?>
            </p>
            <p>
                <label for="nombre">Nombre:</label><br>
                <input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST["nombre"]))
                    echo $_POST["nombre"] ?>" placeholder="Nombre...">
                    <?php
                if (isset($_POST["btnGuardar"]) && $error_nombre) {
                    echo "<span class='error'>* Debes rellenar el nombre *</span>";
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña:</label><br>
                <input type="password" name="clave" id="clave" placeholder="Contraseña...">
                <?php
                if (isset($_POST["btnGuardar"]) && $error_clave) {
                    echo "<span class='error'>* Debes rellenar la contraseña *</span>";
                }
                ?>
            </p>
            <p>
                <label for="dni">DNI:</label><br>
                <input type="text" name="dni" id="dni" value="<?php if (isset($_POST["dni"]))
                    echo $_POST["dni"] ?>" placeholder="DNI: 11223344Z">
                    <?php
                if (isset($_POST["btnGuardar"]) && $error_dni) {
                    if ($_POST["dni"] == "") {
                        echo "<span class='error'>* Debes rellenar el DNI *</span>";
                    } elseif (!bien_escrito($_POST["dni"])) {
                        echo "<span class='error'>* Debes escribir un DNI con 8 dígitos y una letra *</span>";
                    }
                }
                ?>
            </p>
            <p>
                Sexo:<br>
                <input type="radio" name="sexo" value="hombre" id="hombre" checked><label for="hombre">Hombre</label><br>
                <input type="radio" name="sexo" value="mujer" id="mujer"><label for="mujer">Mujer</label>
            </p>
            <p>
                <label for="foto">Incluir mi foto (Max. 500KB)</label><input type="file" accept="image/*" name="foto"
                    id="foto">
            </p>
            <p>
                <input type="checkbox" name="suscripcion" id="suscripcion"><label for="suscripcion">Suscribirme al boletín
                    de novedades</label>
                <?php
                if (isset($_POST["btnGuardar"]) && $error_suscripcion) {
                    echo "<span class='error'>* Debes marcar la suscripción *</span>";
                }
                ?>
            </p>
            <p>
                <button type="submit" name="btnGuardar">Guardar Cambios</button> <button type="submit"
                    name="btnBorrar">Borrar los datos introducidos</button>
            </p>
        </form>

    </body>

    </html>
    <?php
}
?>