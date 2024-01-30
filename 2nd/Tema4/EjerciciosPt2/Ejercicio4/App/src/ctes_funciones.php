<?php
//CTES base de datos

define("SERVIDOR_BD","localhost");
define("USUARIO_BD","jose");
define("CLAVE_BD","josefa");
define("NOMBRE_BD","bd_foro");

define("DIR_SERV", "http://localhost/PHP/2nd/Tema4/EjerciciosPt2/Ejercicio4/login_restful");

function consumir_servicios_REST($url, $metodo, $datos = null)
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

function error_page($title,$body)
{
    $page='<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.'</title>
    </head>
    <body>'.$body.'</body>
    </html>';
    return $page;
}

function repetido($conexion,$tabla,$columna,$valor)
{

    try{
        $consulta="select * from ".$tabla." where ".$columna."='".$valor."'";
        $resultado=mysqli_query($conexion, $consulta);
        $respuesta=mysqli_num_rows($resultado)>0;
        mysqli_free_result($resultado);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        $respuesta=error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>");
    }
    return $respuesta;
}

function repetido_editando($conexion,$tabla,$columna,$valor,$columna_clave,$valor_clave)
{

    try{
        $consulta="select * from ".$tabla." where ".$columna."='".$valor."' AND ".$columna_clave."<>'".$valor_clave."'";
        $resultado=mysqli_query($conexion, $consulta);
        $respuesta=mysqli_num_rows($resultado)>0;
        mysqli_free_result($resultado);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        $respuesta=error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>");
    }
    return $respuesta;
}


?>