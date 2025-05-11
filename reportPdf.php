<?php
require_once 'vendor/autoload.php';
include_once("entorno.php");

require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

mysqli_set_charset($conexion, "utf8");

$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('Historias');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 10);

$encabezados = ['ID Historia', 'Nombre Usuario', 'Documento', 'Fecha', 'Tipo Incidente', 'Descripción', 'Ubicación', 'Testigos'];

$html = '<h1>Reporte de Historias</h1>';
$html .= '<table border="1" cellspacing="0" cellpadding="4">';
$html .= '<tr>';
foreach ($encabezados as $encabezado) {
    $html .= '<th style="background-color:#f2f2f2;">' . $encabezado . '</th>';
}
$html .= '</tr>';

$query = "
    SELECT h.idHistorias, u.Nombre, u.Documento, h.fecha, h.tipo_incidente, h.descripcion, h.ubicacion, h.testigos
    FROM historias h
    INNER JOIN datos_basicos u ON h.IdDatos_Basicos = u.idDatos_Basicos
    ORDER BY h.fecha DESC
";
$resultado = mysqli_query($conexion, $query);

while ($fila = mysqli_fetch_assoc($resultado)) {
    $html .= '<tr>';
    $html .= '<td>' . $fila['idHistorias'] . '</td>';
    $html .= '<td>' . $fila['Nombre'] . '</td>';
    $html .= '<td>' . $fila['Documento'] . '</td>';
    $html .= '<td>' . $fila['fecha'] . '</td>';
    $html .= '<td>' . $fila['tipo_incidente'] . '</td>';
    $html .= '<td>' . $fila['descripcion'] . '</td>';
    $html .= '<td>' . $fila['ubicacion'] . '</td>';
    $html .= '<td>' . $fila['testigos'] . '</td>';
    $html .= '</tr>';
}
$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');
ob_clean();
$pdf->Output('historias.pdf', 'I');
exit;
?>
