<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Teoría ficheros PHP</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Ficheros de texto</h1>
        <!--Casi todas las funciones de ficheros empiezan por "f"-->
        <?php
        //Para abrir un fichero: fopen(ruta, modo). Lo almacenamos en una variable.
            @$fd = fopen("prueba.txt", "r");
            if(!$fd){
                //Con die("texto") escribimos un texto y finalizamos la ejecución.
                die("<p>No se ha podido abrir el fichero <em>prueba.txt</em></p>");
            }
            //Almacenamos una linea de texto con fgets(fichero almacenado). fgets va almacenando el puntero en la línea en la que está.
            //Línea 1
            $linea = fgets($fd);
            echo "<p>".$linea."</p>";

            //Línea 2
            $linea = fgets($fd);
            echo "<p>".$linea."</p>";

            //Línea 3
            $linea = fgets($fd);
            echo "<p>".$linea."</p>";

            //fseek(fichero almacenado) Vuelve el puntero de fgets a la primera posición. El segundo parámetro es cuántos caracteres queremos saltarnos.
            fseek($fd, 0);

            //Línea 4 (NO EXISTE, PERO HEMOS VUELTO EL PUNTERO A LA PRIMERA POSICIÓN ANTES.)
            $linea = fgets($fd);
            echo "<p>".$linea."</p>";



            //Para recorrer un fichero completo: (MEJOR UTILIZAR ÉSTA OPCIÓN)
            fseek($fd, 0);
            echo "<h2>Recorrido de un fichero</h2>";
            while($linea = fgets($fd)){
                echo "<p>".$linea."</p>";
            }

            //Otra forma de recorrido de fichero:
            fseek($fd, 0);
            echo "<h2>Otra forma de recorrido (feof())</h2>";
            //feof(fichero almacenado), nos da true si ya no hay más caracteres delante de la posición del puntero.
            while(!feof($fd)){
                $linea = fgets($fd);
                echo "<p>".$linea."</p>";
            }

            //fclose(fichero almacenado). Cierra el fichero una vez hayamos hecho todas las operaciones oportunas.
            fclose($fd);


            //sudo chmod 777 -R (ruta)
            //Al abrir un archivo en modo escritura, borra primero todo lo que tenía escrito.
            //Abrimos el documento en modo escritura
            echo "<h2>Modo escritura:</h2>";
            @$fd1 = fopen("prueba2.txt", "w");
            if(!$fd1){
                //Con die("texto") escribimos un texto y finalizamos la ejecución.
                die("<p>No se ha podido abrir el fichero <em>prueba.txt</em></p>");
            }
            //fputs(fichero almacenado, texto a escribir concatenado con ENDOFLINE), escribe en el documento. Va almacenando el puntero.
            //fwrite() FUNCIONA IGUAL.
            fputs($fd1, "Primera Línea".PHP_EOL);
            fputs($fd1, "Segunda Línea".PHP_EOL);
            fclose($fd1);

            //EXTRA... (ahora no lo veremos).
            //file_get_contents("ruta del fichero"), lee el fichero completo, en vez de línea a línea.
            //Es potente para leer páginas web completas.
            $texto = file_get_contents("prueba.txt");
            echo $texto;
        ?>
    </body>
</html>