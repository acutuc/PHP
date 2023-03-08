<?php
    const VALORES = array("M" => 1000, "D" => 500, "C" => 100, "L" => 50, "X" => 10, "V" => 5, "I" => 1);

    function letras_bien($texto){
        $bien = true;
        for($i = 0; $i < strlen($texto); $i++){
            if(!isset(VALORES[$texto[$i]])){
                $bien = false;
                break;
            }
        }
        return $bien;
    }

    function orden_decreciente($texto){
        $bien = true;
        for($i = 0; $i < strlen($texto)-1; $i++){
            if(VALORES[$texto[$i]] < VALORES[$texto[$i + 1]]){
                $bien = false;
                break;
            }
        }
        return $bien;
    }

    function repite_bien($texto){
        $veces["M"] = 4;
        $veces["D"] = 1;
        $veces["C"] = 4;
        $veces["L"] = 1;
        $veces["X"] = 4;
        $veces["V"] = 1;
        $veces["I"] = 4;

        $bien = true;
        for($i = 0; $i < strlen($texto); $i++){
            $veces[$texto[$i]]--;
            if($veces[$texto[$i]] < 0){
                $bien = false;
                break;
            }
        }
        return $bien;
    }

    function es_romano($texto){
        return letras_bien($texto) && orden_decreciente($texto) && repite_bien($texto);
    }

    if(isset($_POST["btnComparar"])){
        $error_form = $_POST["numero"] == "" || !es_romano(trim(strtoupper($_POST["numero"])));
    }
?>
<!DOCTYPE html>
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
            <p><label for="numero">Número: </label><input type="text" id="numero" name="numero"
                    value="<?php if(isset($_POST['numero'])) echo $_POST['numero']?>" />
                <?php
                        if(isset($_POST["numero"]) && $error_form){
                            if($_POST["numero"]==""){
                                echo "<span class = 'error'>***Campo vacío***</span>";
                            }else{
                                echo "<span class = 'error'>***Número romano escrito incorrectamente.***</span>";
                            }
                        }
                    ?>
            </p>
            <button type="submit" name="btnComparar">Comparar</button>
        </form>
    </div>
    <?php
        //Si rellenamos el formulario y no hay errores:
        if(isset($_POST["btnComparar"]) && !$error_form){
            echo "<h2 align='center'>Romanos a árabes - Resultados</h2>";

            //Almacenamos en $numero el trim y las letras en mayúsculas de $_POST["numero"]
            $numero = trim(strtoupper($_POST["numero"]));

            $resultado = 0;

            //Recorremos la longitud de la cadena $numero
            for($i = 0; $i < strlen($numero); $i++){
                 $resultado += VALORES[$numero[$i]];
            }

            echo "<p>El número <strong>".$numero."</strong> se escribe en cifras árabes ".$resultado."</p>";
        }
            
        
        ?>

</body>

</html>