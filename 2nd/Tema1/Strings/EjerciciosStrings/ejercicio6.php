<!DOCTYPE html>

<?php
$correcto = true;
?>
<html lang="es">

<head>
    <title>Ejercicio 6</title>
    <meta charset="utf-8" />
</head>
<body>
    <form method="post" action="ejercicio6.php">
        <div id="principal" style="border:1px solid black; background-color: lightblue;padding:15px; width:50%">
            <h3>Quita acentos - Formulario</h3>
            <p>Escribe un texto y le quitaré los acentos</p>
            <div>

                <textarea id="insert" name="insert" cols="30" rows="5"><?php if (isset($_POST['insert'])) {
                                                                            echo $_POST['insert'];
                                                                        }

                                                                        ?></textarea>
            </div>
            <?php
            if (isset($_POST["insert"])) {
                if ($_POST["insert"] == "") {
                    $correcto = false;
                    echo "* CAMPO OBLIGATORIO *";
                } else {
                    $texto = $_POST["insert"];
                    if (is_numeric($texto)) {
                        $correcto = false;
                        echo "* INTRODUZCA UN TEXTO POR FAVOR! *";
                    }
                }
            }
            ?>
            <div><input type="submit" id="enviar" name="enviar" value="Quitar acentos" /></div>
    </form>
    </div>
    <?php
    if (isset($_POST["enviar"]) && $correcto) {

        echo ("<div id='resultado' style='border:1px solid black; background-color: lightgreen;padding:15px; width:50%'>");
        echo ("<h3>Quita acentos - Resultado</h3>");

        echo ("<p>Texto original --> " . $texto . "</p>");
        echo ("<p>Texto sin acentos --> " . quitarAcentos($texto) . "</p>");
        echo ("</div>");
    }
    ?>

    <?php
    function quitarAcentos($texto)
    {

        $miTexto = $texto;

        $vocales = ["a", "e", "i", "o", "u"];



        $comaNormal = ["á", "é", "í", "ó", "ú"];
        $comaFuerte = ["à", "è", "ì", "ò", "ù"];
        $dosPuntos = ["ä", "ë", "ï", "ü",  "ö"];
        $valores = [$comaNormal, $comaFuerte, $dosPuntos];
        foreach ($valores as $tipos) {
            $miTexto =  str_replace($tipos, $vocales, $miTexto);
        }

        return $miTexto;
    }

    ?>
</body>

</html>