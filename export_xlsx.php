<?php
session_start();
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!isset($_POST['dados'])) {
    die("Nenhum dado recebido.");
}

$dados = json_decode($_POST['dados'], true);
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Resultados");

$sheet->fromArray(['Arquivo', 'Valor Referência', 'Valor Encontrado', 'Status'], null, 'A1');

$row = 2;
foreach ($dados as $linha) {
    $sheet->fromArray([
        $linha['arquivo'],
        is_numeric($linha['referencia']) ? number_format($linha['referencia'], 3, '.', '') : '-',
        number_format($linha['encontrado'], 3, '.', ''),
        $linha['status']
    ], null, "A$row");

    if ($linha['status'] !== 'Dentro da Tolerância') {
        $sheet->getStyle("A$row:D$row")->getFill()->setFillType('solid')->getStartColor()->setRGB('F8D7DA');
    }

    $row++;
}

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="relatorio_analise.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
