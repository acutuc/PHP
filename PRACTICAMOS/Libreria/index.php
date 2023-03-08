<?php
require "src/ctes_funciones.php";
//Comprobamos errores al enviar:
if (isset($_POST["btnLogin"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    <title>Página Inicio</title>
</head>

<body>
    <h1>Librería</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Nombre de usuario: </label><input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"]))
                echo $_POST["usuario"] ?>">
                <?php
            if (isset($_POST["btnLogin"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>Campo vacío</span>";
                } else {
                    echo "<span class='error'>Nombre de usuario no existe</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label><input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST["btnLogin"]) && $error_clave) {
                echo "<span class='error'>Campo vacío</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin">Entrar</button>
        </p>
    </form>
    <h3>Listado de los libros</h3>
    <?php
    //Mostramos los libros:
    //Guardamos en url la dirección del servicio.
    $url = DIR_SERV . "/obtenerLibros";
    //En respuesta creamos una instancia de consumir_servicios_REST. Pasamos url, post o get y la sesión del servicio.
    $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
    //Creamos el objeto del array $respuesta:
    $obj = json_decode($respuesta);

    //Si no existe el objeto:
    if (!$obj) {
        //
    
    }
    if (isset($obj->error)) { //Si existe obj, pero con error
    
    }
    if (isset($obj->no_login)) { //Si existe obj, pero el tiempo de sesión expiró
        session_destroy();
        die("<p>El tiempo de sesión de la API ha expirado. Vuelva a loguearse</p>");
    }
    //Si no ha habido ningún error, recorremos los libros con un foreach y mostramos
    echo "<div id='libros'>";
    foreach ($obj->libros as $tupla) {
        echo "<p>
            <img src='../Libreria/images/" . $tupla->portada . "' alt='" . $tupla->titulo . "' tittle='" . $tupla->titulo . "'>
        </p>";
    }
    echo "</div>";
    ?>
</body>

</html>