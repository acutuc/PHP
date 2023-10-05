<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .linea {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        table {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 1rem;
        }

        img {
            width: 100px;
            height: 100px;
        }

        .error {
            color: red;
        }
    </style>
    <title>Práctica Rec 2</title>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <form action="index.php" method="post">
        <p>Bienvenido
            <span class="linea">
                <?php echo $datos_usuario_log["usuario"] ?>
            </span> -
            <button type="submit" name="btnSalir" class="linea">Salir</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnConfirmarAgregar"])) {
        $error_nombre = $_POST["nombre"] == "";
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";
        $error_dni = $_POST["dni"] == "" || dni_valido($_POST["dni"]);
        $error_sexo = !isset($_POST["sexo"]);

        $error_formulario = $error_nombre || $error_usuario || $error_clave || $error_dni || $error_sexo;

        //Si no hay error en el formulario, hacemos registro:
        if (!$error_formulario) {
            //Conectamos a la BD:
            try {
                $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            } catch (PDOException $e) {
                die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible conectar. Error: " . $e->getMessage()));
            }

            //Consultamos en la BD si hay algun usuario con el mismo nombre usuario o dni
            try {
                //Consultamos
                $consulta = "SELECT * FROM usuarios WHERE usuario = ? OR dni = ?";
                //Preparamos la sentencia:
                $sentencia = $conexion->prepare($consulta);
                //Pasamos los datos:
                $datos[] = $_POST["usuario"];
                $datos[] = $_POST["dni"];
                //Ejecutamos la sentencia con los datos pasados:
                $sentencia->execute($datos);

                //Si hemos obtenido tuplas, es que el usuario o el dni existían, por lo que no podemos hacer la inserción:
                if ($sentencia->rowCount() > 0) {
                    $error_usuario = true;
                    $mensaje = "Usuario o DNI ya se encuentra registrado en la base de datos.";
                }
            } catch (PDOException $e) {
                die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible conectar. Error: " . $e->getMessage()));
            }
        }
    }

    if (isset($_POST["btnAgregar"]) && !isset($_POST["btnAtras"]) || (isset($_POST["btnConfirmarAgregar"]) && $error_formulario || isset($error_usuario))) {
        echo "<h2>Agregar Nuevo Usuario</h2>";
        ?>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="nombre">Nombre: </label><br>
                <input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST["nombre"]))
                    echo $_POST["nombre"] ?>" placeholder="Nombre...">
                <?php
                if (isset($_POST["btnConfirmarAgregar"]) && $error_nombre) {
                    echo "<span class='error'>*Campo vacío*</span>";
                }
                ?>
            </p>
            <p>
                <label for="usuario">Usuario: </label><br>
                <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"]))
                    echo $_POST["usuario"] ?>" placeholder="Usuario...">
                    <?php
                if (isset($_POST["btnConfirmarAgregar"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>*Campo vacío*</span>";
                    } else {
                        echo "<span class='error'>*Usuario o DNI ya registrado*</span>";
                    }
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña: </label><br>
                <input type="password" name="clave" id="clave" placeholder="Contraseña...">
                <?php
                if (isset($_POST["btnConfirmarAgregar"]) && $error_clave) {
                    echo "<span class='error'>*Campo vacío*</span>";
                }
                ?>
            </p>
            <p>
                <label for="dni">DNI: </label><br>
                <input type="text" name="dni" id="dni" value="<?php if (isset($_POST["dni"]))
                    echo $_POST["dni"] ?>" placeholder="DNI: 11223344Z">
                    <?php
                if (isset($_POST["btnConfirmarAgregar"]) && $error_dni) {
                    if ($_POST["dni"] == "") {
                        echo "<span class='error'>*Campo vacío*</span>";
                    } else {
                        echo "<span class='error'>*Formato inválido*</span>";
                    }
                }
                ?>
            </p>
            <p>
                Sexo <br>
                <input type="radio" name="sexo" value="hombre" id="hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre")
                    echo "checked" ?>> <label for="hombre">Hombre</label><br>
                    <input type="radio" name="sexo" value="mujer" id="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer")
                    echo "checked" ?>> <label for="mujer">Mujer</label>
                    <?php
                if (isset($_POST["btnConfirmarAgregar"]) && $error_sexo) {
                    echo "<br><span class='error'>*Debe seleccionar un sexo*</span>";
                }
                ?>
            </p>
            <p>
                <label for="foto">Incluir mi foto (Máx. 500KB)</label> <input type="file" accept="image/*" name="foto"
                    id="foto">
            </p>
            <p>
                <input type="checkbox" name="suscripcion" id="suscripcion"> <label for="suscripcion">Suscribirme al boletín
                    de novedades</label>
            </p>
            <p>
                <button type="submit" name="btnConfirmarAgregar">Guardar Cambios</button> <button type="submit"
                    name="atras">Atrás</button>
            </p>
        </form>
        <?php
    }

    ?>
    <h3>Listado de los usuarios</h3>
    <p>
        AQUI IRÁ LA PAGINACIÓN
    </p>
    <?php
    echo "<table>";

    echo "<tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th><form action='index.php' method='post'><button type='submit' name='btnAgregar' class='linea'>Usuario+</button></form></th>
        </tr>";

    //Conectamos con la BD:
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible conectar. Error: " . $e->getMessage()));
    }
    //Consultamos para traer a todos los usuarios de la BD que sean tipo normal:
    try {
        $consulta = "SELECT * FROM usuarios WHERE tipo <> 'admin'";

        $sentencia = $conexion->prepare($consulta);

        $sentencia->execute();

        $respuesta = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        //Si hemos obtenido tuplas, es que hay usuarios de tipo normal:
        foreach ($respuesta as $tupla) {
            echo "<tr>
                    <td>" . $tupla["id_usuario"] . "</td>
                    <td><img src='images/" . $tupla["foto"] . "' title='Imagen' alt='Imagen'></td>
                    <td><form action='index.php' method='post'><button type='submit' name='btnVer' class='linea'>" . $tupla["nombre"] . "</button></form></td>
                    <td><form action='index.php' method='post'><button type='submit' name='btnBorrarUsuario' class='linea'>Borrar</button> - <button type='submit' name='btnEditar' class='linea'>Editar</button></form></td>
                </tr>";
        }

        $consulta = null;
        $sentencia = null;
    } catch (PDOException $e) {
        $consulta = null;
        $sentencia = null;
        die(error_page("Práctica Rec 2", "Práctica Rec 2", "Imposible conectar. Error: " . $e->getMessage()));
    }

    echo "</table>";
    ?>
</body>

</html>