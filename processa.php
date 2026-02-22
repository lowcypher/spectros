<?php
session_start(); // Para armazenar os dados temporariamente

require 'vendor/autoload.php'; // Para exportações futuras

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $referencias = array_map('floatval', explode(',', $_POST['referencias']));
    $tolerancia = floatval($_POST['tolerancia']);
    $uploadDir = __DIR__ . '/uploads/';
    $zipPath = $uploadDir . uniqid('pacote_', true) . '.zip';

    if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

    if (move_uploaded_file($_FILES['zipfile']['tmp_name'], $zipPath)) {
        $extractPath = $uploadDir . uniqid('extraido_', true);
        mkdir($extractPath);

        $zip = new ZipArchive();
        if ($zip->open($zipPath) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();
        } else {
            die("Erro ao abrir o ZIP.");
        }

        $dados = [];

        $dir = new RecursiveDirectoryIterator($extractPath);
        $iterator = new RecursiveIteratorIterator($dir);

        foreach ($iterator as $file) {
            if ($file->isFile() && strtolower($file->getExtension()) === 'txt') {
                $filename = $file->getFilename();
                $lines = file($file->getPathname(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                foreach ($lines as $line) {
                    $cols = preg_split('/\s+/', trim($line));
                    if (!isset($cols[0]) || !is_numeric($cols[0])) continue;

                    $valor = floatval($cols[0]);
                    $dentro = false;

                    foreach ($referencias as $ref) {
                        if ($valor >= ($ref - $tolerancia) && $valor <= ($ref + $tolerancia)) {
                            $dados[] = [$filename, $ref, $valor, true];
                            $dentro = true;
                            break;
                        }
                    }

                    if (!$dentro) {
                        $dados[] = [$filename, '-', $valor, false]; // fora da tolerância
                    }
                }
            }
        }

        // Salva na sessão para exportações
        $_SESSION['dados_exportacao'] = $dados;

        // HTML com DataTables + Bootstrap
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Resultados</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
            <style>
                .fora-tolerancia { background-color: #f8d7da !important; }
                /*body { background-color: #f2f2f2; }*/
            </style>
                <style>
body {
  background-image: url('wallp.png');
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
}
</style>
        </head>
        <body>
        <div class="container mt-5">
            <h3 class="text-center mb-4">Resultados da Análise</h3>
            <div class="mb-3 text-end">
            <form id="export-form" method="post" target="_blank">
                <input type="hidden" name="dados" id="dados-exportacao">
                <button type="submit" formaction="export_pdf.php" class="btn btn-danger btn-sm me-1">Exportar PDF</button>
                <button type="submit" formaction="export_xlsx.php" class="btn btn-success btn-sm me-1">Exportar Excel</button>
                <a href="index.php" class="btn btn-secondary btn-sm">Voltar</a>
            </form>

            </div>
            <div class="table-responsive">
                <table id="tabela" class="table table-striped table-bordered">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Arquivo</th>
                            <th>Valor Referência</th>
                            <th>Valor Encontrado</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($dados as [$arquivo, $ref, $valor, $ok]): ?>
                        <tr class="<?= !$ok ? 'fora-tolerancia' : '' ?>">
                            <td><?= htmlspecialchars($arquivo) ?></td>
                            <td><?= $ref === '-' ? '-' : number_format($ref, 3, '.', '') ?></td>
                            <td><?= number_format($valor, 3, '.', '') ?></td>
                            <td><?= $ok ? 'Dentro da Tolerância' : 'Fora da Tolerância' ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script>
$(document).ready(function () {
    const table = $('#tabela').DataTable({
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json" }
    });

    $('#export-form').on('submit', function () {
        let data = [];

        // Percorre as linhas visíveis na tabela
        table.rows({ search: 'applied' }).every(function () {
            let d = this.data();
            data.push({
                arquivo: $(d[0]).text() || d[0],
                referencia: d[1],
                encontrado: d[2],
                status: d[3]
            });
        });

        $('#dados-exportacao').val(JSON.stringify(data));
    });
});
</script>

        </body>
        </html>
        <?php
    } else {
        echo "Erro ao fazer upload.";
    }
}
?>
<?php include("footer.php"); ?>