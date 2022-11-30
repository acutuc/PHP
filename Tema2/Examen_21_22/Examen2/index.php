<?php

function error_page($title, $body)
{
    $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>' . $title . '</title></head>';
    $html .= '<body>' . $body . '</body></html>';
    return $html;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP</title>
</head>

<body>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los Profesores</h2>
    <?php
    //1. CONECTAMOS CON LA BD.
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_horarios_exam");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>Imposible conectar a la base de datos. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error() . "</p></body></html>");
    }

    //2. HACEMOS LA CONSULTA
    try {
        $consulta = "SELECT id_usuario, nombre FROM usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        $mensaje = "<p>No se ha podido realiza la conexión. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion) . "</p>";
        mysqli_close($conexion);
        die($mensaje);
    }
    ?>
    <form action="index.php" method="post">
        <p>
            <label for="profesor">Horario del profesor: </label>
            <select name="profesor" id="profesor">
                <?php
                while($tupla = mysqli_fetch_assoc($resultado)){
                    echo "<option value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</option>";
                }
                //IMPORTANTE FREE RESULT Y CERRAR CONEXION.
                mysqli_free_result($resultado);
                mysqli_close($conexion);
                ?>
            </select>
            <button type="submit" name="btnVerHorario">Ver Horario</button>
        </p>
    </form>
</body>

</html>