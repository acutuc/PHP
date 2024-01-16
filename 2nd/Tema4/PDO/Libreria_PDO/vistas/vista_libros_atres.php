<?php
echo "<h3>Listado de los libros</h3>";
        

try{

    $consulta = "SELECT * FROM libros";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
}
catch(Exception $e)
{
    session_destroy();
    mysqli_close($conexion);
    die("<p>No he podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}

while($tupla = $sentencia->fetchAll(PDO::FETCH_ASSOC))
{
    echo "<p class='libros'>";
    echo "<img src='img/".$tupla["portada"]."' alt='imagen libro' title='imagen libro'><br>";
    echo $tupla["titulo"]." - ".$tupla["precio"]."€";
    echo "</p>";
}

$sentencia = null;
?>