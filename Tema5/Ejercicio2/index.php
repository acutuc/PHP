<?php
session_name("Ejercicio2_SW");
session_start();
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

function error_page($titulo, $cabecera, $cuerpo)
{
    return
    '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $titulo . '</title>
    </head>
    <body>
        <h1>' . $cabecera . '</h1>
        ' . $cuerpo . '</p>
    </body>
    </html>';
}

define("DIR_SERV", "http://localhost/PHP/Tema5/Ejercicio1/servicios_rest");

//Si pulsamos el botón Continuar en el borrado:
if (isset($_POST["btnContBorrar"])) {
    //Llamamos al servicio:
    $url = DIR_SERV . "/producto/borrar" . urlencode($_POST["btnContBorrar"]);
    //Ponemos el método "DELETE"
    $respuesta = consumir_servicios_rest($url, "DELETE");
    $obj = json_decode($respuesta);

    if (!$obj) {
        die(error_page("CRUD - Servicios Web", "Listado de los productos", "Error consumiendo el servicio rest: " . $url . "</p>" . $respuesta));
    }

    if (isset($obj->mensaje_error)) {
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    }

    //ABRIMOS SESIONES ARRIBA DEL TODO.
    $_SESSION["accion"] = "El producto se ha borrado con éxito";
    header("Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table,
        th,
        td {
            border: 1px solid black
        }

        th {
            background-color: lightgrey
        }

        table {
            border-collapse: collapse
        }

        .centrado {
            text-align: center;
        }

        .centro {
            width: 80%;
            margin: 10px auto
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }
        .mensaje{
            color:blue;
            font-size: 1.25em;
        }
    </style>
    <title>CRUD - Servicios Web</title>
</head>

<body>
    <h1 class="centrado">Listado de los productos</h1>
    <?php
    if (isset($_POST["btnProducto"])) {
        echo "<div class='centro'>";

        echo "<h2>Información del producto: " . $_POST["btnProducto"] . "</h2>";

        $url = DIR_SERV . "/producto/" . urlencode($_POST["btnProducto"]);
        $respuesta = consumir_servicios_rest($url, "GET");
        $obj = json_decode($respuesta);

        if (!$obj) {
            die("<p>Error consumiendo el servicio rest: " . $url . "</p>" . $respuesta . "</body></html>");
        }

        if (isset($obj->mensaje_error)) {
            die("<p>" . $obj->mensaje_error . "</p></body></html>");
        }

        //Si el producto ya se ha borrado de la BD:
        if (!$obj->producto) {
            echo "<p>El producto ya no se encuentra en la BD</p>";
        } else {
            //CONSULTAMOS CON UN NUEVO SERVICIO PARA SACAR EL CÓDIGO DE FAMILIA:
            $url = DIR_SERV . "/familia/" . urlencode($obj->producto->familia);
            $respuesta = consumir_servicios_rest($url, "GET");
            $obj2 = json_decode($respuesta);

            if (!$obj2) {
                die("<p>Error consumiendo el servicio rest: " . $url . "</p>" . $respuesta . "</body></html>");
            }

            if (isset($obj2->mensaje_error)) {
                die("<p>" . $obj->mensaje_error . "</p></body></html>");
            }

            if (!$obj2->familia) {
                $familia = $obj->producto->familia;
            } else {
                $familia = $obj2->familia->nombre;
            }

            echo "<p>El producto ya no se encuentra en la BD</p>";

            echo "<p>";
            echo "<strong>Nombre: </strong>" . $obj->producto->nombre . "<br>";
            echo "<strong>Nombre corto: </strong>" . $obj->producto->nombre_corto . "<br>";
            echo "<strong>Descripción: </strong>" . $obj->producto->descripcion . "<br>";
            echo "<strong>PVP: </strong>" . $obj->producto->PVP . "€<br>";
            echo "<strong>Familia: </strong>" . $familia;
            echo "</p>";
        }

        echo "<form action='index.php' method='post'>";
        echo "<button>Volver</button>";
        echo "</form>";

        echo "</div>";
    }

    //Si hemos pulsado el botón Borrar:
    if (isset($_POST["btnBorrar"])) {
        echo "<div class='centro centrado'>";
        echo "<p>Se dispone usted a borrar el producto: " . $_POST["btnBorrar"] . "</p>";

        echo "<form class='centrado' action='index.php' method='post'>";
        echo "<p>¿Estás seguro?</p>";
        echo "<button name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Continuar</button>";
        echo " <button>Cancelar</button>";
        echo "</form>";
        echo "</div>";
    }

    //Si hemos pulsado el botón de nuevo producto:
    if(isset($_POST["btnNuevo"])){
        echo "Formulario para insertar nuevo Producto:";
    }





    $url = DIR_SERV . "/productos";
    $respuesta = consumir_servicios_rest($url, "GET");
    $obj = json_decode($respuesta);

    if (!$obj) {
        die("<p>Error consumiendo el servicio rest: " . $url . "</p>" . $respuesta . "</body></html>");
    }

    if (isset($obj->mensaje_error)) {
        die("<p>" . $obj->mensaje_error . "</p></body></html>");
    }

    echo "<table class='centro centrado'>";

    echo "<tr><th>COD</th><th>Nombre</th><th>PVP</th><th><form action='index.php' method='post'><button class='enlace' name='btnNuevo'>Producto +</button></form></th></tr>";

    foreach ($obj->productos as $tupla) {
        echo "<tr>
        <td><form action='index.php' method='post'><button name='btnProducto' value='" . $tupla->cod . "' class='enlace'>" . $tupla->cod . "</button></form></td>
        <td>" . $tupla->nombre_corto . "</td>
        <td>" . $tupla->PVP . "</td>
        <td><form action='index.php' method='post'><button class='enlace' name='btnBorrar' value='" . $tupla->cod . "'>Borrar</button> - <button class='enlace' name='btnEditar' value='" . $tupla->cod . "'>Editar</button></form></td>
        </tr>";
    }

    echo "</table>";

    //Si existe $_SESSION["accion"] es que se ha creado y hemos borrado el producto:
    if(isset($_SESSION["accion"])){
        echo "<p class='mensaje centro centrado'>".$_SESSION["accion"]."</p>";
        //Limpiamos la variable:
        unset($_SESSION["accion"]);
    }
    ?>
</body>

</html>