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
    <title>Exámen Final PHP</title>
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
        $dias_semana[] = "";
        $dias_semana[] = "Lunes";
        $dias_semana[] = "Martes";
        $dias_semana[] = "Miércoles";
        $dias_semana[] = "Jueves";
        $dias_semana[] = "Viernes";

        echo "<h2>Hoy es ".$dias_semana[date("w")]."</h2>";

        $url = DIR_SERV."/obtenerHorariosDia/".date("w");
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
            die(error_page("Examen Final PHP", $obj->error));
        }

        if(isset($obj->no_login)){
            consumir_servicios_REST(DIR_SERV."/salir", "POST", $_SESSION["api_session"]);
            session_unset();
            $_SESSION["seguridad"] = $obj->no_login;
            header("Location:index.php");
            exit();
        }


        $horas[] = "";
        $horas[] = "8:15 - 9:15";
        $horas[] = "9:15 - 10:15";
        $horas[] = "10:15 - 11:15";
        $horas[] = "11:15 - 11:45";
        $horas[] = "11:45 - 12:45";
        $horas[] = "12:45 - 13:45";
        $horas[] = "13:45 - 14:45";

        /*foreach($obj->horario as $tupla){
            $profesor[$tupla->dia][$tupla->hora] = $tupla->nombre;
            echo $profesor[$tupla->dia][$tupla->hora];
        }*/

        echo "<table>";

        echo "<tr>";
        if(isset($_SESSION["profesor"])){
            echo "<th>Hora</th><th>Profesor de Guardia</th><th>Información del Profesor con ID: ".$_SESSION["profesor"]."</th>";
        }else{
            echo "<th>Hora</th><th>Profesor de Guardia</th><th>Información del Profesor con ID: </th>";
        }
        
        for($hora = 1; $hora <=7; $hora++){
            if($hora !== 4){
                echo "<tr>";
                echo "<td>".$horas[$hora]."</td>";
                echo "<td>";
                echo "<ol>";
                foreach($obj->horario as $tupla){
                    echo "<li>".$tupla->nombre."</li>";                    
                }
                echo "</ol>";
                echo "</td>";
                echo "</tr>";
            }
        }

        echo "</tr>";

        echo "</table>";
    ?>
</body>
</html>