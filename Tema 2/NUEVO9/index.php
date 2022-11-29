<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUEVO 9</title>
    <style>
        table, th, td{
            border: 1px solid black;
            border-collapse:collapse;
        }
        img{
            height:100px;
            width:auto;
        }
    </style>
</head>

<body>
    <h1>Películas</h1>
    <?php
    //1. Conectamos con la base de datos.
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_videoclub");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("No se ha podido realizar la conexión. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error().".");
    }

    //2. Listamos y pintamos la tabla.
    try{
        $consulta = "SELECT * FROM peliculas";
        $resultado = mysqli_query($conexion, $consulta);
        if(mysqli_num_rows($resultado) > 0){
            echo "<table>";
            echo "<tr><th>ID</th><th>Título</th><th>Carátula</th><th><form action='index.php' method='post'><button type='submit' name='btnAgregar'>Películas +</button></form></th></tr>";
            while($tupla = mysqli_fetch_assoc($resultado)){
                echo "<tr>";
                echo "<td>".$tupla["idPelicula"]."</td>";
                echo "<td><form action='index.php' method='post'><button type='submit' name='btnListar' value='".$tupla["idPelicula"]."'>".$tupla["titulo"]."</button></form></td>";
                echo "<td><img src='Img/".$tupla["caratula"]."'></td>";
                echo "<td><form action='index.php' method='post'><button type='submit' name='btnBorrar' value='".$tupla["idPelicula"]."'>Borrar</button> - <button type='submit' name='btnEditar' value='".$tupla["idPelicula"]."'>Editar</button></form></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }catch (Exception $e){
        $mensaje = "No se ha podido realizar la conexión. Error nº: ".mysqli_errno($conexion).". ".mysqli_error($conexion);
        mysqli_close($conexion);
        die($mensaje);
    }

    //3. Operaciones CRUD:
    
    //3.1. Listar:
    if(isset($_POST["btnListar"])){
        echo "<h2>Película con ID ".$_POST["btnListar"]."</h2>";
        $consulta = "SELECT * FROM peliculas WHERE idPelicula = '".$_POST["btnListar"]."'";
        try{
            $resultado = mysqli_query($conexion, $consulta);

            if(mysqli_num_rows($resultado) > 0){
                $datos_usuario = mysqli_fetch_assoc($resultado);
                echo "<p><strong>Título: </strong>".$datos_usuario["titulo"]."</p>";
                echo "<p><strong>Director: </strong>".$datos_usuario["director"]."</p>";
                echo "<p><strong>Sinopsis: </strong>".$datos_usuario["sinopsis"]."</p>";
                echo "<p><strong>Temática: </strong>".$datos_usuario["tematica"]."</p>"; 
                echo "<p><img src='Img/".$datos_usuario["caratula"]."'></p>";
            }
        }catch(Exception $e){
            $mensaje = "No se ha podido realizar la conexión. Error nº: ".mysqli_errno($conexion).". ".mysqli_error($conexion);
            mysqli_close($conexion);
            die($mensaje);
        }

        

    }
    
    ?>
</body>

</html>