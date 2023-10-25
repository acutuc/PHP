<?php
    function creaMatriz (){
        @$fd = fopen("claves_polybios.txt", "w");
        if(!$fd){
            die("<p>No se ha podido generar el archivo.</p>");
        }

        $primera_linea = "i/j;1;2;3;4;5";

        fputs($fd, $primera_linea.PHP_EOL);
        
        for($i = 1; $i <= 5; $i++){

            
        }
        
        

        
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>
<h1>Práctica</h1>
<body>
    <form method="post" action="ejercicio1.php">
        <button name="btnGenerar">Generar</button>
    </form>
    <?php
    if(isset($_POST["btnGenerar"])){
        echo "<h3>Respuesta</h3>";
        echo "<textarea>".creaMatriz()."</textarea>";
        echo "<p>Fichero generado con éxito.</p>";
    }
?>
</body>
</html>