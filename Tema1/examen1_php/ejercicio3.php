<?php
if (isset($_POST["btnDecodificar"])) {
    $error_texto = $_POST["texto"] == "";
    $error_fichero = $_FILES["fichero"]["name"] == "" || $_FILES["fichero"]["error"] || $_FILES["fichero"]["size"] > 1250000 || $_FILES["fichero"]["type"] != "text/plain";

    $error_formulario = $error_texto || $error_fichero;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 3. Decodifica una frase</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Ejercicio 3. Decodifica una frase</h1>
    <form action="ejercicio3.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="texto">Introduzca un texto: </label><input type="text" name="texto" id="texto">
            <?php
            if (isset($_POST["btnDecodificar"]) && $error_texto) {
                echo "<span class='error'>*Campo vacío*</span>";
            }
            ?>
        </p>
        <p>
            <label for="fichero">Seleccione el archivo de claves (.txt y menor de 1'25MB) </label><input type="file" accept=".txt" name="fichero" id="fichero">
            <?php
            if (isset($_POST["btnDecodificar"]) && $error_fichero) {
                if ($_FILES["fichero"]["size"] > 1250000) {
                    echo "<span class='error'>*El fichero es mayor de 1'25MB*</span>";
                }
                if ($_FILES["fichero"]["name"] == "") {
                    echo "<span class='error'>*No ha seleccionado ningún fichero*</span>";
                }
                if ($_FILES["fichero"]["type"] != "text/plain") {
                    echo "<span class='error'>*No ha seleccionado un archivo de formato .txt*</span>";
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnDecodificar">Decodificar</button>
        </p>
    </form>

    <?php
    if (isset($_POST["btnDecodificar"]) && !$error_formulario) {
        echo "<h2>Respuesta</h2>";
        $respuesta = "";
        $texto = $_POST["texo"];
        $long_frase = strlen($texto);

        for ($i = 0; $i < $long_frase; $i++) {
            if ($texto[$i] >= "0" && $texto[$i] <= "5") {
                if ($i < $long_frase) {
                    if ($texto[$i + 1] >= "0" && $texto[$i + 1] <= "5") {
                        if ($texto[$i] == "0" && $texto[$i + 1] == "0") {
                            $respuesta .= "J";
                            $i++;
                        } elseif ($texto[$i] == "0") {
                            $respuesta .= $texto[$i];
                        } elseif ($texto[$i + 1] == "0") {
                            $respuesta .= $texto[$i];
                        }else{
                            codificar();
                        }
                    } else {
                        $respuesta .= $texto[$i];
                    }
                } else {
                    $respuesta .= $texto[$i];
                }
            } else {
                $respuesta .= $texto[$i];
            }
        }
    }
    ?>
</body>

</html>