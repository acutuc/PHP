<?php
    if(isset($_POST["btnComparar"])){
        $error_form = strlen($_POST["texto"]) < 3;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error{
            color:red;
        }
    </style>
    <title>Ejercicio 2</title>
</head>
<body>
<div>
    <h2 align="center">Palíndromos/capicúas - Formulario</h2>
        <form method="post" action="ejercicio2.php">
            <p>Dime una palabra o un número y te diré si es un palíndromo o un número capicúa.</p>
                <p><label for="texto">Palabra o número: </label><input type="text" id="texto" name="texto" value="<?php if(isset($_POST['texto'])) echo $_POST['texto']?>"/>
                    <?php
                        //Si existe $_POST["texto"] y HAY error en el formulario:
                        if(isset($_POST["texto"]) && $error_form){
                            //Si el $_POST["texto"] está vacío.
                            if($_POST["texto"] == ""){
                                echo "<span class = 'error'>***Campo vacío***</span>";
                            } else{
                                //Si tiene menos de 3 caracteres.
                                echo "<span class = 'error'>***Teclee al menos 3 caracteres***</span>";
                            }
                        }
                    ?>
                    </p>
                    <button type="submit" name="btnComparar">Comparar</button>
                </form>
        </div>
    <?php
        //Si hay submit y no hay error en formulario:
        if(isset($_POST["btnComparar"]) && !$error_form){
            echo "<h2 align = 'center'>Palíndromos/Capicúos - Formularios</h2>";
            //Quitamos los espacios del principio y final y ponemos en mayúsculas todos los caracteres:
            $texto = trim(strtoupper($_POST["texto"]));

            $i = 0;
            $j = strlen($texto) - 1;
            $capicua = true;

            while($i < $j && $capicua){
                if($texto[$i] != $texto[$j]){
                    $capicua = false;
                }
                $i++;
                $j--;
            }

            //Si es capicua:
            if($capicua){
                //Si es numérico:
                if(is_numeric($texto)){
                    echo "<p>El número <strong>".$_POST["texto"]."</strong> es capicúo.</p>";
                    //Si es una cadena de texto:
                }else{
                    echo "<p>La palabra <strong>".$_POST["texto"]."</strong> es palíndroma.</p>";
                }
                //Si no es capicua:
            }else{
                if(is_numeric($texto)){
                    //Si es numérico no capicúa:
                    echo "<p>El número <strong>".$_POST["texto"]."</strong> no es capicúo.</p>";
                }else{
                    //Si es una cadena de texto no palíndroma:
                    echo "<p>La palabra <strong>".$_POST["texto"]."</strong> no es palíndroma.</p>";
                }
            }
        }
    ?>
</body>
</html>