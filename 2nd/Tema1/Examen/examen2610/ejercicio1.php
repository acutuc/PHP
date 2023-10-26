<?php
function lecturaFichero()
{
    $fd = fopen("claves_cesar.txt", "r");

    fclose($fd);
}

function creaFichero()
{
    $fd = fopen("claves_cesar2.txt", "w");

    if (!$fd) {
        die("No se ha podido generar el fichero.");
    }

    $primera_linea = "Letra/Desplazamiento";

    for ($i = 1; $i <= 26; $i++) {
        $primera_linea .= ";" . $i;
    }
    fputs($fd, $primera_linea . PHP_EOL);

    //ord(A) = 65
    //ord(Z) = 90

    for ($i = ord("A"); $i <= ord("Z"); $i++) {
        $linea = "";
        $cont = 0;
        
        for ($j = ord("A"); $j <= ord("Z"); $j++) {
            if ($i == $j) {
                $linea = chr($i);
            } else {
                $linea .= ";" . chr($i);
            }
            $cont++;
        }
        fputs($fd, $linea.PHP_EOL);
    }

    fclose($fd);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>

<body>
    <h1>Ejercicio 1</h1>
    <form method="post" action="ejercicio1.php" enctype="multipart/form-data">
        <button name="btnGenerar">Generar</button>
    </form>
    <?php
    //if(isset($_POST["btnGenerar"])){
    //    echo "<textarea>".."</textarea>";
    //}
    creaFichero();
    echo ord("Y");
    ?>
</body>

</html>