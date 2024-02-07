<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería</title>
    <style>
        .enlinea {
            display: inline;
        }

        .enlace {
            color: blue;
            text-decoration: underline;
            background: none;
            border: none;
            cursor: pointer;
        }

        #libros {
            display: flex;
            justify-content: space-between;
            flex-flow: wrap;
            width: 90%;
        }

        #libros div {
            flex: 33% 0;
            text-align: center;
        }

        #libros div img {
            width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <h1>Librería - Vista normal</h1>
    <div>Bienvenido <strong><?php echo $datos_usu_log->lector ?></strong>
        <form class='enlinea' action="../index.php" method="post">
            <button class='enlace' name="btnSalir">Salir</button>
        </form>
        <h2>Listado de los libros</h2>
        <?php
        $url = DIR_SERV . "/obtenerLibros";
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die("<p>Error consumiendo el servicio: " . $url . "</p></body></html>");
        }

        if (isset($obj->error)) {
            session_destroy();
            die("<p>" . $obj->error . "</p></body></html>");
        }

        echo "<div id='libros'>";

        foreach ($obj->libros as $tupla) {
            echo "<div>";
            echo "<img src='images/" . $tupla->portada . "' alt='" . $tupla->titulo . "' title='" . $tupla->titulo . "'/><br>" . $tupla->titulo . " - " . $tupla->precio . "€";
            echo "</div>";
        }

        echo "</div>";


        ?>
    </div>
</body>

</html>