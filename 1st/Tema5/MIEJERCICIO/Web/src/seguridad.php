<?php
define("MINUTOS", 10);

//Guardamos el servicio /logueado.
$url = DIR_SERV."/logueado";

//Creamos el objeto
$respuesta = consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);

//Pasamos a json:
$obj = json_decode($respuesta);
?>