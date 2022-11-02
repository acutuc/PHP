<?php
function leerFichero($ruta)
{
    return nl2br(file_get_contents($ruta));
}


function obtenerCandidatos($texto, $tam)
{
    $aux = "";
    $valores = [];
    $j = 0;

    for ($i = 0; $i < strlen($texto); $i++) {

        if ($texto[$i] == " ") {

            if (strlen($aux) == $tam) {
                $valores[$j] = $aux;
                $j++;
            }

            $aux = "";
        } else {
            $aux .= $texto[$i];
        }

        if (strlen($texto) == $i + 1 && strlen($aux) == $tam) {
            $valores[$j] = $aux;
        }
    }
    return $valores;
}


function codificarTexto($texto, $codificacion)
{
    $textoCod = "";
    for ($i = 0; $i < strlen($texto); $i++) {

        if (ord($texto[$i]) >= 65 && ord($texto[$i]) <= 90) {

            if ((ord($texto[$i]) + $codificacion) > 90) {
                $textoCod .= chr($codificacion - (90 - ord($texto[$i])) + 64);
            } else {
                $textoCod .= chr(ord($texto[$i]) + $codificacion);
            }
        } else {
            $textoCod .= $texto[$i];
        }
    }
    return $textoCod;
}


function obtenerClave($textos, $clave)
{
    $posibles = [];

    foreach ($textos as $texto) {
        $correcto = false;

        if (ord($clave[0]) < ord($texto[0])) {
            $posible = ord($texto[0]) - ord($clave[0]);
            $correcto = true;
        } else if (ord($clave[0]) > ord($texto[0])) {
            $posible = (ord($texto[0]) - 64) + (90 - ord($clave[0]));
            $correcto = true;
        }

        if ($correcto && codificarTexto($texto, ord("Z") - ord("A") + 1 - $posible) == $clave) {
            array_push($posibles, $posible);
        }
    }
    return $posibles;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 3</title>
    <meta charset="UTF-8">
</head>

<body>
    <p>
        Crea dos ficheros de texto, uno con nombre decodificado.txt que esté
        vacío y otro con nombre codificado.txt que contengan las siguientes tres
        líneas de texto:
    </p>
    <p>
        JZ TLREUF KVIDZEVJ VC VAVITZTZF VJKR WIRJV KZVEV JVEKZUF.
        VJKRIRJ ZXLRC UV WVCZQ HLV WVCZO.
        WVCZO WLV LE RCLDEF HLV JRTF DLP SLVER EFKR.
    </p>
    <p>
        Crea una página php, con nombre ejercicio3.php que permita
        decodificar codificado.txt, en decodificado.txt, sabiendo que
        codificado.txt, se encriptó empleando la codificación CESAR con una
        clave desconocida. Se sabe que el fichero decodificado contiene la
        palabra FELIX como parte de su texto.
    </p>
    <p>
        El fichero decodificado.txt contendrá una última línea con la fecha en la
        que el archivo fue decodificado:
        “ Este fichero fue decodificado el Miércoles, día 30 de octubre de 2013 a
        las 11:17 horas. ”.
    </p>
    <?php
    $texto = "ND JZ TLREUF KVIDZEVJ VC VAVITZTZF VJKR WIRJV KZVEV JVEKZUF.
   VJKRIRJ ZXLRC UV WVCZQ HLV WVCZO.
   WVCZO WLV LE RCLDEF HLV JRTF DLP SLVER EFKR.";
    //$texto="PUYK JGBOJ KY AT DOIU SAE MAGVU E KYZAJOUYU, SK ZOKTK KTGSUXGJU, SK KTIGTZGXOG DAVGXRK RG VURRG VUX JKHGPU JKR IARU";

    $cod = obtenerClave(obtenerCandidatos($texto, 2), "SI");

    echo "POSIBLES RESULTADOS: <br/>";

    foreach ($cod as $i) {
        echo "** " . codificarTexto($texto, ord("Z") - ord("A") + 1 - $i) . "</br>";
    }
    ?>
</body>

</html>