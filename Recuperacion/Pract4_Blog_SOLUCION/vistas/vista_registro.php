<?php
if (isset($_POST["btnContinuarRegistro"])) {
    var_dump($_POST);
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_correo = $_POST["correo"] == "";
}
?>

<h1>Registrar nuevo usuario</h1>

<form method="post" action="index.php">
    <p>
        <label for="usuario">Usuario: </label><input type="text" id="usuario" name="usuario"
            value="<?php if (isset($_POST["usuario"]))
                echo $_POST["comentario"]; ?>">
            <?php
            if (isset($error_usuario)) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>* Campo vacío *</span>";
                } else {
                    echo "<span class='error'>* El usuario ya se encuentra registrado *</span>";
                }
            }
            ?>
    </p>
    <p>
        <label for="clave">Contraseña: </label><input type="password" id="clave" name="clave">
    </p>
    <p>
        <label for="correo">Correo electrónico: </label><input type="email" id="correo" name="correo"
            value="<?php if (isset($_POST["correo"]))
                echo $_POST["correo"] ?>" />
        </p>
        <p>
            <button>Volver</button> <button name="btnContinuarRegistro">Registrar</button>
        </p>
    </form>