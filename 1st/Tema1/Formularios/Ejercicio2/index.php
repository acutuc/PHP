<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 2</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>Ejercicio 2</h1>
    <p>
        Realizar un formulario de pedido de productos que conste de una lista desplegable con 4 productos: Coca Cola (1 €), Pepsi Cola (0.80€), Fanta Narajna (0.90€) y Trina Manzana (1.20€).
    </p>
    <p>
        Colocaremos también una caja para elegir la cantidad de botellas de la bebida escogida. Un botón de tipo Submit valorará los datos en una página PHP, escribiendo una frase similar a esta:
    </p>
    <p>
        <em>"Has pedido 3 unidades de Coca Cola"<br />
            "Precio total: 3 €"
        </em>
    </p>
    <p>
        Este ejercicio puede realizarse usando una estructura if o switch. Utilizar el método POST.
    </p>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <select id="productos" name="productos">
            <option value="0">Coca Cola (1€)</option>
            <option value="1">Pepsi Cola (0.80€)</option>
            <option value="2">Fanta Naranja (0.90€)</option>
            <option value="3">Trina Manzana (1.20€)</option>
        </select>
        <p>
            <label for="cantidad">Cant.: </label>
            <select id="cantidad" name="cantidad">
                <option value=0>0</option>
                <option value=1>1</option>
                <option value=2>2</option>
                <option value=3>3</option>
                <option value=4>4</option>
                <option value=5>5</option>
            </select>
        </p>
        <button type="submit" name="btnEnviar">Enviar</button>
    </form>
    <?php
    $precios = array("Coca Cola" => 1, "Pepsi Cola" => 0.8, "Fanta Naranja" => 0.9, "Trina Manzana" => 1.20);
    if (isset($_POST["btnEnviar"])) {
        echo "<h1>Respuestas</h1>";
        switch ($_POST["productos"]) {
            case 0:
                echo "<span>Has pedido <strong>" . $_POST["cantidad"] . "</strong> unidades de Coca Cola.</span><br/>";
                echo "<span>Precio total: <strong>" . $precios["Coca Cola"] * $_POST["cantidad"] . "€</strong></span>";
                break;
            case 1:
                echo "<span>Has pedido <strong>" . $_POST["cantidad"] . "</strong> unidades de Pepsi Cola.</span><br/>";
                echo "<span>Precio total: <strong>" . $precios["Pepsi Cola"] * $_POST["cantidad"] . "€</strong></span>";
                break;
            case 2:
                echo "<span>Has pedido <strong>" . $_POST["cantidad"] . "</strong> unidades de Fanta Naranja.</span><br/>";
                echo "<span>Precio total: <strong>" . $precios["Fanta Naranja"] * $_POST["cantidad"] . "€</strong></span>";
                break;
            case 3:
                echo "<span>Has pedido <strong>" . $_POST["cantidad"] . "</strong> unidades de Trina Manzana.</span><br/>";
                echo "<span>Precio total: <strong>" . $precios["Trina Manzana"] * $_POST["cantidad"] . "€</strong></span>";
                break;
        }
    }
    ?>
</body>

</html>