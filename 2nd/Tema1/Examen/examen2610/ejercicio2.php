<?php
if (isset($_POST["btnContar"])) {
    $error_form = $_POST["texto"] == "";

    if(!$error_form){
        $separador = $_POST["separador"];

        $palabras_con_separador = [];
        $palabras_buenas = [];

        for($i = 0; $i < strlen($_POST["texto"]); $i++){
            

        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2 PHP</title>
</head>

<body>
    <h1>Ejercicio2. Contar Palabras sin las vocales (a, e, i, o, u, A, E, I, O, U)</h1>
    <form method="post" action="ejercicio2.php">
        <p>
            <label for="texto">Introduzca un Texto: </label>
            <input type="text" name="texto" id="texto" value="<?php if (isset($_POST["texto"])) echo $_POST["texto"] ?>">
        </p>
        <p>
            <label for="separador">Elija el separador: </label>
            <select id="separador" name="separador">
                <option value="," <?php if(isset($_POST["separador"]) && $_POST["separador"] == ",") echo "selected"; ?>>Coma (,)</option>
                <option value=";" <?php if(isset($_POST["separador"]) && $_POST["separador"] == ";") echo "selected"; ?>>Punto y coma (;)</option>
                <option value=" " <?php if(isset($_POST["separador"]) && $_POST["separador"] == " ") echo "selected"; ?>>Espacio ()</option>
                <option value=":" <?php if(isset($_POST["separador"]) && $_POST["separador"] == ":") echo "selected"; ?>>Dos puntos (:)</option>
            </select>
        </p>
        <p>
            <button name="btnContar">Contar</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnContar"]) && !$error_form) {
        echo "<h3>Respuesta</h3>";
    }
    ?>
</body>

</html>