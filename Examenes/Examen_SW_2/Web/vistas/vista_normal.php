<?php

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vista_normal</title>
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
    <h1>Vista normal</h1>
    <p>Bienvenido <?php echo $_SESSION["usuario"] ?></p>
    <form action="index.php" method="post">
        <button name="btnCerrarSesion">Salir</button>
    </form>
    <h2>Horario del profesor <?php echo $datos_usuario_logueado->nombre ?></h2>
    <?php
    $url = DIR_SERV . "/horario/" . urlencode($datos_usuario_logueado->id_usuario);
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

        //echo var_dump($obj->horario);

        foreach($obj->horario as $datos){

            if(isset($horarios[$datos->hora][$datos->dia])){

                $horarios[$datos->hora][$datos->dia] .="/".$datos->nombre_grupo;
            }else{

                $horarios[$datos->hora][$datos->dia] = $datos->nombre_grupo;
            }
        }

        //echo var_dump($horarios);
    }

    $horas = ["", "1hora", "2hora", "3hora", "4hora", "5hora", "6hora"];

    echo "<table>";
    echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th></tr>";

    for ($i = 1; $i <= 7; $i++) {

        echo "<tr>";

        if ($i == 4) {

            echo "<td></td><td colspan='5'>RECREO</td>";
        } else {

            if($i < 4){

                echo "<td>".$horas[$i]."</td>";
            }else{

                echo "<td>".$horas[$i-1]."</td>";
            }

            for ($j = 1; $j <= 5; $j++) {

                    echo "<td>";
                    if(isset($horarios[$i][$j])){

                        echo $horarios[$i][$j];
                    }
                    echo "</td>";
                }
            }
        }

        echo "</tr>";

    echo "</table>";
    ?>
</body>

</html>