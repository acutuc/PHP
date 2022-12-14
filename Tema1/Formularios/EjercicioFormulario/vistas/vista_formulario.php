<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad Formulario FORMULARIO</title>
</head>

<body>
    <h1>Rellena tu CV</h1>
    <form method="post" action="index.php" enctype="multipart/form-data">
        <p>
            <label for="nombre">Nombre:</label><br />
            <input type="text" id="nombre" name="nombre" placeholder="Nombre..." value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>" />
            <?php
            if (isset($_POST["nombre"]) && $error_nombre) {
                echo "<span class='error'>*Campo obligatorio*</span>";
            }
            ?>
        </p>
        <p>
            <label for="usuario">Usuario:</label><br />
            <input type="text" id="usuario" name="usuario" placeholder="Usuario..." value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>" />
            <?php
            if (isset($_POST["usuario"]) && $error_usuario) {
                echo "<span class='error'>*Campo obligatorio*</span>";
            }
            ?>
        </p>
        <p>
            <label for="contrasenia">Contraseña:</label><br />
            <input type="password" id="contrasenia" name="contrasenia" placeholder="Contraseña..." />
            <?php
            if (isset($_POST["contrasenia"]) && $error_contrasenia) {
                echo "<span class='error'>*Campo obligatorio*</span>";
            }
            ?>
        </p>
        <p>
            <label for="dni">DNI:</label><br />
            <input type="text" id="dni" name="dni" placeholder="DNI: 11223344Z" value="<?php if (isset($_POST["dni"])) echo $_POST["dni"]; ?>" />
            <?php
            if (isset($_POST["dni"]) && $error_dni) {
                if ($_POST["dni"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                } elseif (!bien_escrito($_POST["dni"])) {
                    echo "<span class='error'>*Debes escribir un DNI con 8 dígitos y una letra*</span>";
                } else {
                    echo "<span class='error'>*DNI no válido*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label id="sexo">Sexo:</label><br />
            <input type="radio" id="hombre" name="sexo" for="sexo" value="hombre" <?php if (isset($_POST["btnGuardar"]) && $_POST["sexo"] == "hombre") echo "checked"?> /><label for="hombre">Hombre</label><br />
            <input type="radio" id="mujer" name="sexo" for="sexo" value="mujer" <?php if (isset($_POST["btnGuardar"]) && $_POST["sexo"] == "mujer") echo "checked"?> /><label for="mujer">Mujer</label>
            <?php
            if (isset($_POST["btnGuardar"]) && $error_sexo) {
                echo "<br/><span class='error'>*Seleccione sexo*</span>";
            }
            ?>
        </p>
        <p>
            <label for="imagen">Incluir mi foto (Archivo de tipo imagen Máx. 500KB): </label><input type="file" for="imagen" id="imagen" accept="image/*" />
        </p>
        <p>
            <input type="checkbox" id="suscripcion" name="suscripcion" /><label for="suscripcion">Suscribirme al boletín de Novedades: </label>
        </p>
        <p>
            <button type="submit" name="btnGuardar">Guardar cambios</button>&nbsp;<button type="reset" name="btnReset">Borrar los datos introducidos</button>
        </p>
    </form>
</body>

</html>