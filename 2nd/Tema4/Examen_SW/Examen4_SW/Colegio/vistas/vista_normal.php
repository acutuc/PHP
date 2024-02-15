<?php
    $url = DIR_SERV."/notasAlumno/".$datos_usuario_log->cod_usu;
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);

    if(!$obj)
{
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos);
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
}
if(isset($obj->error))
{
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos);
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj->error."</p>"));
}
if(isset($obj->no_auth))
{
    consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos);
    session_unset();
    $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
    header("Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 DWESE Curso 23-24</title>
    <style>
        .enlace{
            background:none;
            border:none;
            color:blue;
            text-decoration: underline;
            cursor: pointer;
        }
        table{
            border-collapse:collapse;
        }
        th, td{
            border:1px solid black;
        }
        th{
            background-color: lightgrey;
        }
    </style>
</head>
<body>
    <h1>Notas de los alumnos</h1>
    <form method="post" action="index.php">
        Bienvenido <strong><?php echo $datos_usuario_log->usuario ?></strong>
        <button name="btnSalir" class='enlace'>Salir</button>
    </form>
    <?php
    echo "<h2>Notas del alumno ".$datos_usuario_log->nombre."</h2>";
    echo "<table>";
    
    echo "<tr><th>Asignatura</th><th>Nota</th></tr>";
    foreach($obj->notas as $tupla){
        echo "<tr>";

        echo "<td>".$tupla->denominacion."</td>";
        echo "<td>".$tupla->nota."</td>";

        echo "</tr>";
    }

    echo "</table>";
    ?>
</body>
</html>