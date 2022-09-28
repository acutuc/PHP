<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 9</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ejercicio 9</h1>
        <p>Crear un array llamada "lenguajes_cliente" y otra "lenguajes_servidor", crea tu mismo los valores, poniendo índices alfanuméricos a cada valor.
            Junta ambas arrays en una sola llamada "lenguajes" y muéstrala por pantalla en una tabla.</p>
        <?php
            $lenguajes_cliente = array("JavaScript", "HTML", "CSS");
            $lenguajes_servidor = array("Java", "PHP", "Perl");

            $lenguajes = array("Lenguajes_Cliente" => array($lenguajes_cliente), "Lenguajes_Servidor" => array($lenguajes_servidor));

            foreach($lenguajes as $tipoLenguaje => $lenguaje){
                foreach($lenguaje as $key => $value){
                    echo "<p>$lenguajes</p>";
                }
            }
        ?>
    </body>
</html>