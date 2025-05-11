<?php
include_once("entorno.php");

// Consulta 1: Total de historias
$totalResult = $conexion->query("SELECT COUNT(*) AS total FROM historias");
$totalRow = $totalResult->fetch_assoc();
$totalHistorias = $totalRow['total'];

// Consulta 2: Historias por tipo de incidente
$tiposResult = $conexion->query("SELECT tipo_incidente, COUNT(*) AS cantidad FROM historias GROUP BY tipo_incidente");
$tiposData = [];
while ($row = $tiposResult->fetch_assoc()) {
    $tiposData[] = $row;
}

// Consulta 3: Historias por mes
$mesesResult = $conexion->query("
    SELECT DATE_FORMAT(fecha, '%Y-%m') AS mes, COUNT(*) AS cantidad 
    FROM historias 
    GROUP BY mes 
    ORDER BY mes DESC
");
$mesesData = [];
while ($row = $mesesResult->fetch_assoc()) {
    $mesesData[] = $row;
}

// Consulta 4: Ubicaciones más frecuentes
$ubicacionesResult = $conexion->query("
    SELECT ubicacion, COUNT(*) AS cantidad 
    FROM historias 
    GROUP BY ubicacion 
    ORDER BY cantidad DESC 
    LIMIT 5
");
$ubicacionesData = [];
while ($row = $ubicacionesResult->fetch_assoc()) {
    $ubicacionesData[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Estadísticas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f7f7f7; }
        h1 { color: #333; }
        .chart-container { width: 80%; margin: 40px auto; }
    </style>
</head>
<body>

    <h1>Dashboard de Estadísticas</h1>
    <p><strong>Total de historias registradas:</strong> <?= $totalHistorias ?></p>

    <div class="chart-container">
        <h2>Incidentes por Tipo</h2>
        <canvas id="tipoChart"></canvas>
    </div>

    <div class="chart-container">
        <h2>Historias por Mes</h2>
        <canvas id="mesChart"></canvas>
    </div>

    <div class="chart-container">
        <h2>Ubicaciones más Frecuentes</h2>
        <canvas id="ubicacionChart"></canvas>
    </div>

    <script>
        const tipoLabels = <?= json_encode(array_column($tiposData, 'tipo_incidente')) ?>;
        const tipoCounts = <?= json_encode(array_column($tiposData, 'cantidad')) ?>;

        new Chart(document.getElementById('tipoChart'), {
            type: 'bar',
            data: {
                labels: tipoLabels,
                datasets: [{
                    label: 'Cantidad',
                    data: tipoCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            }
        });

        const mesLabels = <?= json_encode(array_column($mesesData, 'mes')) ?>;
        const mesCounts = <?= json_encode(array_column($mesesData, 'cantidad')) ?>;

        new Chart(document.getElementById('mesChart'), {
            type: 'line',
            data: {
                labels: mesLabels,
                datasets: [{
                    label: 'Cantidad',
                    data: mesCounts,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    fill: true
                }]
            }
        });

        const ubicacionLabels = <?= json_encode(array_column($ubicacionesData, 'ubicacion')) ?>;
        const ubicacionCounts = <?= json_encode(array_column($ubicacionesData, 'cantidad')) ?>;

        new Chart(document.getElementById('ubicacionChart'), {
            type: 'pie',
            data: {
                labels: ubicacionLabels,
                datasets: [{
                    label: 'Cantidad',
                    data: ubicacionCounts,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#8AFF56', '#AA56FF'
                    ]
                }]
            }
        });
    </script>
</body>
</html>
