<!DOCTYPE html>

<?php
$correcto = true;
?>
<html lan="es">

<head>
    <title>Ejercicio 5</title>
    <meta charset="utf-8" />

</head>

<body>

    <form method="post" action="ejercicio5.php">
        <div id="principal" style="border:1px solid black; background-color: lightblue;padding:15px; width:50%">
            <h3>Árabes a romanos - Formulario</h3>
            <p>Dime un número en números árabes y lo convertiré a cifras romanas</p>
            <label for="insert">Número</label>
            <input type="text" id="insert" name="insert" value="<?php if (isset($_POST['insert'])) {
                                                                    echo $_POST['insert'];
                                                                }

                                                                ?>" />
            <?php
            if (isset($_POST["insert"])) {
                if ($_POST["insert"] == "") {
                    $correcto = false;
                    echo "* CAMPO OBLIGATORIO *";
                } else {
                    $texto = $_POST["insert"];
                    if (!is_numeric($texto) || $texto < 1 || !ctype_digit($texto)) {
                        $correcto = false;
                        echo "* SOLO SON VÁLIDOS NUMEROS ENTEROS *";
                    }
                }
            }
            ?>
            <input type="submit" id="enviar" name="enviar" value="Comprobar" style="float:right" />
    </form>
    </div>
    <?php
    if (isset($_POST["enviar"]) && $correcto) {

        echo ("<div id='resultado' style='border:1px solid black; background-color: lightgreen;padding:15px; width:50%'>");
        echo ("<h3>ÁRABES A ROMANOS - Resultado</h3>");

        echo ("el numero árabe " . $texto . " es en romano " . transformarDecimalRmano($texto));
        echo ("</div>");
    }
    ?>

    <?php

    function transformarDecimalRmano($romano)
    {

        $valoresRomanos = array("M" => 1000, "D" => 500, "C" => 100, "L" => 50, "X" => 10, "V" => 5, "I" => 1);
        $decimal = $romano;
        $ocurrenciasLetra = 0;
        $resultado = "";


        foreach ($valoresRomanos as $indice => $valor) {
            if ($decimal >= $valor) {
                $ocurrenciasLetras = intdiv($decimal, $valor);
                for ($i = 0; $i < $ocurrenciasLetras; $i++) {
                    $resultado .= $indice;
                }

                $decimal -= $ocurrenciasLetras * $valor;
            }
        }
        return $resultado;
    }




    ?>






</body>

</html>