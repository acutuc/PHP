<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SW</title>
    <style>
        .enlinea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }
        table, th, td{
            border:1px solid black;
            border-collapse:collapse;
        }
        th, td{
            padding:1em;
        }
    </style>
</head>

<body>
    <h1>Login SW</h1>
    <div>Bienvenido <strong>
            <?php echo $datos_usuario_log->usuario; ?>
        </strong> -
        <form class="enlinea" method="post" action="index.php">
            <button name="btnSalir" class="enlace">Salir</button>
        </form>
    </div>
    <h2>Listado de los usuarios (no admin)</h2>
    <?php
    $key["api_session"] = $_SESSION["api_session"];
    $url = DIR_SERV . "/usuarios";
    $respuesta = consumir_servicios_REST($url, "GET", $key);
    $obj = json_decode($respuesta);

    if (!$obj) {
        $url = DIR_SERV . "/salir";
        $respuesta = consumir_servicios_REST($url, "POST", $datos_salir);
        session_destroy();
        die(error_page("Login SW", "Login SW", "<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta));
    }


    if (isset($obj->error)) {
        $url = DIR_SERV . "/salir";
        $respuesta = consumir_servicios_REST($url, "POST", $datos_salir);
        session_destroy();
        die(error_page("Login SW", "Login SW", "<p>" . $obj->error . "</p>"));
    }

    if (isset($obj->no_login)) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado.";
        header("Location:index.php");
        exit;
    }

    echo "<table>";
    echo "<tr>
        <th>ID</th>
        <th>Nombre</th>
    </tr>";
    foreach($obj->usuarios as $tupla){
        if($tupla->tipo == "normal"){
            echo "<tr>
            <td>".$tupla->id_usuario."</td>
            <td>".$tupla->nombre."</td>
            </tr>";
        }
    }
    ?>
</body>

</html>