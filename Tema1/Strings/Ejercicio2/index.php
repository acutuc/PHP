<?php
    if(isset($_POST["btnComparar"])){
        $error_palabra == "";
    }else{
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
</head>
<body>
<div>
    <h2 align="center">Palíndromos/capicúas - Formulario</h2>
        <form method="POST" action="index.php" ectype="multipart/form-data">
            <p>Dime una palabra o un número y te diré si es un palíndromo o un número capicúa.</p>
                <p><label for="palabra">Palabra o número: </label><input type="text" id="palabra" name="palabra" value="<?php if(isset($_POST['palabra'])) echo $_POST['palabra']?>"/>
                    <?php
                        if(isset($_POST["palabra"])){
                            if($_POST["palabra"] == "")
                                    echo "<span class = 'error'>***Campo vacío***</span>";
                                }
                    ?>
                    </p>
                    <button type="submit" name="btnComparar">Comparar</button>
                </form>
        </div>
    <?php

    }
    ?>
</body>
</html>