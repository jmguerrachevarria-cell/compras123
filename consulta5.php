<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Consulta 5 - Derecho de examen con descuento</title>
    <link rel="stylesheet" href="consulta5.css" />
</head>
<body>
    <h2>Consulta 5 - Importe a pagar por derecho de examen</h2>
    <div class="container">
        <?php
        $procedencia = "";
        $importeBase = 285;
        $importeFinal = null;
        $descuento = 0;
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $procedencia = $_POST["procedencia"] ?? "";

            if (!in_array($procedencia, ['NACIONAL', 'PARTICULAR'])) {
                $error = "Seleccione una procedencia válida.";
            } else {
                if ($procedencia == 'NACIONAL') {
                    $descuento = 0.10 * $importeBase;
                } elseif ($procedencia == 'PARTICULAR') {
                    $descuento = 0.03 * $importeBase;
                }
                $importeFinal = $importeBase - $descuento;
            }
        }
        ?>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <label for="procedencia">Procedencia del colegio:</label>
            <select id="procedencia" name="procedencia" required>
                <option value="" disabled <?= $procedencia == "" ? "selected" : "" ?>>Seleccione</option>
                <option value="NACIONAL" <?= $procedencia == "NACIONAL" ? "selected" : "" ?>>Colegio Nacional</option>
                <option value="PARTICULAR" <?= $procedencia == "PARTICULAR" ? "selected" : "" ?>>Colegio Particular</option>
            </select>

            <button type="submit">Calcular importe</button>
        </form>

        <?php if ($importeFinal !== null && !$error): ?>
            <div class="resultado">
                <p>Importe base: <strong><?= number_format($importeBase, 2) ?></strong></p>
                <p>Descuento aplicado: <strong><?= number_format($descuento, 2) ?></strong></p>
                <p>Importe final a pagar: <strong><?= number_format($importeFinal, 2) ?></strong></p>
            </div>
        <?php endif; ?>

        <button onclick="window.location.href='index.html'">Volver al inicio</button>
    </div>
</body>
</html>
