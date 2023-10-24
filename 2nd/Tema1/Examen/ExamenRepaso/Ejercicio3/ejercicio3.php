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
    $aux = [];
    $longitud_texto = mi_strlen($texto);

    $i = 0;
    while ($i < $longitud_texto && $texto[$i] == $separador) {
        $i++;
    }

    if ($i < $longitud_texto) {
        $j = 0;
        $aux[$j] = $texto[$i];
        for ($k = $i + 1; $k < $longitud_texto; $k++) {
            if ($texto[$k] != $separador) {
                $aux[$j] .= $texto[$k];
            } else {
                while ($k < $longitud_texto && $texto[$k] == $separador) {
                    $k++;
                }
                if ($k < $longitud_texto) {
                    $j++;
                    $aux[$j] = $texto[$k];
                }
            }
        }
    }

    return $aux;
}

if (isset($_POST["btnEnviar"])) {
    $error_formulario = $_POST["texto"] == "";
}


if (isset($_POST["btnEnviar"]) && !$error_formulario) {
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