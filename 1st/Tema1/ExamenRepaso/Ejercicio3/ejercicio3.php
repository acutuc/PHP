<?php
function mi_strlen($texto)
{
    $contador = 0;
    while (isset($texto[$contador])) {
        $contador++;
    }
    return $contador;
}

function mi_explode($separador, $texto)
{
    // Inicializar array auxiliar
    $aux = [];

    // Obtener longitud del texto
    $longitud_texto = mi_strlen($texto);

    // Inicializar índice
    $i = 0;

    // Omitir separadores iniciales
    while ($i < $longitud_texto && $texto[$i] == $separador) {
        $i++;
    }

    // Procesar texto
    if ($i < $longitud_texto) {
        $j = 0;
        $aux[$j] = $texto[$i];

        // Iterar sobre el resto del texto
        for ($k = $i + 1; $k < $longitud_texto; $k++) {
            // Si el carácter actual no es un separador
            if ($texto[$k] != $separador) {
                // Anexar carácter al elemento actual
                $aux[$j] .= $texto[$k];
            } else {
                // Omitir separadores consecutivos
                while ($k < $longitud_texto && $texto[$k] == $separador) {
                    $k++;
                }

                // Si hay más caracteres en el texto
                if ($k < $longitud_texto) {
                    // Incrementar índice y agregar nuevo elemento
                    $j++;
                    $aux[$j] = $texto[$k];
                }
            }
        }
    }

    // Devolver array auxiliar
    return $aux;
}

if (isset($_POST["btnEnviar"])) {
    $error_formulario = $_POST["texto"] == "";
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 2</title>
    <meta charset="UTF-8">
</head>

<body>
    <p>
        Realizar una página php con nombre ejercicio3.php, que contenga un
        formulario con un campo de texto, un select y un botón. Este botón al
        pulsarse, nos va a modificar la página respondiendo cuántas palabras hay
        en el cuadro de texto según el separador seleccionado en el select
        (“,”,”;”,”(espacio)“,”:”)
        Se hará un control de error cuando en el cuadro de texto no se haya
        introducido nada.
    </p>
    <form action="ejercicio3.php" method="post" enctype="multipart/form-data">
        <label for="separador">Elija separador: </label>
        <select id="separador" name="separador">
            <option value="," <?php if (isset($_POST["separador"]) && $_POST["separador"] == ",") echo "selected" ?>>,</option>
            <option value=";" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ";") echo "selected" ?>>;</option>
            <option value=" " <?php if (isset($_POST["separador"]) && $_POST["separador"] == " ") echo "selected" ?>> </option>
            <option value=":" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ":") echo "selected" ?>>:</option>
        </select>
        <input type="text" name="texto" id="texto" value="<?php if (isset($_POST["texto"])) echo $_POST["texto"] ?>">
        <?php
        if (isset($_POST["btnEnviar"]) && $error_formulario) {
            echo "<span class= 'error'>*Campo vacío*</span>";
        }
        ?>
        <p>
            <button type="submit" name="btnEnviar">Enviar</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnEnviar"])) {
        echo "<p>El texto, según el separador, tiene: <strong>" . count(mi_explode($_POST["separador"], $_POST["texto"])) . "</strong> palabras.</p>";
    }
    ?>
</body>

</html>