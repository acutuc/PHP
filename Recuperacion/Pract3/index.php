<?php
function consumir_servicios_rest($url, $metodo, $datos = null)
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos)) {
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    }
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

define("DIR_SERV", "http://localhost/PHP/Recuperacion/Pract3/servicios_rest/");

    if(isset($_POST["btnLoguear"])){
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";

        $error_formulario = $error_usuario || $error_clave;

        if(!$error_formulario){
            $url = ;
            $respuesta = consumir_servicios_rest();
        }
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 3</title>
</head>

<body>
    <h1>Login</h1>
    SI NO CONECTA, SI HAY ERROR DE CONEXIÓN O CONSULTA
    mensaje_error : ""

    SI TODO VA BIEN
    "usuario" : [ , , , ...]

    SI EL LOGIN ES INCORRECTO
    "mensaje" : "Usuario no se encuentra en la BD"

    El servicio se llamará login
    <form method="post" action="index.php">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" id="usuario" name="usuario"
                value="<?php if (isset($_POST["usuario"]))
                    echo $_POST["usuario"] ?>">
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" id="clave" name="clave">
        </p>
        <p>
            <button type="submit" name="btnLoguear">Iniciar sesión</button>
        </p>
        </form>
    </body>

    </html>