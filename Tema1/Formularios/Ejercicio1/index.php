<?php
if (isset($_GET["btnEnviar"])) {
    $error_nombre = $_GET["nombre"] == "";
    $error_apellidos = $_GET["apellidos"] == "";

    $error_formulario = $error_nombre || $error_apellidos;
}
//Si no existe btnEnviar o hay error en el formulario, mostramos la página inicial
if (!isset($_GET["btnEnviar"]) || $error_formulario) {

?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <title>Ejercicio 1</title>
        <meta charset="UTF-8">
    </head>

    <body>
        <h1>Ejercicio 1</h1>
        <p>
            Realizar un formulario que conste de dos cajas de texto: una para escribir los apellidos y la otra para el nombre. Añadiremos también un botón de Envío, de modo que al presionar el botón,
            los datos apellidos y el nombre se motrarán en una página PHP. Si el usuario no escribe en alguna de las cajas, se deberá notificar diciendo "Faltan valores". Utilizar el método GET.
            Realizarlo en un único documento.
        </p>
        <form action="index.php" method="GET" enctype="multipart/form-data">
            <label for="nombre">Nombre: </label><input type="text" id="nombre" name="nombre" value="<?php if (isset($_GET['nombre'])) echo $_GET['nombre']; ?>">
            <?php
            if (isset($_GET["nombre"]) && $error_nombre) {
                echo "<span class='error'>Faltan valores</span>";
            }
            ?>
            <br />
            <label for="apellidos">Apellidos: </label><input type="text" name="apellidos" id="apellidos" value="<?php if (isset($_GET['apellidos'])) echo $_GET['apellidos']; ?>">
            <?php
            if (isset($_GET["apellidos"]) && $error_apellidos) {
                echo "<span class='error'>Faltan valores</span>";
            }
            ?>
            <br />
            <button type="submit" name="btnEnviar">Enviar</button>
        </form>
    <?php
} else {
    echo "<h1>Respuestas</h1>";
    echo "<span><strong>Nombre: </strong>".$_GET["nombre"]."</span>";
    echo "<br/>";
    echo "<span><strong>Apellidos: </strong>".$_GET["apellidos"]."</span>";
}
    ?>
    </body>

    </html>