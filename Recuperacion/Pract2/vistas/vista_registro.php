<?php
//Si pulsamos Guardar Cambios, en el formulario de registro:
if (isset($_POST["btnBorrar"])) {
    unset($_POST);
}

if (isset($_POST["btnGuardar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_nombre = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !bien_escrito($_POST["dni"]);
    @$error_imagen = $_FILES["imagen"]["name"] != "" && ($_FILES["imagen"]["error"] || !getimagesize($_FILES["imagen"])["tmp_name"] || $_FILES["imagen"]["size"] > 500000);

    $error_formulario = $error_usuario || $error_nombre || $error_clave || $error_dni || $error_imagen;

    //Si no hay error, hacemos el registro del nuevo usuario:
    if (!$error_formulario) {

    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .botones {
            display: flex;
            justify-content: space-around;
            width: 400px;
        }

        .error {
            color: red;
        }
    </style>
    <title>Práctica Rec2</title>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label><input type="text" name="usuario" id="usuario"
                placeholder="Usuario..." value="<?php if (isset($_POST["usuario"]))
                    echo $_POST["usuario"] ?>">
                <?php
                if (isset($_POST["btnGuardar"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>*Campo vacío*</span>";
                    } else {
                        echo "<span class='error'>*Usuario ya se encuentra registrado*</span>";
                    }
                }
                ?>
        </p>
        <p>
            <label for="nombre">Nombre: </label><input type="text" name="nombre" id="nombre" placeholder="Nombre..."
                value="<?php if (isset($_POST["nombre"]))
                    echo $_POST["nombre"]; ?>">
            <?php
            if (isset($_POST["btnGuardar"]) && $error_nombre) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label><input type="password" name="clave" id="clave"
                placeholder="Contraseña...">
            <?php
            if (isset($_POST["btnGuardar"]) && $error_clave) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="dni">DNI: </label><input type="text" name="dni" id="dni" placeholder="DNI: 11223344Z" value="<?php if (isset($_POST["dni"]))
                echo $_POST["dni"]; ?>">
            <?php
            if (isset($_POST["btnGuardar"]) && $error_dni) {
                if ($_POST["dni"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error'>*Formato no válido*</span>";
                }
            }
            ?>
        </p>
        <p>
            Sexo: <br>
            <input type="radio" name="sexo" id="hombre" value="hombre" checked> <label for="hombre">Hombre</label><br>
            <input type="radio" name="sexo" id="mujer" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer")
                echo "checked"; ?>> <label for="mujer">Mujer</label>
        </p>
        <p>
            <label for="imagen">Incluir mi foto (Máx. 500KB) </label><input type="file" accept="image/*" name="imagen"
                id="imagen">
        </p>
        <p>
            <input type="checkbox" id="suscripcion" value="suscripcion" name="suscripcion"> <label
                for="suscripcion">Suscribirme al boletín de novedades</label>
        </p>
        <p class="botones">
            <button type="submit" name="btnGuardar">Guardar Cambios</button> <button type="submit"
                name="btnBorrar">Borrar los datos introducidos</button>
        </p>
    </form>
</body>

</html>