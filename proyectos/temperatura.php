<?php
$mensaje_error = '';
$resultado = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = $_POST['temperatura'] ?? '';
    $tipo = $_POST['tipo'] ?? '';

    // Validación estricta con PHP (número decimal/flotante)
    if ($valor === '' || !is_numeric($valor)) {
        $mensaje_error = "Error: Por favor, ingrese un número decimal válido.";
    } else {
        $num = (float)$valor;
        if ($tipo === 'c_to_f') {
            $calc = ($num * 9 / 5) + 32;
            $resultado = "$num °C equivale a " . number_format($calc, 2) . " °F";
        } elseif ($tipo === 'f_to_c') {
            $calc = ($num - 32) * 5 / 9;
            $resultado = "$num °F equivale a " . number_format($calc, 2) . " °C";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Conversor de Temperaturas</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .box { border: 1px solid #aaa; padding: 20px; width: 320px; border-radius: 6px; }
        .err { color: red; margin-top: 10px; }
        .res { color: green; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>

    <div class="box">
        <h2>Conversor de Temperatura</h2>
        <form method="POST">
            <label>Valor de temperatura:</label><br>
            <input type="text" name="temperatura" value="<?= htmlspecialchars($_POST['temperatura'] ?? '') ?>"><br><br>

            <label>Tipo de Conversión:</label><br>
            <select name="tipo">
                <option value="c_to_f" <?= (($_POST['tipo'] ?? '') === 'c_to_f') ? 'selected' : '' ?>>Celsius a Fahrenheit</option>
                <option value="f_to_c" <?= (($_POST['tipo'] ?? '') === 'f_to_c') ? 'selected' : '' ?>>Fahrenheit a Celsius</option>
            </select><br><br>

            <button type="submit">Calcular</button>
        </form>

        <?php if ($mensaje_error): ?>
            <p class="err"><?= $mensaje_error ?></p>
        <?php endif; ?>

        <?php if ($resultado): ?>
            <p class="res"><?= $resultado ?></p>
        <?php endif; ?>
    </div>

</body>
</html>