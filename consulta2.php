<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Consulta de llamadas internacionales</title>
    <link rel="stylesheet" href="consulta1.css" /> <!-- Usamos el mismo CSS para coherencia -->
</head>
<body>
    <div class="container">
        <h1>Costo de Llamadas Internacionales</h1>

        <?php
        // Array con claves, zonas y precios por minuto
        $zonas = [
            12 => ['zona' => 'América del Norte', 'precio' => 2.1],
            15 => ['zona' => 'América Central', 'precio' => 2.6],
            18 => ['zona' => 'América del Sur', 'precio' => 4.5],
            19 => ['zona' => 'Europa', 'precio' => 3.6],
            23 => ['zona' => 'Asia', 'precio' => 6.5],
            25 => ['zona' => 'África', 'precio' => 7.8],
            29 => ['zona' => 'Oceanía', 'precio' => 3.9],
        ];

        $minutos = null;
        $clave = null;
        $costo = null;
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $minutos = filter_input(INPUT_POST, "minutos", FILTER_VALIDATE_INT);
            $clave = filter_input(INPUT_POST, "clave", FILTER_VALIDATE_INT);

            if ($minutos === false || $minutos === null || $minutos <= 0) {
                $error = "Por favor ingresa un número válido de minutos (mayor a 0).";
            } elseif (!array_key_exists($clave, $zonas)) {
                $error = "Selecciona una clave de zona válida.";
            } else {
                $precio = $zonas[$clave]['precio'];
                $costo = $minutos * $precio;
            }
        }
        ?>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" novalidate>
            <label for="minutos">Número de minutos hablados:</label>
            <input
                type="number"
                id="minutos"
                name="minutos"
                min="1"
                required
                value="<?= htmlspecialchars($minutos ?? '') ?>"
                placeholder="Ingrese minutos"
            />

            <label for="clave">Seleccione la zona geográfica:</label>
            <select id="clave" name="clave" required>
                <option value="" disabled <?= $clave === null ? 'selected' : '' ?>>-- Seleccione una zona --</option>
                <?php foreach ($zonas as $key => $zona): ?>
                    <option value="<?= $key ?>" <?= ($clave == $key) ? 'selected' : '' ?>>
                        <?= $key . " - " . $zona['zona'] . " (S/ " . number_format($zona['precio'], 2) . " / min)" ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Calcular costo</button>
        </form>

        <?php if ($costo !== null && !$error): ?>
            <div class="resultado">
                <p class="result">Minutos hablados: <?= $minutos ?></p>
                <p class="result">Zona: <?= $zonas[$clave]['zona'] ?></p>
                <hr />
                <p class="result"><strong>Costo total de la llamada: S/ <?= number_format($costo, 2) ?></strong></p>
            </div>
        <?php endif; ?>

        <button onclick="window.location.href='index.html'">Volver al inicio</button>
    </div>
</body>
</html>
