<?php
if (isset($_POST["btnContBorrar"])) {
    $url = DIR_SERV . "/borrarComentario/" . $_POST["btnContBorrar"];
    $respuesta = consumir_servicios_REST($url, "DELETE", $_SESSION["api_session"]);
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die(error_page("Blog - Exam", "Blog - Exam", "Error consumiendo el servicio: " . $url));
    }
    if (isset($obj->mensaje_error)) {
        session_destroy();
        die(error_page("Blog - Exam", "Blog - Exam", $obj->mensaje_error));
    }

    if (isset($obj->no_login)) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:../index.php");
        exit;
    }

    $_SESSION["accion"] = "Comentario borrado con éxito";
    header("Location:gest_comentarios.php");
    exit;

}

if (isset($_POST["btnContAprobar"])) {
    $url = DIR_SERV . "/actualizarComentario/" . $_POST["btnContAprobar"];
    $datos_act["estado"] = "apto";
    $datos_act["api_session"] = $_SESSION["api_session"]["api_session"];
    $respuesta = consumir_servicios_REST($url, "PUT", $datos_act);
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die(error_page("Blog - Exam", "Blog - Exam", "Error consumiendo el servicio: " . $url));
    }
    if (isset($obj->mensaje_error)) {
        session_destroy();
        die(error_page("Blog - Exam", "Blog - Exam", $obj->mensaje_error));
    }

    if (isset($obj->no_login)) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:../index.php");
        exit;
    }

    $_SESSION["accion"] = "Comentario aprobado con éxito";
    header("Location:gest_comentarios.php");
    exit;

}

//Controlamos los errores al insertar un comentario en una noticia.
if (isset($_POST["btnCrearComentario"])) {
    $error_formulario = $_POST["comentario"] == "";

    //Si no hay error:
    if (!$error_formulario) {
        //Llamamos al servicio y saltamos:
        $url = DIR_SERV . "/insertarComentario/" . $_POST["btnCrearComentario"];
        $datos_env["comentario"] = $_POST["comentario"];
        $datos_env["idUsuario"] = $datos_usu_log->idusuario;
        $datos_env["api_session"] = $_SESSION["api_session"]["api_session"];
        $respuesta = consumir_servicios_REST($url, "POST", $datos_env);
        $obj = json_decode($respuesta);
        if (!$obj) {
            session_destroy();
            die("<p>Error consumiendo el servicio: " . $url . "</p></body></html>");
        }
        if (isset($obj->mensaje_error)) {
            session_destroy();
            die("<p>" . $obj->mensaje_error . "</p></body></html>");
        }

        if (isset($obj->no_login)) {
            session_destroy();
            die("<p>El tiempo de sesión de la API ha expirado. Vuelva a <a href='index.php'>loguearse</a>.</p></body></html>");

        }

        $_SESSION["comentario"] = $_POST["btnCrearComentario"];
        header("Location:gest_comentarios.php");
        exit();

    }
}

