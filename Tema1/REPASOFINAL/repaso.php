<!--AQUÍ PONDRÉ TODOS LOS MÉTODOS QUE SE HAN UTILIZADO EN EL TEMA 1-->

<?php
echo "<h1>ARRAYS:</h1>";
//ARRAYS:
//El método array crea un array asociativo, se puede determinar el índice.
$arraymodelo = array(1, 2, 3, 4, 5, 6);
$arraymodelo2 = array(10, 20, 30, 40, 50, 60);

//Bucle foreach.
echo "<p>";
foreach ($arraymodelo as $indice => $valor) {
    echo "ÍNDICE: $indice &nbsp; VALOR: $valor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
echo "</p>";

//El método print_r($array) imprime todos los elementos que contiene un array.
print_r($arraymodelo);

//count($array) cuenta cuántos elementos tiene un array.
echo "<p>El array tiene " . count($arraymodelo) . " elementos.</p>";

//array_merge($array1, $array2) une los elementos de un array en otro array.
$arraymodelo3 = array_merge($arraymodelo, $arraymodelo2);
echo "El arraymodelo3: ";
print_r($arraymodelo3);
echo "<br>";

//unset($array[pocion]) borra el elemento en concreto del array.
unset($arraymodelo3[11]);
echo "Borramos el elemento en la posición 11: ";
print_r($arraymodelo3);
echo "<br>";



//STRINGS:
echo "<h1>STRINGS:</h1>";
//Se declara entre comillas.
$texto1 = "Esto es un String1";
$texto2 = "    Esto es otro String2      ";

//Concatenamos los Strings
echo "<p>" . $texto1 . ", " . $texto2 . "</p>";

//Esta función nos da la longitud de un String:
echo strlen($texto1);

//Puedo acceder a la posición de un String como si se tratara de un array.
echo "<p>" . $texto1[0] . "</p>";
//Accedemos al último caracter de un String:
echo "<p>" . $texto1[strlen($texto1) - 1] . "</p>";

//Ésta función le quita los espacios del principio y final de un String:
echo "<pre>" . trim($texto2) . "</pre>";

//Pone todas las letras en mayúscula:
echo "<p>" . strtoupper($texto1) . "</p>";
//Pone todas las letras en minúscula:
echo "<p>" . strtolower($texto1) . "</p>";

//Ésta función separa un texto mediante un delimitador, en array.
$arr = explode(" ", $texto1);
//Imprimimos todo el contenido del array.
echo "<p>" . print_r($arr) . "</p>";
//Éste método nos da más información de un array:
echo "<p>" . var_dump($arr) . "</p>";
//Ésta función une un array mediante un delimitador:
echo "<p>" . implode(":", $arr) . "</p>";

//Ésta función encripta un String:
echo "<p>" . md5($texto2) . "</p>";



//FECHAS:
echo "<h1>FECHAS:</h1>";
$tiempo = time(); //Devuelve los segundos desde el 1/1/70 hasta hoy.
echo "<p><strong>Tiempo en segundos desde 1970: </strong>" . $tiempo . "</p>";

//Puede tener dos parámetros, el segundo es time(), se le puede cambiar manualmente los segundos.
$fecha = date("d-m-Y h:i:s"); //Día, mes y año, hora, minutos y segundos. con H mayúscula nos da formato 24h.
// la Y mayúscula nos da yyyy, la y minúscula nos da yy.
echo "<p><strong>Fecha y hora actual: </strong>" . $fecha . "</p>";

//El tiempo que ha pasado desde 1/1/70 hasta el que se le pasa por parámetro:
//mktime(horas, minutos, segundos, mes, día, año)
$cumpleanios = mktime(0, 0, 0, 10, 7, 1994);
echo "<p><strong>Segundos desde 1970 hasta el día de mi nacimiento: </strong>" . $cumpleanios . "</p>";

//checkdate(mes, dia, año)
//Mira si una fecha es válida.
if (checkdate(2, 30, 2022)) { //Si existe el 30 de febrero de 2022...
    echo "<p><strong>checkdate: </strong>Fecha correcta</p>";
}
echo "<p><strong>checkdate: </strong>Fecha incorrecta.</p>";

//strtotime("año/mes/dia") ó strtotime("mes/dia/año")
//Nos devuelve la fecha que pasamos en segundos.
echo "<p><strong>strtotime: </strong>" . strtotime("1994/10/7") . "</p>";

//floor(numero decimal)
//Redondea hacia abajo.
echo "<p><strong>floor(5.6): </strong>" . floor(5.6) . "</p>";

//ceil(numero decimal)
//Redondea hacia arriba
echo "<p><strong>ceil(5.6): </strong>" . ceil(5.6) . "</p>";

//abs(numero)
//Nos devuelve el valor absoluto.
echo "<p><strong>abs(-5.6): </strong>" . abs(-5.6) . "</p>";

//substr("Cadena de texto", num inicial desde el que recorre, num cantidad de caracteres que nos devuelve)
//Nos devuelve un trozo de la cadena string que pasemos por parámetro.
echo "<p><strong>substr('Hola Gabi'): </strong>" . substr("Hola Gabi", 5, 4) . "</p>";

//FORMULARIOS:
echo "<h1>FORMULARIOS: </h1>";
if (isset($_POST["btnSubir"])) {
    //$_POST["foto"] NO EXISTIRÁ, ESTO ES A MODO EJEMPLO.
    //Se generará una variable multidimensional: $_FILES["foto"]["X"].
    //$_FILES["foto"]["name"], en "name" irá el nombre del archivo.
    //$_FILES["foto"]["error"], si hay un error aparecerá en "error".
    //$_FILES["foto"]["tmp_name"], en "tmp_name" se guardará la dirección del servidor, de forma temporal.
    //$_FILES["foto"]["size"], nos indica el tamaño en bytes.
    //$_FILES["foto"]["type"], nos indica el tipo de archivo que es.

    $error_archivo = $_FILES["foto"]["name"] == "" || $_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1024;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Teoría ficheros</title>
    <meta charset="UTF-8">
</head>

<body>
    <h3>Subir archivos</h3>
    <form action="repaso.php" method="post" enctype="multipart/form-data">
        <p>
            <!--El $_POST["foto"] no existe-->
            <label for="foto">Seleccione un archivo imagen inferior a 500KB. </label>
            <input type="file" name="foto" id="foto" accept="image/*" />
            <!--Aquí no hace falta el span de error, el propio type="file" dice que no hay archivo cargado.-->
            <?php
            //Si hay submit y error:
            if (isset($_POST["btnSubir"]) && $error_archivo) {
                //Si el nombre del archivo es distinto a vacío.
                if ($_FILES["foto"]["name"] != "") {
                    //Si hay error en la foto:
                    if ($_FILES["foto"]["error"]) {
                        echo "<span class='error'>Error en la subida del archivo.</span>";
                        //Si al haber un tamaño de 0KB, no es una imagen.
                    } elseif (!getimagesize($_FILES["foto"]["tmp_name"])) {
                        echo "<span class='error'>Error. No has seleeccionado un archivo imagen.</span>";
                        //Nos queda la última condición, el tamaño de la imagen es mayor.
                    } else {
                        echo "<span class='error'>Error. El tamaño de la imagen seleccionada es mayor a 500KB.</span>";
                    }
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnSubir">Subir imagen</button>
            <!--Si le damos a submit, no hay manera de mantener la imagen cargada, por seguridad.-->
        </p>
    </form>
    <?php
    //SI NO HAY ERRORES:
    if (isset($_POST["btnSubir"]) && !$error_archivo) {
        echo "<h3>Respuestas cuando no hay errores y la imagen se ha subido.</h3>";
        echo "<p><strong>Nombre de la imagen seleccionada: </strong>" . $_FILES["foto"]["name"] . "</p>";
        echo "<p><strong>Error en la subida: </strong>" . $_FILES["foto"]["error"] . "</p>";
        echo "<p><strong>Ruta del archivo temporal: </strong>" . $_FILES["foto"]["tmp_name"] . "</p>";
        echo "<p><strong>Tamaño del archivo: </strong>" . $_FILES["foto"]["size"] . " B</p>";
        echo "<p><strong>Tipo de archivo: </strong>" . $_FILES["foto"]["type"] . "</p>";

        //Separamos el nombre del archivo de la extensión:
        $array_nombre = explode(".", $_FILES["foto"]["name"]);

        $extension = "";
        //Si la extensión es sólo de una posición, es que no tiene extensión.
        //Concatenamos un "." con el $array_nombre.
        if (count($array_nombre) > 1) {
            $extension = "." . strtolower(end($array_nombre));
        }
        //La extensión será la última posición del array:
        $extension = end($array_nombre);

        //uniqid() genera un número único.
        $nombre_unico = "img_" . md5(uniqid(uniqid(), true));

        //Unificamos el nombre único con la extensión.
        $nombre_nuevo_archivo = $nombre_unico . $extension;

        //Almacenamos el archivo en una ruta en concreto.
        //Con el arroba quitamos el "Warning" en la página.
        @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "images/" . $nombre_nuevo_archivo);

        if (!$var) {
            echo "<p>La imagen no ha posidio ser movida por falta de permisos.</p>";
        } else {
            echo "<h3>La imagen ha sido subida con éxito</h3>";
            echo "<img height = '200' src='images/" . $nombre_nuevo_archivo . "'/>";
        }
    }

    //sudo chmod 777 -R RUTA 
    //Para dar permisos recursivamente a todas las carpetas para meter imágenes.
    ?>

    <body>

</html>

<?php
//FICHEROS: 
echo "<h1>FICHEROS: </h1>";
?>
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
            fputs($fd1, "Tercera Línea");
            fclose($fd1);

            //EXTRA... (ahora no lo veremos).
            //file_get_contents("ruta del fichero"), lee el fichero completo, en vez de línea a línea.
            //Es potente para leer páginas web completas.
            $texto = file_get_contents("prueba.txt");
            echo $texto;
        ?>
    </body>
</html>