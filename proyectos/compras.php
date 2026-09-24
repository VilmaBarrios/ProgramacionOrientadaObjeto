<?php
// 1. Datos ya definidos en el arreglo $compras (Precio SIN IVA)
$compras = [
    ['producto' => 'Camiseta Shrek', 'precio' => 8.00, 'cantidad' => 6], // Aplica descuento por volumen (>=5)
    ['producto' => 'Taza Duloc',     'precio' => 4.50, 'cantidad' => 2],
    ['producto' => 'Llavero Burro',   'precio' => 2.50, 'cantidad' => 1]
];

// Capturar cupón ingresado por el usuario
$cupon = isset($_POST['cupon']) ? trim(strtoupper($_POST['cupon'])) : '';
$mensaje_cupon = '';
$descuento_cupon_porcentaje = 0;
$envio_gratis_cupon = false;

// Validar código de cupón
if ($cupon === 'AHORRO10') {
    $descuento_cupon_porcentaje = 0.10; // 10% de descuento antes de IVA
    $mensaje_cupon = 'Cupón AHORRO10 aplicado: 10% de descuento sobre el subtotal.';
} elseif ($cupon === 'ENVIOGRATIS') {
    $envio_gratis_cupon = true; // Elimina costo de envío
    $mensaje_cupon = 'Cupón ENVIOGRATIS aplicado: Costo de envío $0.00.';
} elseif ($cupon !== '') {
    $mensaje_cupon = 'El cupón ingresado no es válido.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Compras PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f8f9fa; }
        .container { max-width: 650px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #dee2e6; padding: 10px; text-align: left; }
        th { background-color: #e9ecef; }
        .resumen { background: #f1f3f5; padding: 15px; border-radius: 5px; }
        .resumen p { display: flex; justify-content: space-between; margin: 5px 0; }
        .total-final { font-size: 1.2em; font-weight: bold; border-top: 2px solid #343a40; padding-top: 8px; color: #0d6efd; }
        .msg-cupon { font-size: 0.9em; color: #0d6efd; margin-top: 5px; }
        .badge { background: #198754; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.75em; }
    </style>
</head>
<body>

<div class="container">
    <h2>Detalle de la Compra</h2>

    <!-- Tabla HTML de Productos -->
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio Unid.</th>
                <th>Cantidad</th>
                <th>Subtotal Fila</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $subtotal_bruto = 0;

            foreach ($compras as $item): 
                $precio = $item['precio'];
                $cantidad = $item['cantidad'];
                $subtotal_fila = $precio * $cantidad;

                // Descuento por volumen del 5% si cantidad >= 5
                $aplica_descuento_volumen = ($cantidad >= 5);
                if ($aplica_descuento_volumen) {
                    $subtotal_fila -= ($subtotal_fila * 0.05); // Reflejado en el subtotal de esa fila
                }

                $subtotal_bruto += $subtotal_fila;
            ?>
            <tr>
                <td>
                    <?= htmlspecialchars($item['producto']) ?>
                    <?= $aplica_descuento_volumen ? '<span class="badge">-5% Vol.</span>' : '' ?>
                </td>
                <td>$<?= number_format($precio, 2) ?></td>
                <td><?= $cantidad ?></td>
                <td>$<?= number_format($subtotal_fila, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Formulario para Cupón Opcional -->
    <form method="POST" action="">
        <label for="cupon"><strong>Cupón opcional:</strong></label>
        <input type="text" name="cupon" id="cupon" value="<?= htmlspecialchars($cupon) ?>" placeholder="Ej: AHORRO10 o ENVIOGRATIS">
        <button type="submit">Aplicar Cupón</button>
        <?php if ($mensaje_cupon): ?>
            <div class="msg-cupon"><?= $mensaje_cupon ?></div>
        <?php endif; ?>
    </form>

    <br>

    <?php
    // Cálculos Finales
    // 1. Descuento por cupón (10% del subtotal antes de IVA)
    $monto_descuento_cupon = $subtotal_bruto * $descuento_cupon_porcentaje;
    $subtotal_tras_descuentos = $subtotal_bruto - $monto_descuento_cupon;

    // 2. Costo de envío ($2.99 si el subtotal tras descuentos es menor a $25 y no hay cupón ENVIOGRATIS)
    $costo_envio = 0.00;
    if (!$envio_gratis_cupon && $subtotal_tras_descuentos < 25.00) {
        $costo_envio = 2.99;
    }

    // 3. IVA (13%) aplicado a los productos tras descuentos
    $monto_iva = $subtotal_tras_descuentos * 0.13;

    // 4. Total a Pagar
    $total_a_pagar = $subtotal_tras_descuentos + $monto_iva + $costo_envio;
    ?>

    <!-- Resumen de Importes -->
    <div class="resumen">
        <p><span>Subtotal acumulado (con desc. por volumen):</span> <span>$<?= number_format($subtotal_bruto, 2) ?></span></p>
        
        <?php if ($monto_descuento_cupon > 0): ?>
            <p><span>Descuento por Cupón (10%):</span> <span>-$<?= number_format($monto_descuento_cupon, 2) ?></span></p>
        <?php endif; ?>

        <p><span>Subtotal Neto (antes de IVA):</span> <span>$<?= number_format($subtotal_tras_descuentos, 2) ?></span></p>
        <p><span>IVA (13%):</span> <span>+$<?= number_format($monto_iva, 2) ?></span></p>
        <p><span>Costo de Envío:</span> <span>$<?= number_format($costo_envio, 2) ?></span></p>
        
        <p class="total-final"><span>Total a pagar:</span> <span>$<?= number_format($total_a_pagar, 2) ?></span></p>
    </div>
</div>

</body>
</html>