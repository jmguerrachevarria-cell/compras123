<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Consulta 4 - Pago trabajador con retención</title>
    <link rel="stylesheet" href="consulta4.css" />
</head>
<body>
    <h2>Consulta 4 - Cálculo de sueldo con retención</h2>
    <div class="container">
        <?php
        $horas = "";
        $pagoHora = "";
        $sueldoBruto = null;
        $retencion = null;
        $sueldoNeto = null;
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $horas = $_POST["horas"] ?? "";
            $pagoHora = $_POST["pagoHora"] ?? "";

            if (!is_numeric($horas) || $horas < 0) {
                $error = "Ingrese un número válido de horas trabajadas.";
            } elseif (!is_numeric($pagoHora) || $pagoHora < 0) {
                $error = "Ingrese un pago por hora válido.";
            } else {
                $sueldoBruto = $horas * $pagoHora;
                if ($sueldoBruto > 1500) {
                    $retencion = $sueldoBruto * 0.10;
                } else {
                    $retencion = 0;
                }
                $sueldoNeto = $sueldoBruto - $retencion;
            }
        }
        ?>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <label for="horas">Horas trabajadas:</label>
            <input type="number" id="horas" name="horas" min="0" step="1" value="<?= htmlspecialchars($horas) ?>" required />

            <label for="pagoHora">Pago por hora:</label>
            <input type="number" id="pagoHora" name="pagoHora" min="0" step="0.01" value="<?= htmlspecialchars($pagoHora) ?>" required />

            <button type="submit">Calcular sueldo</button>
        </form>

        <?php if ($sueldoBruto !== null && !$error): ?>
            <div class="resultado">
                <p>Sueldo bruto: <strong><?= number_format($sueldoBruto, 2) ?></strong></p>
                <p>Retención (10% si aplica): <strong><?= number_format($retencion, 2) ?></strong></p>
                <p>Sueldo neto: <strong><?= number_format($sueldoNeto, 2) ?></strong></p>
            </div>
        <?php endif; ?>

        <button onclick="window.location.href='index.html'">Volver al inicio</button>
    </div>
</body>
</html>
