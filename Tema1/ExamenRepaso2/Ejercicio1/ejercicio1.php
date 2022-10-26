<?php
function mi_substr($texto){

}

if (isset($_POST["btnComprobar"])) {
    $error_texto1 = $_POST["texto1"] == "";
    $error_texto2 = $_POST["texto2"] == "" || strlen($_POST["texto2"]) > strlen($_POST["texto1"]);

    $error_formulario = $error_texto1 || $error_texto2;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 1</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Ejercicio 1</h1>
    <p>
        Realizar una página php con nombre ejercicio1.php, que contenga un
        formulario con dos campos de texto y un botón. Este botón al pulsarse,
        nos va a modificar la página respondiendo si lo introducido en el segundo
        cuadro de texto es subcadena de lo introducido en el primer cuadro de
        texto. Al responder, la página mantendrá los valores introducidos en los
        cuadros de textos.
        Se hará un control de error cuando en alguno de los campos no se haya
        introducido ningún valor o cuando la subcadena introducida en el segundo
        cuadro de texto tenga una longitud mayor que la cadena introducida en el
        primer cuadro de texto.
    </p>
    <form action="ejercicio1.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="texto1">Texto 1: </label><input type="text" id="texto1" name="texto1" value="<?php if (isset($_POST["texto1"])) echo $_POST["texto1"] ?>">
            <?php
            if (isset($_POST["btnComprobar"]) && $error_texto1) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="texto2">Texto 2: </label><input type="text" id="texto2" name="texto2" value="<?php if (isset($_POST["texto2"])) echo $_POST["texto2"] ?>">
            <?php
            if (isset($_POST["btnComprobar"]) && $error_texto2) {
                if ($_POST["texto2"] == "") {
                    echo "<span class='error'>*Campo vacío*</span>";
                } else {
                    echo "<span class='error'>*Texto 2 contiene más caracteres que Texto 1*</span>";
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnComprobar">Comprobar</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnComprobar"]) && !$error_formulario) {
        echo substr($_POST["texto1"], 1);
    }
    ?>
</body>

</html>