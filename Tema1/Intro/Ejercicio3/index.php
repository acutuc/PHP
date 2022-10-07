<!--EJERCICIO DE CONTROL DE ERRORES. NOS EXIGE RELLENAR LOS CAMPOS CON UN AVISO.-->
<?php
if(isset($_POST["btnReset"])){
	header("Location: index.php");
	exit; //RECOMENDABLE UTILIZAR "exit" AL USAR EL "header" DE RESETEO.
}

	$error_formulario = true;
	if(isset($_POST["btnGuardar"])){
	//Si al enviar el formulario alguno de los siguientes campos está vacío, nos devolverá al propio formulario.
		$error_nombre = $_POST["nombre"] == ""; //SON EXPRESIONES BOOLEANAS.
		$error_apellidos = $_POST["apellidos"] == "";
		$error_contrasena = $_POST["contrasena"] == "";
		$error_dni = $_POST["dni"] == "";
		$error_sexo = !isset($_POST["sexo"]); //CUANDO NO SE HAYA INICIALIZADO.
		$error_comentarios = $_POST["comentarios"] == "";
		
		
		$error_formulario = $error_nombre || $error_apellidos || $error_contrasena || $error_dni || $error_sexo || $error_comentarios;
	}
	if(!$error_formulario){
		require "../Ejercicio2/Vistas/vista_respuesta.php";
	}else{
	
?>
<?php
	require "vistas_formulario.php";
?>
<?php
}
?>
