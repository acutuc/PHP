<?php
    const VALORES = array("M" => 1000, "D" => 500, "C" => 100, "L" => 50, "X" => 10, "V" => 5, "I" => 1);
    if(isset($_POST["btnComparar"])){
        for($i = 0; $i < count(strlen($_POST["numero"]))){
            if($_POST["numero"][$i] != "m" && $_POST["numero"][$i] != "d" && $_POST["numero"][$i] != "c" && $_POST["numero"][$i] != "l" && $_POST["numero"][$i] != "x" && $_POST["numero"][$i] != "v" && $_POST["numero"][$i] != "i")
            $error_letra == true;
        }
        $error_numero == "";
        $error_form == $error_numero || $error_letra;
    }
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
</head>
<body>
<div>
    <h2 align="center">Romanos a árabes - Formulario</h2>
        <form method="POST" action="index.php" ectype="multipart/form-data">
            <p>Dime un número en números romanos y lo convertiré en cifras árabes.</p>
                <p><label for="numero">Número: </label><input type="text" id="numero" name="numero" value="<?php if(isset($_POST['numero'])) echo $_POST['numero']?>"/>
                    <?php
                        if(isset($_POST["numero"]) && !error_form){
                            if($error_numero)
                                    echo "<span class = 'error'>***Campo vacío***</span>";
                                }
                    ?>
                    </p>
                    <button type="submit" name="btnComparar">Comparar</button>
                </form>
        </div>
    <?php
        //Si rellenamos el formulario y no hay errores:
        if(isset($_POST["btnComparar"]) && !$error_numero){
    ?>
        <h2 align="center">Romanos a árabes - Resultados</h2>
        <?php
        $m = 1000;
        $d = 500;
        $c = 100;
        $l = 50;
        $x = 10;
        $v = 5;
        $i = 1;
        for($j = count(strlen($_POST["numero"])); $j > 0; $j--){
            switch(strtoupper($_POST["numero"][$j])){
                case "m":

                    break;
                case "d":

                    break;
                case "c":

                    break;
                case "l":

                    break;
                case "x":

                    break;
                case "v":

                    break;
                case "i":

                    break;

                    default:

                    break;
            }
            if $_POST["numero"][$j] == "m"
        }
            
            for($j = 0; $j < count(strlen($_POST["numero"])); $j++){
                while
            }
        ?>

</body>
</html>