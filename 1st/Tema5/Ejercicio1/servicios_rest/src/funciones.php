<?php
function obtener_productos()
{
    //Conectamos a la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        //CONECTAMOS AQUÍ!!!!!!!:
        try {
            $consulta = "SELECT * FROM producto";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            //Ejecutamos la sentencia:
            $sentencia->execute();

            $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}

function obtener_producto($cod)
{
    //Conectamos a la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        //CONECTAMOS AQUÍ!!!!!!!:
        try {
            $consulta = "SELECT * FROM producto WHERE cod = ?";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            //Metemos los datos:
            $datos[] = $cod;

            //Ejecutamos la sentencia:
            $sentencia->execute($datos);

            $respuesta["producto"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}

function insertar_producto($datos)
{
    //Conectamos a la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        //CONECTAMOS AQUÍ!!!!!!!:
        try {
            $consulta = "INSERT INTO producto (cod, nombre, nombre_corto, descripcion, PVP, familia) VALUES (?, ?, ?, ?, ?, ?)";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            //Ejecutamos la sentencia CON EL PARÁMETRO DE LA FUNCIÓN:
            $sentencia->execute($datos);

            //Devolvemos en el array asociativo el código del producto insertado.
            $respuesta["mensaje"] = $datos[0];
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}

function actualizar_producto($datos)
{
    //Conectamos a la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        //CONECTAMOS AQUÍ!!!!!!!:
        try {
            $consulta = "UPDATE producto SET nombre = ?, nombre_corto = ?, descripcion = ?, PVP = ?, familia = ? WHERE cod = ?";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            //Ejecutamos la sentencia CON EL PARÁMETRO DE LA FUNCIÓN:
            $sentencia->execute($datos);

            //El código está en la posición 5!!!!!!!!!
            $respuesta["mensaje"] = $datos[5];
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}
function borrar_producto($cod)
{
    //Conectamos a la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        //CONECTAMOS AQUÍ!!!!!!!:
        try {
            $consulta = "DELETE FROM producto WHERE cod = ?";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            //Ejecutamos la sentencia
            $sentencia->execute([$cod]);

            $respuesta["mensaje"] = $cod;
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}

function obtener_familias()
{
    //Conectamos a la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        //CONECTAMOS AQUÍ!!!!!!!:
        try {
            $consulta = "SELECT * FROM familia";

            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            //Ejecutamos la sentencia:
            $sentencia->execute();

            $respuesta["familias"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}

function obtener_familia($cod)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        try {
            $consulta = "SELECT * FROM familia WHERE cod=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$cod]);
            $respuesta["familia"] = $sentencia->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible realizar la consulta. Error:" . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error:" . $e->getMessage();
    }


    return $respuesta;
}

function repetido($tabla, $columna, $valor, $columna_clave = null, $valor_clave = null)
{
    //Conectamos a la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        //CONECTAMOS AQUÍ!!!!!!!:
        try {
            if (isset($columna_clave)) {
                $consulta = "SELECT ".$columna." FROM ".$tabla." WHERE ".$columna." = ? AND ".$columna_clave." <> ?";
                $datos[] = $valor;
                $datos[] = $valor_clave;
            } else {
                $consulta = "SELECT ".$columna." FROM ".$tabla." WHERE ".$columna." = ?";
                $datos[] = $valor;
            }


            //Preparamos la sentencia:
            $sentencia = $conexion->prepare($consulta);

            //Ejecutamos la sentencia:
            $sentencia->execute($datos);

            $respuesta["repetido"] = $sentencia->rowCount() > 0;
        } catch (PDOException $e) {
            $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
        }
        $sentencia = null;
        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "Imposible conectar. Error: " . $e->getMessage();
    }

    return $respuesta;
}
?>