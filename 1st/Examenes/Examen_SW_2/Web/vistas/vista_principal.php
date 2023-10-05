<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>horarios</title>
    <style>
        table {

            text-align: center;
            margin: 0 auto;
            width: 80%;
            border-collapse: collapse;
        }

        table,
        th,
        td {

            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1>Vista principal</h1>
    <p>Bienvenido <?php echo $_SESSION["usuario"] ?></p>
    <form action="index.php" method="post">
        <button name="btnCerrarSesion">Salir</button>
    </form>
    <h2>Horario de los Profesores</h2>
    <?php
    $url = DIR_SERV . "/usuarios";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);

    if (!$obj) {

        session_destroy();
        die("<p>Error al consumir el servicio " . $url . "</p>" . $respuesta);
    }

    if (isset($obj->error)) {

        session_destroy();
        die("<p>" . $obj->error . "</p></body></html>");
    }

    ?>
    <p>Seleccione el Profesor: </p>
    <form action="index.php" method="post">
        <select name="profesores">
            <?php
            foreach ($obj->usuarios as $datos) {

                if (isset($_POST["profesores"]) && $_POST["profesores"] == $datos->id_usuario . "-" . $datos->nombre) {

                    echo "<option selected value='" . $datos->id_usuario . "-" . $datos->nombre . "'>" . $datos->nombre . "</option>";
                } else {

                    echo "<option value='" . $datos->id_usuario . "-" . $datos->nombre . "'>" . $datos->nombre . "</option>";
                }
            }
            ?>
        </select>
        <button name="btnProfesor">Ver Horario</button>
    </form>

    <?php
    if (isset($_POST["btnProfesor"]) || isset($_POST["btnEditar"])) {

            $valores_select = explode("-", $_POST["profesores"]);
            $id_usuario = $valores_select[0];
            $nombre_usuario = $valores_select[1];
        

        if (isset($_POST["btnProfesor"])) {

            $url = DIR_SERV . "/horario/" . urlencode($id_usuario);
        } else {

            $url = DIR_SERV . "/horario/" . urlencode($_POST["id_usuario"]);
        }
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);

        if (!$obj) {

            session_destroy();
            die("<p>Error al consumir el servicio " . $url . "</p>" . $respuesta);
        }

        if (isset($obj->error)) {

            session_destroy();
            die("<p>" . $obj->error . "</p></body></html>");
        }

        if (isset($obj->horario)) {

            foreach ($obj->horario as $datos) {

                if (isset($horarios[$datos->hora][$datos->dia])) {

                    $horarios[$datos->hora][$datos->dia] .= "/" . $datos->nombre_grupo;
                } else {

                    $horarios[$datos->hora][$datos->dia] = $datos->nombre_grupo;
                }
            }
        }

        if (isset($_POST["btnProfesor"])) {

            echo "<h3>Horario del Profesor: " . $nombre_usuario . "</h3>";
        } else {

            echo "<h3>Horario del Profesor: " . $_POST["nombre_usuario"] . "</h3>";
        }

        $horas = ["", "1hora", "2hora", "3hora", "4hora", "5hora", "6hora"];
        $semana = ["", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes"];

        echo "<table>";
        echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th></tr>";

        for ($i = 1; $i <= 7; $i++) {

            echo "<tr>";

            if ($i == 4) {

                echo "<tr><td colspan='6'>RECREO</td></tr>";
            } else {

                if ($i < 4) {

                    echo "<td>" . $horas[$i] . "</td>";
                } else {

                    echo "<td>" . $horas[$i - 1] . "</td>";
                }

                for ($j = 1; $j <= 5; $j++) {

                    echo "<td>";

                    if (isset($horarios[$i][$j])) {

                        echo $horarios[$i][$j];
                    }
                    echo "<form action='index.php' method='post'>
                        <input type='hidden' name='hora' value='" . $i . "' />
                        <input type='hidden' name='dia' value='" . $j . "' />
                        <input type='hidden' name='id_usuario' value='" . $id_usuario . "' />
                        <input type='hidden' name='nombre_usuario' value='" . $nombre_usuario . "' />
                        <input type='hidden' name='profesores' value='" . $_POST["profesores"] . "' />
                        <button name='btnEditar' >Editar</button>
                        </form>";

                    echo "</td>";
                }
            }

            echo "</tr>";
        }

        echo "</table>";

        if (isset($_POST["btnEditar"])) {

            $url = DIR_SERV."/grupos/".urlencode($_POST["dia"])."/".urlencode($_POST["hora"])."/".urlencode($_POST["id_usuario"]);
            $respuesta = consumir_servicios_REST($url, "GET");
            $obj = json_decode($respuesta);

            if (!$obj) {

                session_destroy();
                die("<p>Error al consumir el servicio " . $url . "</p>" . $respuesta);
            }
        
            if (isset($obj->error)) {
        
                session_destroy();
                die("<p>" . $obj->error . "</p></body></html>");
            }

            if(isset($obj->grupos)){

                foreach($obj->grupos as $datos){

                    $grupos[] = $datos;
                }

                //echo var_dump($grupos);
            }

            echo "<h3>Editando la " . $_POST["hora"] . "ª hora del " . $semana[$_POST["dia"]] . "</h3>";
            echo "<table>";

            echo "<tr><td>Grupo</td><td>Acción</td></tr>";

            for($i = 0; $i < count($grupos); $i++){

                echo "<tr><td>".$grupos[$i]->nombre."</td><td><form action='index.php' method='post'><button name='btnQuitar'>Quitar</button></form></td></tr>";
            }

            echo "</table>";

            $url = DIR_SERV."/gruposLibres/".urlencode($_POST["dia"])."/".urlencode($_POST["hora"])."/".urlencode($_POST["id_usuario"]);
            $respuesta = consumir_servicios_REST($url, "GET");
            $obj = json_decode($respuesta);

            if (!$obj) {

                session_destroy();
                die("<p>Error al consumir el servicio " . $url . "</p>" . $respuesta);
            }
        
            if (isset($obj->error)) {
        
                session_destroy();
                die("<p>" . $obj->error . "</p></body></html>");
            }

            echo "<select name='aulas_libres'>";
            if(isset($obj->grupos_libres)){

                foreach($obj->grupos_libres as $datos){

                    echo "<option value='".$datos->id_grupo."' >$datos->nombre</option>";
                }
            }
            echo "</select>";
            echo "<form action='index.php' method='post'>
            <button name='btnAdd' >Add</button>
            </form>";
        }
    }
    ?>
</body>

</html>