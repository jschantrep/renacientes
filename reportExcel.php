<?php
require 'vendor/autoload.php';
include("entorno.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$encabezados = ['ID Historia', 'Nombre Usuario', 'Documento', 'Fecha', 'Tipo Incidente', 'Descripción', 'Ubicación', 'Testigos'];
$sheet->fromArray($encabezados, NULL, 'A1');

$query = "
    SELECT h.idHistorias, u.Nombre, u.Documento, h.fecha, h.tipo_incidente, h.descripcion, h.ubicacion, h.testigos
    FROM historias h
    INNER JOIN datos_basicos u ON h.IdDatos_Basicos = u.idDatos_Basicos
    ORDER BY h.fecha DESC
";
$resultado = mysqli_query($conexion, $query);

$filaExcel = 2;
while ($fila = mysqli_fetch_assoc($resultado)) {
    $nombre = utf8_encode($fila['Nombre']);
    $documento = utf8_encode($fila['Documento']);
    $fecha = utf8_encode($fila['fecha']);
    $tipo_incidente = utf8_encode($fila['tipo_incidente']);
    $descripcion = utf8_encode($fila['descripcion']);
    $ubicacion = utf8_encode($fila['ubicacion']);
    $testigos = utf8_encode($fila['testigos']);

    $sheet->setCellValue("A$filaExcel", $fila['idHistorias']);
    $sheet->setCellValue("B$filaExcel", $nombre);
    $sheet->setCellValue("C$filaExcel", $documento);
    
    $sheet->setCellValue("D$filaExcel", $fecha);
    $sheet->getStyle("D$filaExcel")->getNumberFormat()->setFormatCode('yyyy-mm-dd'); // Formato de fecha

    $sheet->setCellValue("E$filaExcel", $tipo_incidente);
    $sheet->setCellValue("F$filaExcel", $descripcion);
    $sheet->setCellValue("G$filaExcel", $ubicacion);
    $sheet->setCellValue("H$filaExcel", $testigos);

    $filaExcel++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="historias.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
