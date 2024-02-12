<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Final PHP</title>
    <style>
        #centrar{
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Examen Final PHP</h1>
    <form method="post" action="index.php">
        Bienvenido <strong><?php echo $datos_usu_log->usuario ?></strong> - <button name="btnSalir">Salir</button>
    </form>
    <h2>Su horario</h2>
    <?php
    echo "<h3 id='centrar'>Horario del Profesor: <em>".$datos_usu_log->nombre."</em></h3>";
    $url = DIR_SERV."/obtenerHorario";
    $respuesta = consumir_servicios_REST($url, "")
    ?>
</body>
</html>