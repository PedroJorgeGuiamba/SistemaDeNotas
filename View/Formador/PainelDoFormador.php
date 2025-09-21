<?php
require_once __DIR__ . '/../../middleware/auth.php'; // protege a página e inicia a sessão
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Formador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Painel do Formador</h2>
        <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['tipo']); ?>!</p>
        <div class="card mb-3">
            <div class="card-header">Ações Administrativas</div>
            <div class="card-body">
                <a href="index.php?action=exibir_lancar_nota" class="btn btn-primary mb-2">Lancar Nota</a>
                <a href="index.php?action=exibir_notas" class="btn btn-primary mb-2">Visualizar Notas dos Alunos</a>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Resumo do Sistema</div>
            <div class="card-body">
                <?php
                $ch = curl_init("http://localhost/SistemaDeNotas/Api/api.php?resource=alunos");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $alunos = json_decode(curl_exec($ch), true);
                curl_close($ch);
                $ch = curl_init("http://localhost/SistemaDeNotas/Api/api.php?resource=modulos");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $modulos = json_decode(curl_exec($ch), true);
                curl_close($ch);
                echo '<p><strong>Total de Alunos:</strong> ' . (isset($alunos['error']) ? 0 : count($alunos)) . '</p>';
                echo '<p><strong>Total de Módulos:</strong> ' . (isset($modulos['error']) ? 0 : count($modulos)) . '</p>';
                ?>
            </div>
        </div>
        <a href="index.php?action=logout" class="btn btn-secondary mt-3">Sair</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>