<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría PDO</title>
</head>

<body>
    <h1>Teoría PDO</h1>
    <?php
    define("SERVIDOR_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_foro2");

    //CONECTAMOS A LA BASE DE DATOS.    
/*
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("Imposible conectar. Error nº: " . mysqli_connect_errno() . ". " . mysqli_connect_error());
    }
    echo "<p>Conectado con éxito.</p>";
*/


    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die("Imposible conectar. Error: " . $e->getMessage());
    }

    echo "<p>Conectado con éxito.</p>";

    //----------------------------------
    

    //HACEMOS UNA CONSULTA DE LOGGEO.
    
    $usuario = "acu";
    $clave = md5("acu");

    /*
    try{
    $consulta = "SELECT * FROM usuarios WHERE usuario = '" . $usuario . "' AND clave = '" . $clave . "'";
    $resultado = mysqli_query($conexion, $consulta);
    $tupla = array();
    if(mysqli_num_rows($resultado) > 0){
    $tupla = mysqli_fetch_assoc($resultado);
    }
    var_dump($tupla);
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    }catch(Exception $e){
    $mensaje = "Imposible conectar. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion);
    mysqli_close($conexion);
    die($mensaje);
    }
    */

    /*
    try {

        $consulta = "SELECT * FROM usuarios WHERE usuario=? and clave =?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);

        if ($sentencia->rowCount() > 0) {
            $tupla = $sentencia->fetch(PDO::FETCH_ASSOC);
            echo "<p>Bienvenid@, " . $tupla["nombre"] . "</p>";
        }

        $sentencia = null; //Libera sentencia
        $conexion = null; //Cierra conexión

    } catch (PDOException $e) {

        $sentencia = null; //Libera sentencia
        $conexion = null; //Cierra conexión
        die("Imposible realizar la consulta. Error: " . $e->getMessage());
    }
    */

    //-------------------------------------------------
    
    //CONSULTA PARA OBTENER TODAS LAS TUPLAS:
/*
    try{
        $consulta = "SELECT * FROM usuarios";
        $resultado = mysqli_query($conexion, $consulta);

        while($tupla = mysqli_fetch_assoc($resultado)){
            echo "<p><strong>Usuario: </strong>".$tupla["usuario"]."</p>";
        }

        mysqli_free_result($resultado);
        mysqli_close($conexion);
        }catch(Exception $e){
        $mensaje = "Imposible conectar. Error nº: " . mysqli_errno($conexion) . ". " . mysqli_error($conexion);
        mysqli_close($conexion);
        die($mensaje);
        }
*/
    /*
    try {
    $consulta = "SELECT * FROM usuarios";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
    $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    foreach ($respuesta as $tupla) {
    echo "<p><strong>Usuario: </strong>" . $tupla["usuario"] . "</p>";
    }
    //Liberamos y cerramos la conexión:
    $sentencia = null;
    $conexion = null;
    } catch (PDOException $e) {
    $sentencia = null; //Libera sentencia.
    $conexion = null; //Cierra conexión.
    die("Imposible conectar. Error: " . $e->getMessage());
    }
    */

    //INSERT:
    
    $nombre = "Juan Pablo";
    $usuario = "mateo78";
    $clave = md5("123456");
    $email = "algo@gmail.com";
    /*
    try{
    $consulta = "INSERT INTO usuarios (nombre, usuario, clave, email) VALUES ('".$nombre."', '".$usuario."', '".$clave."', '".$email."')";
    mysqli_query($conexion, $consulta);
    echo "<p>Usuario insertado conéxito con la ID igual a: ".mysqli_insert_id($conexion)."</p>";
    mysqli_close($conexion);
    }catch(Exception $e){
    $mensaje = "Imposible conectar. Error nº: ".mysqli_errno($conexion).". ".mysqli_error($conexion);
    mysqli_close($conexion);
    die($mensaje);        
    }
    */

    try {
        $consulta = "INSERT INTO usuarios (nombre, usuario, clave, email) VALUES (?, ?, ?, ?)";
        $sentencia = $conexion->prepare($consulta);
        $datos[] = $nombre;
        $datos[] = $usuario;
        $datos[] = $clave;
        $datos[] = $email;

        $sentencia->execute($datos);

        echo "<p>Usuario insertado con éxito don la ID: " . $conexion->lastInsertId(). "</p>";
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        die("Imposible conectar. Error: " . $e->getMessage());
    }

    ?>
</body>

</html>