<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 2</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 2</h1>
        <p>Imprime los valores del array asociativo siguiente usando la estructura de control foreach:</p>
        <p>$v[1] = 90;<br/>
        $v[30] = 7;<br/>
        $v['e'] = 99;<br/>
        $v['hola'] = 43;</p><br/>
        <?php
            $v[1] = 90;
            $v[30] = 7;
            $v['e'] = 99;
            $v['hola'] = 43;
            
            echo "<p>Imprimiendo los valores del array:</p><br/>";
            foreach ($v as $i => $valor) {
                echo "Índice: $i &nbsp;&nbsp;&nbsp; Valor: $valor<br/>";
            }
        ?>
    </body>
</html>