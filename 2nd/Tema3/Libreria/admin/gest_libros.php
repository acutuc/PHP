<?php
session_name("examen3_22_23");
session_start();
require "../src/funciones_ctes.php";

//Control para que no se pueda entrar a fuerza bruta:
if (!isset($_SESSION["usuario"]) || (isset($_SESSION["tipo"]) && $_SESSION["tipo"] != "admin")) {
    header("Location:../index.php");
    exit();
}

if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:../index.php");
    exit();
}
if(isset($_POST["btnEditar"])){
    $_SESSION["accion"] = "El libro con Referencia <strong>".$_POST["btnEditar"]."</strong> ha sido editado con éxito";
}
if(isset($_POST["btnBorrar"])){
    $_SESSION["accion"] = "El libro con Referencia <strong>".$_POST["btnBorrar"]."</strong> ha sido borrado con éxito";
}
if(isset($_POST["btnAgregar"])){
    $error_referencia = $_POST["referencia"] == "" || !is_numeric($_POST["referencia"]) || $_POST["referencia"] < 0;
    $error_titulo = $_POST["titulo"] == "";
    $error_autor = $_POST["autor"] == "";
    $error_descripcion = $_POST["descripcion"] == "";
    $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]) || $_POST["precio"] < 0;
    //ERROR PORTADA

    $error_form = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio;

    if(!$error_form){
        if(!isset($conexion)){
            try{
                $conexion = mysqli_connect(HOSTNAME_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                mysqli_set_charset($conexion, "utf8");
            }catch(Exception $e){
                die("<p>No se ha podido realizar la conexión. Error: ".$e->getMessage()."</p>");
            }
        }
        //REFERENCIA
        try{
            $consulta = "SELECT * FROM libros WHERE referencia = '".$_POST["referencia"]."'";
            $resultado = mysqli_query($conexion, $consulta);
        }catch(Exception $e){
            mysqli_close($conexion);
            die("<p>No se ha podido realizar la consulta. Error: ".$e->getMessage()."</p>");
        }
        if(mysqli_num_rows($resultado) == 0){
            mysqli_free_result($resultado);
            try{
                $consulta = "INSERT INTO `libros` (`referencia`, `titulo`, `autor`, `descripcion`, `precio`, `portada`) VALUES ('".$_POST["referencia"]."', '".$_POST["titulo"]."', '".$_POST["autor"]."', '".$_POST["descripcion"]."', '".$_POST["precio"]."', 'no_imagen.jpg');";
                $resultado = mysqli_query($conexion, $consulta);
                header("Location:gest_libros.php");
                exit();
            }catch(Exception $e){
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta. Error: ".$e->getMessage()."</p>");
            }
        }else{
            $error_referencia = true;
        }
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Libros</title>
    <style>
        .boton {
            color: blue;
            background: none;
            border: none;
            cursor: pointer;
            text-decoration: underline;
        }
        table{
            border:1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
            width:90%;
            text-align: center;
        }
        th{
            background-color: lightgrey;
            border:1px solid black
        }
        td{
            border:1px solid black;
        }
        .mensaje{
            color:blue;
            font-size:1.5rem;
        }
        .error{
            color: red;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <form method="post" action="gest_libros.php">
        <p>Bienvenido <strong><em><?php echo $_SESSION["lector"] ?></em></strong> -<button name="btnSalir" class="boton">Salir</button></p>
    </form>
    <?php
    if(isset($_SESSION["accion"])){
        echo "<p class='mensaje'>".$_SESSION["accion"]."</p>";
        unset($_SESSION["accion"]);
    }
    try {
        $conexion = mysqli_connect(HOSTNAME_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>No se ha podido realizar la conexión. Error: " . $e->getMessage() . "</p>");
    }
    try{
        $consulta = "SELECT * FROM libros";
        $resultado = mysqli_query($conexion, $consulta);
    }catch(Exception $e){
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta. Error: ".$e->getMessage()."</p>");
    }

    if(mysqli_num_rows($resultado) > 0){
        echo "<h3>Listado de los libros</h3>";
        echo "<table>";
        echo "<tr><th>Ref</th><th>Título</th><th>Acción</th></tr>";
        while($tupla = mysqli_fetch_assoc($resultado)){
            echo "<tr>";
            echo "<td>".$tupla["referencia"]."</td>";
            echo "<td>".$tupla["titulo"]."</td>";
            echo "<td><form method='post' action='gest_libros.php'><button name='btnBorrar' class='boton' value='".$tupla["referencia"]."'>Borrar</button> - <button name='btnEditar' class='boton' value='".$tupla["referencia"]."'>Editar</button></form></td>";
            echo "</tr>";
        }
        echo "</table>";
    }else{
        echo "<h3>No hay libros en la BD.</h3>";
    }

    echo "<h3>Agregar un nuevo libro</h3>";
    ?>
    <form method="post" action="gest_libros.php">
        <p>
            <label for="referencia">Referencia: </label><input type="text" name="referencia" id="referencia" value="<?php if(isset($_POST["referencia"])) echo $_POST["referencia"] ?>"/>
            <?php
            if(isset($_POST["btnAgregar"]) && $error_referencia){
                if($_POST["referencia"] == ""){
                    echo "<span class='error'>**Campo vacío**</span>";
                }elseif(!is_numeric($_POST["referencia"])){
                    echo "<span class='error'>**La referencia debe ser un número mayor a '0'</span>";
                }else{
                    echo "<span class='error'>**La referencia introducida ya existe en la BD**</span>";
                }
                
            }
            ?>
        </p>
        <p>
            <label for="titulo">Título: </label><input type="text" name="titulo" id="titulo" value="<?php if(isset($_POST["titulo"])) echo $_POST["titulo"] ?>"/>
            <?php
            if(isset($_POST["btnAgregar"]) && $error_titulo){
                echo "<span class='error'>**Campo vacío**</span>";
            }
            ?>
        </p>
        <p>
            <label for="autor">Autor: </label><input type="text" name="autor" id="autor" value="<?php if(isset($_POST["autor"])) echo $_POST["autor"] ?>"/>
            <?php
            if(isset($_POST["btnAgregar"]) && $error_autor){
                echo "<span class='error'>**Campo vacío**</span>";
            }
            ?>
        </p>
        <p>
            <label for="descripcion">Descripción: </label><textarea name="descripcion" id="descripcion"><?php if(isset($_POST["descripcion"])) echo $_POST["descripcion"] ?></textarea>
            <?php
            if(isset($_POST["btnAgregar"]) && $error_descripcion){
                echo "<span class='error'>**Campo vacío**</span>";
            }
            ?>
        </p>
        <p>
            <label for="precio">Precio: </label><input type="text" name="precio" id="precio" value="<?php if(isset($_POST["precio"])) echo $_POST["precio"] ?>"/>
            <?php
            if(isset($_POST["btnAgregar"]) && $error_precio){
                if($_POST["precio"] == ""){
                    echo "<span class='error'>**Campo vacío**</span>";
                }else{
                    echo "<span class='error'>**El precio introducido debe ser un número mayor a '0'</span>";
                }
                
            }
            ?>
        </p>
        <p>
            <label for="portada">Portada: </label><input type="file" name="portada" id="portada" accept="image/*"/>
        </p>
        <p>
            <button name="btnAgregar">Agregar</button>
        </p>
    </form>
    <?php
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>

</html>