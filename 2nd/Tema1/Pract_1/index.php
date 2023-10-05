<?php

require "src/funciones.php";

if (isset($_POST["btnGuardarCambios"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_apellidos = $_POST["apellidos"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito(strtoupper($_POST["dni"])) || !dni_valido(strtoupper($_POST["dni"]));
    $error_sexo = !isset($_POST["sexo"]);
    $error_comentarios = $_POST["comentarios"] == "";
    $error_foto = $_FILES["foto"]["name"] == "" || $_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]);

    $error_form = $error_nombre || $error_apellidos || $error_clave || $error_dni || $error_sexo || $error_comentarios;
}
if (isset($_POST["btnGuardarCambios"]) && !$error_form) {
    require "vistas/vista_respuestas.php";
} else {
    require "vistas/vista_formulario.php";
}
