<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría de Fechas</title>
</head>
<body>
    <h1>Teoría de Fechas</h1>
    <?php
        $tiempo = time(); //Devuelve los segundos desde el 1/1/70 hasta hoy.
        echo "<p><strong>Tiempo en segundos desde 1970: </strong>".$tiempo."</p>";

        //Puede tener dos parámetros, el segundo es time(), se le puede cambiar manualmente los segundos.
        $fecha = date("d-m-Y h:i:s"); //Día, mes y año, hora, minutos y segundos. con H mayúscula nos da formato 24h.
                                    // la Y mayúscula nos da yyyy, la y minúscula nos da yy.
        echo "<p><strong>Fecha y hora actual: </strong>".$fecha."</p>";

        //El tiempo que ha pasado desde 1/1/70 hasta el que se le pasa por parámetro:
        //mktime(horas, minutos, segundos, mes, día, año)
        $cumpleanios = mktime(0, 0, 0, 10, 7, 1994);
        echo "<p><strong>Segundos desde 1970 hasta el día de mi nacimiento: </strong>".$cumpleanios."</p>";

        //checkdate(mes, dia, año)
        //Mira si una fecha es válida.
        if(checkdate(2, 30, 2022)){ //Si existe el 30 de febrero de 2022...
            echo "<p><strong>checkdate: </strong>Fecha correcta</p>";
        }
        echo "<p><strong>checkdate: </strong>Fecha incorrecta.</p>";

        //strtotime("año/mes/dia") ó strtotime("mes/dia/año")
        //Nos devuelve la fecha que pasamos en segundos.
        echo "<p><strong>strtotime: </strong>".strtotime("1994/10/7")."</p>";

        //floor(numero decimal)
        //Redondea hacia abajo.
        echo "<p><strong>floor(5.6): </strong>".floor(5.6)."</p>";

        //ceil(numero decimal)
        //Redondea hacia arriba
        echo "<p><strong>ceil(5.6): </strong>".ceil(5.6)."</p>";

        //abs(numero) 
        //Nos devuelve el valor absoluto.
        echo "<p><strong>abs(-5.6): </strong>".abs(-5.6)."</p>";

        //substr("Cadena de texto", num inicial desde el que recorre, num cantidad de caracteres que nos devuelve)
        //Nos devuelve un trozo de la cadena string que pasemos por parámetro.
        echo "<p><strong>substr('Hola Gabi'): </strong>".substr("Hola Gabi", 5, 4)."</p>";
    ?>    
</body>
</html>