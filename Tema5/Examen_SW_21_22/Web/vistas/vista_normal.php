<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 PHP</title>
    <style>
        .enlace{border:none;background:none;text-decoration:underline;color:blue;cursor:pointer}
        .enlinea{display:inline}
    </style>
</head>
<body>
    <h1>Examen4 PHP</h1>
    <div>
        Bienvenido <strong><?php echo $_SESSION["usuario"];?></strong> - <form class="enlinea" method="post" action="index.php"><button class="enlace" name="btnCerrarSesion">Salir</button></form>
    </div>
    <h2>Su horario</h2>
    <?php
    $url = "/horario/".$datos_usuario_log->id_usuario;
    $respuesta = consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
    $obj = json_decode($respuesta);
    if(!$obj){
        session_destroy();
        die(error_page("", ""));
    }
    echo "<h3>Horario del profesor: ".$datos_usuario_log->nombre."</h3>";


    ?>
</body>
</html>