<?php
function encriptar($texto, $desplazamiento)
{
    $mensajeEncriptado = "";
    for ($i = 0; $i < strlen($texto); $i++) {
        if (ord($texto[$i]) >= ord("A") && ord($texto[$i]) <= ord("Z")) {
            if (ord($texto[$i]) + $desplazamiento > ord("Z")) {

                $mensajeEncriptado .= chr(ord($texto[$i]) + $desplazamiento - (ord("Z") - ord("A")) - 1);
            } else {
                $mensajeEncriptado .= chr(ord($texto[$i]) + $desplazamiento);
            }
        } else {
            $mensajeEncriptado .= $texto[$i];
        }
    }
    return $mensajeEncriptado;
}

if (isset($_POST["btnComprobar"])) {
    $error_texto = $_POST["texto"] == "";
    $error_numero = $_POST["numero"] == "" || !is_numeric($_POST["numero"]);

    $error_formulario = $error_texto || $error_numero;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 2</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Ejercicio 2</h1>
    <p>
        El cifrado César, también conocido como cifrado por desplazamiento, es
        una de las técnicas de codificación de textos más simples y usadas. Es
        un tipo de cifrado por sustitución en el que una letra en el texto original
        es reemplazada por otra letra que se encuentra un número fijo de
        posiciones más adelante en el alfabeto. Por ejemplo, con un
        desplazamiento de 3 posiciones, la A sería sustituida por la D (situada 3
        lugares a la derecha de la A ), la B sería reemplazada por la E, etc. Se
        supone que el alfabeto es circular de modo que, a todos los efectos, a
        continuación de la Z comienzan de nuevo las letras A, B, C, etc
    </p>
    <p>
        Se propone la realización de una página php con nombre
        ejercicio2.php que contenga dos cuadros de texto, uno para recibir
        una cadena de caracteres ( escrita s i n t i l d e s , s i n d i é r i s i s y s i n
        e ñ e s ) y o t r o c u a d r o d e t e x t o p a r a el desplazamiento.
        Además se le añadirá un botón, que cuando se pulse la página responda
        c o n el texto codificado y manteniendo los valores en los cuadros de
        texto.
        Se debe tener en cuenta que sólo se codifican los caracteres
        correspondientes a las letras del alfabeto, el resto de caracteres (letras
        minúsculas sin tildes, espacios en blanco, signos de puntuación, etc)
        permanecerán inalterados.
        Se hará un control de error cuando en alguno de los campos no se haya
        introducido ningún valor o cuando en el campo destinado para el
        desplazamiento no se introduzca un número. Vamos a suponer que si se
        introduce una cadena esta va a estar bien escrita.
    </p>
    <p>
        Ejemplo: Si el texto a codificar es: “UN TEXTO, y algo MAS” y la
        clave es 1 resultará “VO UFYUP, y algo NBT
    </p>
    <form action="ejercicio2.php" method="post">
        <p>
            <label for="texto">Texto a codificar: </label>
            <input type="text" name="texto" id="texto" value="<?php if (isset($_POST["texto"])) echo $_POST["texto"] ?>">
            <?php
            if (isset($_POST["texto"]) && $error_texto) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="numero">Desplazamiento: </label>
            <input type="text" id="numero" name="numero" value="<?php if (isset($_POST["numero"])) echo $_POST["numero"] ?>">
            <?php
            if (isset($_POST["btnComprobar"]) && $error_numero) {
                if ($_POST["numero"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error'>*Introduzca un valor numérico*</span>";
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnComprobar">Comprobar</button>
        </p>
    </form>
    <?php
    if (isset($_POST["texto"]) && !$error_formulario) {
        echo "<h2>Respuesta: </h2>";
        $texto = $_POST["texto"];
        $desplazamiento = $_POST["numero"];
        
        echo "<p><strong>" . encriptar($texto, $desplazamiento) . "</strong></p>";
    }
    ?>
</body>

</html>