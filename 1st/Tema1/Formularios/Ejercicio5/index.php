<?php
if (isset($_POST["btnEnviar"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_apellido = $_POST["apellido"] == "";
    $error_calle = $_POST["calle"] == "";
    $error_cp = $_POST["cp"] == "" || !is_numeric($_POST["cp"]);
    $error_localidad = $_POST["localidad"] == "";

    $error_formulario = $error_nombre || $error_apellido || $error_calle || $error_cp || $error_localidad;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 5</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Ejercicio 5</h1>
    <p>
        Crear una página que solicite la información: nombre, apellido, calle, CP y localidad.<br />
        Cuando el usuario haga clic en el botón de envío, los datos se mostrarán en la propia página. Utilizar el método POST.
    </p>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <p>
            <label for="nombre">Nombre: </label><input type="text" id="nombre" name="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"] ?>">
            <?php
            if (isset($_POST["btnEnviar"]) && $error_nombre) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="apellido">Apellido: </label><input type="text" id="apellido" name="apellido" value="<?php if (isset($_POST["apellido"])) echo $_POST["apellido"] ?>">
            <?php
            if (isset($_POST["btnEnviar"]) && $error_apellido) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="calle">Calle: </label><input type="text" id="calle" name="calle" value="<?php if (isset($_POST["calle"])) echo $_POST["calle"] ?>">
            <?php
            if (isset($_POST["btnEnviar"]) && $error_calle) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="cp">Código Postal: </label><input type="text" id="cp" name="cp" value="<?php if (isset($_POST["cp"])) echo $_POST["cp"] ?>">
            <?php
            if (isset($_POST["btnEnviar"]) && $error_cp) {
                if ($_POST["cp"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error'>*Debe introducir un código postal válido*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="localidad">Localidad: </label><input type="text" id="localidad" name="localidad" value="<?php if (isset($_POST["localidad"])) echo $_POST["localidad"] ?>">
            <?php
            if (isset($_POST["btnEnviar"]) && $error_localidad){
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p><button type="submit" name="btnEnviar">Enviar</button></p>
    </form>
    <?php
        if(isset($_POST["btnEnviar"]) && !$error_formulario){
            echo "<h2>Respuestas del usuario:</h2>";
            echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
            echo "<p><strong>Apellido: </strong>".$_POST["apellido"]."</p>";
            echo "<p><strong>Calle: </strong>".$_POST["calle"]."</p>";
            echo "<p><strong>Código postal: </strong>".$_POST["cp"]."</p>";
            echo "<p><strong>Localidad: </strong>".$_POST["localidad"]."</p>";
        }
    ?>
</body>

</html>