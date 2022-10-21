<?php
function mi_explode($separador, $texto){
    $i = 0;
    while(isset($texto[$i])){
        if($texto[$i] == $separador){

        }
    }
    switch ($_POST["separador"]) {
        case 0:
            $separador = ",";
            break;
        case 1:
            $separador = ";";
            break;
        case 2:
            $separador = " ";
            break;
        case 3:
            $separador = ":";
            break;
    }
    $arrVacio = [];


}


if (isset($_POST["btnEnviar"])) {
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
            <option value="0" <?php if (isset($_POST["separador"]) && $_POST["separador"] == "0") echo "selected" ?>>,</option>
            <option value="1" <?php if (isset($_POST["separador"]) && $_POST["separador"] == "1") echo "selected" ?>>;</option>
            <option value="2" <?php if (isset($_POST["separador"]) && $_POST["separador"] == "2") echo "selected" ?>> </option>
            <option value="3" <?php if (isset($_POST["separador"]) && $_POST["separador"] == "3") echo "selected" ?>>:</option>
        </select>
        <input type="text" name="texto" id="texto" value="<?php if (isset($_POST["texto"])) echo $_POST["texto"] ?>">
        <p>
            <button type="submit" name="btnEnviar">Enviar</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnEnviar"])) {
        print_r($_POST);
        echo "<p>El texto, según el separador, tiene: <strong>".mi_strlen($_POST["separador"], $_POST["texto"])."</strong> palabras.</p>";
    }
    ?>
</body>

</html>