?>
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

        #tabla_comentarios,
        #tabla_comentarios td,
        #tabla_comentarios th {
            border: 1px solid black
        }

        #tabla_comentarios {
            width: 90%;
            border-collapse: collapse;
            text-align: center;
            margin: 0 auto
        }

        #tabla_comentarios th {
            background-color: #CCC
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

    <?php
    if (isset($_POST["btnVerNoticia"]) || isset($_POST["btnCrearComentario"]) || isset($_SESSION["comentario"])) {

        if (isset($_POST["btnVerNoticia"])) {
            $id_noticia = $_POST["btnVerNoticia"];
        } elseif (isset($_POST["btnCrearComentario"])) {
            $id_noticia = $_POST["btnCrearComentario"];
        } else {
            $id_noticia = $_SESSION["comentario"];
        }

        $url = DIR_SERV . "/noticia/" . $id_noticia;
        $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
        $obj = json_decode($respuesta);
        if (!$obj) {
            session_destroy();
            die("<p>Error consumiendo el servicio: " . $url . "</p></body></html>");
        }
        if (isset($obj->mensaje_error)) {
            session_destroy();
            die("<p>" . $obj->mensaje_error . "</p></body></html>");
        }

        if (isset($obj->no_login)) {
            session_destroy();
            die("<p>El tiempo de sesión de la API ha expirado. Vuelva a <a href='index.php'>loguearse</a>.</p></body></html>");

        }

        if (isset($obj->mensaje)) {
            //mensaje de que la Noticia ya no se encuentra en la BD y botón volver
            echo "<form action='gest_comentarios.php' method='post'>";
            echo "<p>La noticia ya no se encuentra registrada en la BD</p>";
            echo "<p><button>Volver</button></p>";
            echo "</form>";
        } else {
            echo "<h2>" . $obj->noticia->titulo . "</h2>";
            echo "<p>Publicado por <strong>" . $obj->noticia->usuario . "</strong> en <em>" . $obj->noticia->valor . "</em></p>";
            echo "<p>" . $obj->noticia->cuerpo . "</p>";

            echo "<h2>Comentarios</h2>";
            $url = DIR_SERV . "/comentarios/" . $id_noticia;
            $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
            $obj = json_decode($respuesta);
            if (!$obj) {
                session_destroy();
                die("<p>Error consumiendo el servicio: " . $url . "</p></body></html>");
            }
            if (isset($obj->mensaje_error)) {
                session_destroy();
                die("<p>" . $obj->mensaje_error . "</p></body></html>");
            }

            if (isset($obj->no_login)) {
                session_destroy();
                die("<p>El tiempo de sesión de la API ha expirado. Vuelva a <a href='index.php'>loguearse</a>.</p></body></html>");

            }

            foreach ($obj->comentarios as $tupla) {
                echo "<p><strong>" . $tupla->usuario . "</strong> dijo:<br/>" . $tupla->comentario . "</p>";
            }

            //Aquí iría el formulario para insertar el comentario
            echo "<form method='post' action='gest_comentarios.php'>";
            echo "<p>";
            echo "<label for='comentario'>Dejar un comentario:</label><br/>";
            echo "<textarea id='comentario' name='comentario' cols='50' rows='5'></textarea><br/>";
            if (isset($_POST["btnCrearComentario"]) && $error_formulario) {
                echo "<span class='error'>* Campo vacío *</span>";
            }
            echo "</p>";
            //echo "<input type='hidden' name='idNoticia' value='" . $_POST["btnVerNoticia"] . "'/>";
            //echo "<input type='hidden' name='idUsuario' value='" . $datos_usu_log->idusuario . "'/>";
            echo "<button>Volver</button> <button name='btnCrearComentario' value='" . $id_noticia . "'>Enviar</button>";
            echo "</form>";

            if (isset($_SESSION["comentario"])) {
                echo "<p class='mensaje'>El comentario se ha publicado con éxito</p>";
                unset($_SESSION["comentario"]);
            }
        }


    } else {
        if (isset($_POST["btnBorrar"])) {
            echo "<h2>Borrado de un comentario</h2>";
            echo "<form action='gest_comentarios.php' method='post'>";
            echo "<p>¿Está usted seguro que quieres borrar el comentario con Id=" . $_POST["btnBorrar"] . "?</p>";
            echo "<p><button>Cancelar</button> <button name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Continuar</button></p>";
            echo "</form>";

        }

        if (isset($_POST["btnAprobar"])) {
            echo "<h2>Aprobado de un comentario</h2>";
            echo "<form action='gest_comentarios.php' method='post'>";
            echo "<p>¿Está usted seguro que quieres aprobar el comentario con Id=" . $_POST["btnAprobar"] . "?</p>";
            echo "<p><button>Cancelar</button> <button name='btnContAprobar' value='" . $_POST["btnAprobar"] . "'>Continuar</button></p>";
            echo "</form>";
        }

        require "../vistas/vista_tabla_comentarios.php";

        if (isset($_SESSION["accion"])) {
            echo "<p class='mensaje'>" . $_SESSION["accion"] . "</p>";
            unset($_SESSION["accion"]);
        }
    }

    ?>

</body>

</html>