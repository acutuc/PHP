<?php
require "src/ctes_funciones.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table{
            border-collapse: collapse;
            border: 1px solid black;
            width: 90%;
            text-align: center;
            margin:0 auto;
        }
        th{
            background-color: lightgrey;
        }
        td, th{
            border: 1px solid black;
            padding:1rem;
        }
        img{
            height: 100px;
            width: 100px;
        }
        .enlace{
            color:blue;
            text-decoration: underline;
            background: none;
            border:0px;
            cursor:pointer;
        }
    </style>
    <title>Práctica 9</title>
</head>

<body>
    <h1>Videoclub</h1>
    <h2>Películas</h2>
    <h4>Listado de películas</h4>
    <?php
    //1. Conectamos:
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>Imposible conectar. Error: " . $e->getMessage() . "</body></html>");
    }

    try{
        $consulta = "SELECT * FROM peliculas";
        $resultado = mysqli_query($conexion, $consulta);
    }catch(Exception $e){
        mysqli_close($conexion);
        die("<p>Imposible realizar la consulta. Error: ".$e->getMessage()."</p></body></html>");
    }

    //2. Pintamos la tabla:
    echo "<table>";
    echo "<tr><th>ID</th><th>Título</th><th>Carátula</th><th><form method='post' action='index.php'><button name='btnAgregar' class='enlace'>Películas+</button></form></th></tr>";
    while($tupla = mysqli_fetch_assoc($resultado)){
        echo "<tr>";

        echo "<td>".$tupla["idPelicula"]."</td>";
        echo "<td><form method='post' action='index.php'><button name='btnDetalles' value='".$tupla["idPelicula"]."' class='enlace'>".$tupla["titulo"]."</button></form></td>";
        echo "<td><img src='Img/".$tupla["caratula"]."' title='".$tupla["caratula"]."' alt='".$tupla["caratula"]."'/></td>";
        echo "<td><form method='post' action='index.php'><button name='btnBorrar' value='".$tupla["idPelicula"]."' class='enlace'>Borrar</button> - <button name='btnEditar' value='".$tupla["idPelicula"]."' class='enlace'>Editar</button></form></td>";

        echo "</tr>";
    }
    echo "</table>";

    //3. Si hemos pulsado en los detalles de una película, listamos:
    if(isset($_POST["btnDetalles"])){
        //Conectamos y buscamos los datos de la película:
        try{
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        }catch(Exception $e){
            mysqli_close($conexion);
            die("<p>Imposible conectar. Error: ".$e->getMessage()."</p></body></html>");
        }

        try{
            $consulta = "SELECT * FROM peliculas WHERE idPelicula = ".$_POST["btnDetalles"];
            $resultado = mysqli_query($conexion, $consulta);
        }catch(Exception $e){
            mysqli_close($conexion);
            die("<p>Imposible realizar la consulta. Error: ".$e->getMessage()."</p></body></html>");
        }

        //Comprobamos que no se haya borrado la película de la BD mientras consultamos:
        if(mysqli_num_rows($resultado) > 0){
            $datos_pelicula = mysqli_fetch_assoc($resultado);
            mysqli_free_result($resultado);

            echo "<p><strong>ID:</strong> ".$datos_pelicula["idPelicula"]."</p>";
        }
    }
    
    mysqli_close($conexion);
    ?>
</body>

</html>