<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 9</title>
</head>

<body>
    <?php
    $lenguajes_cliente = ["CL1" => "Cliente 1", "CL2" => "Cliente 2", "CL3" => "Cliente 3"];
    $lenguajes_servidor = ["SR1" => "Servidor 1", "SR2" => "Servidor 2", "SR3" => "Servidor 3"];
    
    $lenguajes = array_merge($lenguajes_cliente, $lenguajes_servidor);
    
    echo "<table>";
    foreach($lenguajes as $clave => $valor){
        echo '<tr>';
        echo '<td>' . $clave . '</td><td>' . $valor . '</td></tr>';
        
    }
    echo "</table>";
    ?>
</body>

</html>