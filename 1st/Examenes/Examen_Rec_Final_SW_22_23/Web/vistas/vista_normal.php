<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table{
            border-collapse:collapse;
            width: 80vw;
            margin:0 auto;
        }
        th{
            background-color:grey;
        }
        th, td{
            text-align: center;
            border:1px solid black;
        }
    </style>
    <title>Examen Final PHP</title>
</head>
<body>
    <h1>Exámen Final PHP</h1>
    <p>
        Bienvenido <strong><?php echo $datos_usuario_log->usuario ?></strong>
        <form method="post" action="index.php">
            <button name="btnSalir">Salir</button>
        </form>
    </p>
        <?php
        $url = DIR_SERV."/obtenerHorarios/".$datos_usuario_log->id_usuario;
        $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
        $obj = json_decode($respuesta);

        if(!$obj){
            consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
            session_destroy();
            die(error_page("Examen Final PHP", $url.$respuesta));
        }

        if(isset($obj->error)){
            consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
            session_destroy();
            die(error_page("Examen Final PHP",$obj->error));
        }

        if(isset($obj->no_login)){
            consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
            session_unset();
            $_SESSION["seguridad"] = $obj->no_login;
            header("Location:index.php");
            exit();
        }

        foreach($obj->horarios as $tupla){
            if(isset($horarios[$tupla->dia][$tupla->hora])){
                $horarios[$tupla->dia][$tupla->hora].= "/".$tupla->nombre;
            }else{
                $horarios[$tupla->dia][$tupla->hora] = $tupla->nombre;
            }            
        }

        $dias_semana[] = "";
        $dias_semana[] = "Lunes";
        $dias_semana[] = "Martes";
        $dias_semana[] = "Miércoles";
        $dias_semana[] = "Jueves";
        $dias_semana[] = "Viernes";

        $horas[] = "";
        $horas[] = "8:15 - 9:15";
        $horas[] = "9:15 - 10:15";
        $horas[] = "10:15 - 11:15";
        $horas[] = "11:15 - 11:45";
        $horas[] = "11:45 - 12:45";
        $horas[] = "12:45 - 13:45";
        $horas[] = "13:45 - 14:45";

        echo "<table>";

        echo "<tr>";

        for($i = 0; $i < count($dias_semana); $i++){
            echo "<th>".$dias_semana[$i]."</th>";
        }

        echo "</tr>";

        for($hora = 1; $hora <=7; $hora++){

            if($hora == 4){
                echo "<tr><td colspan='6'>RECREO</td></tr>";
            }else

            echo "<tr>";

            echo "<td>".$horas[$hora]."</td>";

            for($dia = 1; $dia <= 5; $dia++){
                if(isset($horarios[$dia][$hora])){
                    echo "<td>".$horarios[$dia][$hora]."</td>";
                }else{
                    echo "<td></td>";
                }
            }

            echo "</tr>";
        }

        echo "</table>";
        ?>
    
</body>
</html>