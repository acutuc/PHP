<?php
if (isset($_POST["btnNuevoUsuario"]) || isset($_POST["btnContinuar"])) {

    if (isset($_POST["btnContinuar"])) {
        $error_nombre = $_POST["nombre"] == "";
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";
        $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

        $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

        if(!$error_form){
            //Conexión a la BD.
            try{
                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
                mysqli_set_charset($conexion, "uft8");
            }catch(Exception $e){
                die("<p>No se ha podido conectar: ".$e->getMessage()."</p></body></html>");
            }


        }
    }
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nuevo usuario</title>
        <style>
            .error {
                color: red;
            }
        </style>
    </head>

    <body>
        <h1>Nuevo usuario</h1>
        <form method="post" action="usuario_nuevo.php">
            <p>
                <label for="nombre">Nombre: </label><input type="text" name="nombre" maxlength="30" id="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"] ?>">
                <?php
                if (isset($_POST["btnContinuar"]) && $error_nombre) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>
            <p>
                <label for="usuario">Usuario: </label><input type="text" name="usuario" maxlength="20" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
                <?php
                if (isset($_POST["btnContinuar"]) && $error_usuario) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña: </label><input type="password" name="clave" maxlength="15" id="clave">
                <?php
                if (isset($_POST["btnContinuar"]) && $error_clave) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>
            <p>
                <label for="email">Email: </label><input type="text" name="email" maxlength="50" id="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"] ?>">
                <?php
                if (isset($_POST["btnContinuar"]) && $error_email) {
                    echo "<span class='error'>* Campo vacío *</span>";
                }
                ?>
            </p>
            <p>
                <button name="btnContinuar">Continuar</button> <button>Volver</button>
            </p>
        </form>
    </body>

    </html>
<?php
} else {
    header("Location:index.php");
    exit();
}
?>