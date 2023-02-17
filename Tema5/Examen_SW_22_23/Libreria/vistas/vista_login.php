<?php
    if(isset($_POST["btnEntrar"])){
        $error_usuario = $_POST["lector"] == "";
        $error_clave = $_POST["clave"] == "";
        $error_form = $error_usuario || $error_clave;

        //Si hay algo tecleado en los input:
        if(!$error_form){
            $url = DIR_SERV."/login";

            $datos_log["lector"] = $_POST["lector"];
            $datos_log["clave"] = md5($_POST["clave"]);

            $respuesta = consumir_servicios_REST($url, "POST", $datos_log);
            
            $obsj = json_decode($respuesta);

            if(!$obj){
                
                die(error_page("Página Inicio", "Librería", $respuesta));
            }
            if($obj->mensaje){
                
                die(error_page("Página Inicio", "Librería", $respuesta));
            }
            if($obj->error){

                die(error_page("Página Inicio", "Librería", "Error consumiendo el servicio".$url));
            }
            echo "sadasda";
            if($obj->lector){
                
                $_SESSION["lector"] = $datos_log[0];
                $_SESSION["clave"] = $datos_log[1];
                $_SESSION["ultimo_acceso"] = time();
                //$_SESSION["api_session"]["api_session"] = $obj->api_session;

                header("Location:index.php");
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error{color:red}
    </style>
    <title>Página Inicio</title>
</head>
<body>
    <h1>Librería</h1>
    <form action="index.php" method="post">
        <p>
            <label for="lector">Nombre de usuario: </label>
            <input type="text" name="lector" id="lector" value="<?php if(isset($_POST["lector"])) echo $_POST["lector"] ?>">
            <?php
                if(isset($_POST["btnEntrar"]) && $error_usuario){
                    if($_POST["lector"] == ""){
                        echo "<span class='error'>Campo vacío</span>";
                    }else{
                        echo "<span class='error'>Usuario o contraseña no existe</span>";
                    }
                    
                }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" id="clave" name="clave">
            <?php
                if(isset($_POST["btnEntrar"]) && $error_clave){
                    echo "<span class='error'>Campo vacío</span>";
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnEntrar">Entrar</button>
        </p>
    </form>
</body>
</html>