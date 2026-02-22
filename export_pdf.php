<?php
require 'vendor/autoload.php';
use Mpdf\Mpdf; // <-- isso deve estar aqui no topo

if (!isset($_POST['dados'])) {
    die("Nenhum dado recebido.");
}

$dados = json_decode($_POST['dados'], true);

$mpdf = new Mpdf();
$mpdf->WriteHTML('<h3>Relatório - Resultados da Análise</h3>');

$html = '
<table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
<thead>
<tr style="background-color: #eee;">
    <th>Arquivo</th>
    <th>Valor Referência</th>
    <th>Valor Encontrado</th>
    <th>Status</th>
</tr>
</thead>
<tbody>';

foreach ($dados as $linha) {
    $ok = ($linha['status'] === 'Dentro da Tolerância');
    $html .= '<tr' . (!$ok ? ' style="background-color:#f8d7da;"' : '') . '>';
    $html .= "<td>{$linha['arquivo']}</td><td>" . number_format($linha['referencia'], 3, '.', '') . "</td><td>" . number_format($linha['encontrado'], 3, '.', '') . "</td><td>{$linha['status']}</td></tr>";
}

$html .= '</tbody></table>';

$mpdf->WriteHTML($html);
$mpdf->Output("relatorio_analise.pdf", 'I'); // 'I' abre no navegador, 'D' força download
