<?php
$mostrar = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente  = htmlspecialchars($_POST['cliente'] ?? '');
    $producto = $_POST['producto'] ?? '';
    $cantidad = intval($_POST['cantidad'] ?? 1);
    $extras   = $_POST['extras'] ?? []; // Arreglo enviado desde checkboxes

    // Precios de productos principales
    $precioUnitario = match($producto) {
        'Hamburguesa' => 5.50,
        'Pizza'       => 8.00,
        'Tacos'       => 4.50,
        default       => 0.00
    };

    $subtotalCombo = $precioUnitario * $cantidad;

    // Sumar extras seleccionados
    $costoExtras = 0;
    $listaExtras = [];
    foreach ($extras as $extra) {
        $costo = match($extra) {
            'Papas'   => 1.50,
            'Bebida'  => 1.25,
            'Postre'  => 2.00,
            default   => 0.00
        };
        $costoExtras += ($costo * $cantidad);
        $listaExtras[] = "$extra ($" . number_format($costo, 2) . " c/u)";
    }

    $subtotalBruto = $subtotalCombo + $costoExtras;
    $descuento = ($cantidad >= 3) ? ($subtotalBruto * 0.10) : 0;
    $totalPagar = $subtotalBruto - $descuento;

    $mostrar = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Pedidos</title>
    <style>
        table { border-collapse: collapse; width: 70%; margin-top: 15px; }
        th, td { border: 1px solid #aaa; padding: 8px; text-align: center; }
        th { background-color: #d9534f; color: white; }
    </style>
</head>
<body>

    <h2>Restaurante TPI - Orden de Pedido</h2>

    <?php if (!$mostrar): ?>
        <form action="prueba2.php" method="POST">
            <label>Nombre del Cliente:</label><br>
            <input type="text" name="cliente" required><br><br>

            <label>Plato Principal:</label><br>
            <select name="producto" required>
                <option value="Hamburguesa">Hamburguesa ($5.50)</option>
                <option value="Pizza">Pizza ($8.00)</option>
                <option value="Tacos">Tacos ($4.50)</option>
            </select><br><br>

            <label>Cantidad:</label><br>
            <input type="number" name="cantidad" min="1" value="1" required><br><br>

            <label>Extras por combo:</label><br>
            <input type="checkbox" name="extras[]" value="Papas"> Papas ($1.50)<br>
            <input type="checkbox" name="extras[]" value="Bebida"> Bebida ($1.25)<br>
            <input type="checkbox" name="extras[]" value="Postre"> Postre ($2.00)<br><br>

            <button type="submit">Generar Comprobante</button>
        </form>

    <?php else: ?>
        <h3>Comprobante de Pago</h3>
        <p><strong>Cliente:</strong> <?php echo $cliente; ?></p>

        <table>
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $producto; ?></td>
                    <td><?php echo $cantidad; ?></td>
                    <td>$<?php echo number_format($precioUnitario, 2); ?></td>
                    <td>$<?php echo number_format($subtotalCombo, 2); ?></td>
                </tr>
                <?php if (!empty($listaExtras)): ?>
                    <tr>
                        <td>Extras: <?php echo implode(", ", $listaExtras); ?></td>
                        <td><?php echo $cantidad; ?></td>
                        <td>--</td>
                        <td>$<?php echo number_format($costoExtras, 2); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <br>
        <p>Subtotal Bruto: $<?php echo number_format($subtotalBruto, 2); ?></p>
        <p>Descuento (10% por 3+ combos): -$<?php echo number_format($descuento, 2); ?></p>
        <p><strong>Total Final a Pagar: $<?php echo number_format($totalPagar, 2); ?></strong></p>

        <br>
        <a href="prueba2.php">Nuevo Pedido</a>
    <?php endif; ?>

</body>
</html>