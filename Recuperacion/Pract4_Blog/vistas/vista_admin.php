<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Exam</title>
    <style>
        .enlinea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        .enlace:hover {
            text-decoration: none
        }

        .enlace:active {
            color: red
        }

        .enlace:visited {
            color: purple
        }
        table{
            border-collapse: collapse;
            width: 100%;
            }
        th {
            text-align: center;
            background-color: #e3e3e3;
            border: 1px solid black;
            padding: 5px;
            }
        td{
            text-align: center;

        }
    </style>
</head>

<body>
    <h1>Blog - Exam</h1>
    <div>
        Bienvenido <strong>
            <?php echo $datos_usu_log->usuario; ?>
        </strong> -
        <form class="enlinea" action="gest_comentarios.php" method="post">
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div>
    <h3>Todos los comentarios</h3>

    <?php
    $url = DIR_SERV . "/comentarios";
    $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die(error_page("Blog - Exam", "Blog - Exam", "Error consumiendo el servicio: " . $url . $respuesta));
    }

    if (isset($obj->mensaje_error)) {
        session_destroy();
        die(error_page("Blog - Exam", "Blog - Exam", $obj->mensaje_error));
    }
    echo "<form method='post' action='gest_comentarios.php'>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Comentarios</th><th>Opción</th></tr>";
    foreach ($obj->comentario as $comentario) {
        echo "<tr>";
        echo "<td>" . $comentario->idComentario . "</td>";
        echo "<td>" . $comentario->comentario . "</br>Dijo " . $comentario->idUsuario . " en <button name='btnNoticia' value=" . $comentario->idNoticia . " class='enlace'>" . $comentario->idNoticia . "</button></td>";
        echo "<td><button name='btnAprobar' class='enlace'>Aprobar</button> - <button name='btnBorrar' class='enlace'>Borrar</button></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</form>";
    ?>
</body>

</html>