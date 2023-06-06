<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        #tabla_equipos {
            border-collapse: collapse;
            width: 90%;
            margin: 0 auto;
            text-align: center
        }

        #tabla_equipos,
        #tabla_equipos td,
        #tabla_equipos th {
            border: 1px solid black
        }

        #tabla_equipos th {
            background-color: #CCC
        }

        #tabla_prof {
            border-collapse: collapse
        }

        #tabla_prof,
        #tabla_prof td,
        #tabla_prof th {
            border: 1px solid black
        }

        #tabla_prof th {
            background-color: #CCC
        }
    </style>
    <title>Gestión de Guardias</title>
</head>

<body>
    <h1>Gestión de Guardias</h1>
    <p>
        Bienvenido <strong>
            <?php echo $datos_usu_log->usuario ?>
        </strong>
    <form method="post" action="index.php" class='enlinea'><button name="btnSalir" class='enlace'>Salir</button></form>
    </p>

    <?php

    $dias_semana[0]="";
    $dias_semana[1]="Lunes";
    $dias_semana[2]="Martes";
    $dias_semana[3]="Miércoles";
    $dias_semana[4]="Jueves";
    $dias_semana[5]="Viernes";

    echo "<h2>Equipos de Guardias del IES Mar de Alborán</h2>";
    echo "<table id='tabla_equipos'>";
    echo "<tr>";
    for($i=0;$i<=5;$i++)
        echo "<th>".$dias_semana[$i]."</th>";
   
    echo "</tr>";
    $cont=1;
    for($horas=1; $horas<=7; $horas++)
    {
        echo "<tr>";
            
            if($horas==4)
            {
                echo "<td colspan='6'>RECREO</td>";
            }
            else
            {
                if($horas<=3)
                    echo "<td>".$horas."º Hora"."</td>";
                else
                    echo "<td>".($horas-1)."º Hora"."</td>";
                for($dias=1;$dias<=5;$dias++)
                {
                    echo "<td>";
                    echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='dia' value='".$dias."'/>";
                    echo "<input type='hidden' name='hora' value='".$horas."'/>";
                    echo "<input type='hidden' name='equipo' value='".$cont."'/>";
                    echo "<button class='enlace' name='btnVerEquipo'>Equipo ".$cont."</button>";
                    echo "</form>";
                    echo "</td>";
                    $cont++;
                }
            }
            
        echo "</tr>";
    }

    echo "</table>";
    ?>
</body>

</html>