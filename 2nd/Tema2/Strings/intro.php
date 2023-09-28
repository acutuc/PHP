<!DOCTYPE html>
<html>
    <head>
        <title>Teoría String</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
        //Se declara entre comillas.
            $texto1 = "Esto es un String1";
            $texto2 = "    Esto es otro String2      ";

            //Concatenamos los Strings
            echo "<p>".$texto1.", ".$texto2."</p>";

            //Esta función nos da la longitud de un String:
            echo strlen($texto1);

            //Puedo acceder a la posición de un String como si se tratara de un array.
            echo "<p>".$texto1[0]."</p>";
            //Accedemos al último caracter de un String:
            echo "<p>".$texto1[strlen($texto1)-1]."</p>";

            //Ésta función le quita los espacios del principio y final de un String:
            echo "<pre>".trim($texto2)."</pre>";

            //Pone todas las letras en mayúscula:
            echo "<p>".strtoupper($texto1)."</p>";
            //Pone todas las letras en minúscula:
            echo "<p>".strtolower($texto1)."</p>";

            //Ésta función separa un texto mediante un delimitador, en array.
            $arr = explode(" ", $texto1);
            //Imprimimos todo el contenido del array.
            echo "<p>".print_r($arr)."</p>";
            //Éste método nos da más información de un array:
            echo "<p>".var_dump($arr)."</p>";
            //Ésta función une un array mediante un delimitador:
            echo "<p>".implode(":", $arr)."</p>";

            //Ésta función encripta un String:
            echo "<p>".md5($texto2)."</p>";

        ?>
    </body>
</html>