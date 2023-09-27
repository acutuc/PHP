<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
</head>
<body>
    <?php
        $meses = array("Enero" => 9, "Febrero" => 12, "Marzo" => 0, "Abril" => 17);
        foreach($meses as $clave => $valor){
            if($valor !== 0){
                echo "<p>Mes: ".$clave.". Películas: ".$valor."</p>";
            }
        }
    ?>
</body>
</html>