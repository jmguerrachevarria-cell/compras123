<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Consulta de pago</title>
    <link rel="stylesheet" href="consulta1.css" />
</head>
<body>
    <div class="container">
        <h1>Consulta de Pago</h1>

        <?php
        $sueldo = $categoria = $Nsueldo = null;
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validar y sanitizar inputs
            $sueldo = filter_input(INPUT_POST, "sueldo", FILTER_VALIDATE_FLOAT);
            $categoria = filter_input(INPUT_POST, "categoria", FILTER_VALIDATE_INT);

            if ($sueldo === false || $sueldo === null || $sueldo <= 0) {
                $error = "Por favor ingresa un sueldo válido mayor a 0.";
            } elseif (!in_array($categoria, [1, 2, 3, 4])) {
                $error = "Selecciona una categoría válida.";
            } else {
                // Cálculo del nuevo sueldo
                switch ($categoria) {
                    case 1:
                        $Nsueldo = $sueldo * 1.3;
                        break;
                    case 2:
                        $Nsueldo = $sueldo * 1.2;
                        break;
                    case 3:
                        $Nsueldo = $sueldo * 1.15;
                        break;
                    default:
                        $Nsueldo = $sueldo;
                }
            }
        }
        ?>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" novalidate>
            <label for="sueldo">Sueldo Base:</label>
            <input
                type="number"
                id="sueldo"
                name="sueldo"
                step="0.01"
                min="0"
                required
                value="<?= htmlspecialchars($sueldo ?? '') ?>"
                placeholder="Ingrese el sueldo base"
            />

            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria" required>
                <option value="" disabled <?= $categoria === null ? 'selected' : '' ?>>Seleccione categoría</option>
                <option value="1" <?= ($categoria == 1) ? 'selected' : '' ?>>Categoría 1</option>
                <option value="2" <?= ($categoria == 2) ? 'selected' : '' ?>>Categoría 2</option>
                <option value="3" <?= ($categoria == 3) ? 'selected' : '' ?>>Categoría 3</option>
                <option value="4" <?= ($categoria == 4) ? 'selected' : '' ?>>Categoría 4 (Sin aumento)</option>
            </select>

            <button type="submit">Calcular</button>
        </form>

        <?php if ($Nsueldo !== null && !$error): ?>
            <div class="resultado">
                <p class="result">Sueldo ingresado: <?= number_format($sueldo, 2) ?></p>
                <p class="result">Categoría seleccionada: <?= $categoria ?></p>
                <hr />
                <p class="result"><strong>Nuevo sueldo calculado: <?= number_format($Nsueldo, 2) ?></strong></p>
            </div>
        <?php endif; ?>

        <button onclick="window.location.href='index.html'">Volver al inicio</button>
    </div>
</body>
</html>
