<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Busca de Valores - Spectros Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4">Busca de Valores com Tolerância em Arquivos TXT (ZIP)</h3>
    <form action="processa.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="referencias" class="form-label">Valores de referência (separados por vírgula):</label>
            <input type="text" name="referencias" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="tolerancia" class="form-label">Tolerância (±):</label>
            <input type="number" step="any" name="tolerancia" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="zipfile" class="form-label">Arquivo ZIP com arquivos TXT:</label>
            <input type="file" name="zipfile" class="form-control" accept=".zip" required>
        </div>
        <button type="submit" class="btn btn-primary">Processar</button>
    </form>
</div>
</body>
</html>
<?php include("footer.php"); ?>