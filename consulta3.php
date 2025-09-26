<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Consulta 3 - Promedio final con género</title>
    <link rel="stylesheet" href="consulta3.css" />
</head>
<body>
    <h2>Consulta 3 - Promedio Final con Género</h2>

    <div class="container">
        <?php
        $genero = "";
        $notas = [];
        $promedioFinal = null;
        $nuevoPromedio = null;
        $error = "";

        // Función para validar solo un decimal
        function tieneUnDecimal($num) {
            return preg_match('/^\d+(\.\d)?$/', $num);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $genero = $_POST["genero"] ?? "";
            $notas_raw = [$_POST["nota1"] ?? "", $_POST["nota2"] ?? "", $_POST["nota3"] ?? "", $_POST["nota4"] ?? ""];
            $notas = [];

            foreach ($notas_raw as $nota) {
                // Validar que sea número con máximo 1 decimal y esté entre 0 y 20
                if (!is_numeric($nota) || !tieneUnDecimal($nota) || floatval($nota) < 0 || floatval($nota) > 20) {
                    $error = "Ingrese notas válidas entre 0 y 20 con hasta un decimal.";
                    break;
                } else {
                    $notas[] = floatval($nota);
                }
            }

            if (!$error) {
                if (!in_array($genero, ['M', 'F'])) {
                    $error = "Seleccione un género válido.";
                } else {
                    $promedioFinal = array_sum($notas) / 4;
                    // Incremento decimal: 3 para masculino, 5 para femenino (puedes cambiar estos valores si quieres)
                    $incremento = ($genero == "M") ? 3.0 : 5.0;
                    $nuevoPromedio = $promedioFinal + $incremento;
                    if ($nuevoPromedio > 20) $nuevoPromedio = 20;
                }
            }
        }
        ?>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <label for="genero">Género:</label>
            <select id="genero" name="genero" required>
                <option value="" disabled <?= $genero == "" ? "selected" : "" ?>>Seleccione</option>
                <option value="M" <?= $genero == "M" ? "selected" : "" ?>>Masculino</option>
                <option value="F" <?= $genero == "F" ? "selected" : "" ?>>Femenino</option>
            </select>

            <label for="nota1">Nota 1:</label>
            <input type="number" id="nota1" name="nota1" min="0" max="20" step="0.1" value="<?= htmlspecialchars($notas[0] ?? "") ?>" required />

            <label for="nota2">Nota 2:</label>
            <input type="number" id="nota2" name="nota2" min="0" max="20" step="0.1" value="<?= htmlspecialchars($notas[1] ?? "") ?>" required />

            <label for="nota3">Nota 3:</label>
            <input type="number" id="nota3" name="nota3" min="0" max="20" step="0.1" value="<?= htmlspecialchars($notas[2] ?? "") ?>" required />

            <label for="nota4">Nota 4:</label>
            <input type="number" id="nota4" name="nota4" min="0" max="20" step="0.1" value="<?= htmlspecialchars($notas[3] ?? "") ?>" required />

            <button type="submit">Calcular Promedio</button>
        </form>

        <?php if ($nuevoPromedio !== null && !$error): ?>
            <div class="resultado">
                <p>Promedio Final Original: <strong><?= number_format($promedioFinal, 2) ?></strong></p>
                <p>Nuevo Promedio Final (con bonificación por género): <strong><?= number_format($nuevoPromedio, 2) ?></strong></p>
            </div>
        <?php endif; ?>

        <button onclick="window.location.href='index.html'">Volver al inicio</button>
    </div>
</body>
</html>
