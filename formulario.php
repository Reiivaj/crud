<?php

$tipo = $pureza = $porcentaje = $peso = $marca = $precio_de_compra = $precio_de_venta = '';
$error_tipo = $error_pureza = $error_porcentaje = $error_peso = $error_marca = $error_precio_de_compra = $error_precio_de_venta = False;

$errores = '';
$mensaje_ok = '';

if(!empty($_POST['paso'])) {

    if (empty($_POST['tipo'])) {
        $errores .= "<span class=\"error\">¡ERROR! No se ha enviado ningún tipo de jamón.<br /></span>";
        $error_tipo = True;
    }

    if (empty($_POST['pureza'])) {
        $errores .= "<span class=\"error\">¡ERROR! No se ha enviado la pureza del jamón.<br /></span>";
        $error_pureza = True;
    }

    if (empty($_POST['porcentaje']) || !is_numeric($_POST['porcentaje']) || $_POST['porcentaje'] < 0 || $_POST['porcentaje'] > 100) {
        $errores .= "<span class=\"error\">¡ERROR! El porcentaje debe ser un número entre 0 y 100.<br /></span>";
        $error_porcentaje = True;
    }

    if (empty($_POST['peso']) || !is_numeric($_POST['peso'])) {
        $errores .= "<span class=\"error\">¡ERROR! El peso debe ser un número.<br /></span>";
        $error_peso = True;
    }

    if (empty($_POST['marca'])) {
        $errores .= "<span class=\"error\">¡ERROR! No se ha enviado la marca.<br /></span>";
        $error_marca = True;
    }

    if (empty($_POST['precio_de_compra']) || !is_numeric($_POST['precio_de_compra'])) {
        $errores .= "<span class=\"error\">¡ERROR! El precio de compra debe ser un número válido.<br /></span>";
        $error_precio_de_compra = True;
    }

    if (empty($_POST['precio_de_venta']) || !is_numeric($_POST['precio_de_venta'])) {
        $errores .= "<span class=\"error\">¡ERROR! El precio de venta debe ser un número válido.<br /></span>";
        $error_precio_de_venta = True;
    }

    if (empty($errores)) {
        $mensaje_ok = "<span class=\"ok\">Los datos se han enviado correctamente.</span>";
    }

    $tipo               = $_POST['tipo'];
    $pureza             = $_POST['pureza'];
    $porcentaje         = $_POST['porcentaje'];
    $peso               = $_POST['peso'];
    $marca              = $_POST['marca'];
    $precio_de_compra   = $_POST['precio_de_compra'];
    $precio_de_venta    = $_POST['precio_de_venta'];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Jamones</title>
    <style type="text/css">
        .error {
            color: #ff0000;
            font-weight: bold;
        }

        .ok {
            color: #fff;
            background: #00ff00;
            font-weight: bold;
            padding: 5px;
        }

        .campo {
            clear: both;
            padding: 5px 0;
        }

        .campo > label, .campo > input {
            float: left;
        }

        .campo > label {
            width: 150px;
            display: block;
        }

        .campo > input {
            width: 300px;
        }

        .error_tipo, .error_pureza, .error_porcentaje, .error_peso, .error_marca, .error_precio_de_compra, .error_precio_de_venta {
            color: #ff0000;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form action="formulario_jamones.php" method="POST">
        <input type="hidden" name="paso" value="1" />
        <?php echo $errores; ?>

        <div class="campo">
            <label class="<?php echo $error_tipo ? 'error_tipo' : ''; ?>" for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" value="<?php echo $tipo; ?>" placeholder="Ej. Paletilla, Jamón..." />
        </div>

        <div class="campo">
            <label class="<?php echo $error_pureza ? 'error_pureza' : ''; ?>" for="pureza">Pureza:</label>
            <input type="text" id="pureza" name="pureza" value="<?php echo $pureza; ?>" placeholder="Ej. Ibérico, Serrano..." />
        </div>

        <div class="campo">
            <label class="<?php echo $error_porcentaje ? 'error_porcentaje' : ''; ?>" for="porcentaje">Porcentaje:</label>
            <input type="number" id="porcentaje" name="porcentaje" value="<?php echo $porcentaje; ?>" placeholder="Ej. 75" />
        </div>

        <div class="campo">
            <label class="<?php echo $error_peso ? 'error_peso' : ''; ?>" for="peso">Peso (kg):</label>
            <input type="number" step="0.001" id="peso" name="peso" value="<?php echo $peso; ?>" placeholder="Ej. 5.5" />
        </div>

        <div class="campo">
            <label class="<?php echo $error_marca ? 'error_marca' : ''; ?>" for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" value="<?php echo $marca; ?>" placeholder="Marca del jamón..." />
        </div>

        <div class="campo">
            <label class="<?php echo $error_precio_de_compra ? 'error_precio_de_compra' : ''; ?>" for="precio_de_compra">Precio de Compra:</label>
            <input type="number" step="0.01" id="precio_de_compra" name="precio_de_compra" value="<?php echo $precio_de_compra; ?>" placeholder="Ej. 50.00" />
        </div>

        <div class="campo">
            <label class="<?php echo $error_precio_de_venta ? 'error_precio_de_venta' : ''; ?>" for="precio_de_venta">Precio de Venta:</label>
            <input type="number" step="0.01" id="precio_de_venta" name="precio_de_venta" value="<?php echo $precio_de_venta; ?>" placeholder="Ej. 80.00" />
        </div>

        <div class="campo">
            <input type="submit" value="Enviar">
        </div>
    </form>

    <?php echo $mensaje_ok; ?>
</body>
</html>