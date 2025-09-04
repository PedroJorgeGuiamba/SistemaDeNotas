<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Painel do Administrador</h2>
        <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['tipo']); ?>!</p>
        <div class="card mb-3">
            <div class="card-header">Ações Administrativas</div>
            <div class="card-body">
                <a href="index.php?action=exibir_registro_modulo" class="btn btn-primary mb-2">Registrar Módulo</a>
                <a href="index.php?action=exibir_registro_formador" class="btn btn-primary mb-2">Registrar Formador</a>
                <a href="index.php?action=exibir_registro_aluno" class="btn btn-primary mb-2">Registrar Aluno</a>
                <a href="index.php?action=exibir_atribuicao_modulo" class="btn btn-primary mb-2">Atribuir Módulo a Formador</a>
                <a href="index.php?action=exibir_notas" class="btn btn-primary mb-2">Visualizar Notas dos Alunos</a>
                <a href="index.php?action=exibir_registro_curso" class="btn btn-primary mb-2">Registrar Curso</a>
                <a href="index.php?action=exibir_registro_turma" class="btn btn-primary mb-2">Registrar Turma</a>
                <a href="index.php?action=exibir_registro_matricula" class="btn btn-primary mb-2">Registrar Matricula</a>
                <a href="index.php?action=exibir_lancar_nota" class="btn btn-primary mb-2">Lancar Nota</a>
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
                $ch = curl_init("http://localhost/SistemaDeNotas/Api/api.php?resource=turmas");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $turmas = json_decode(curl_exec($ch), true);
                curl_close($ch);
                $ch = curl_init("http://localhost/SistemaDeNotas/Api/api.php?resource=formador");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $formadores = json_decode(curl_exec($ch), true);
                curl_close($ch);
                $ch = curl_init("http://localhost/SistemaDeNotas/Api/api.php?resource=cursos");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $cursos = json_decode(curl_exec($ch), true);
                curl_close($ch);
                echo '<p><strong>Total de Alunos:</strong> ' . (isset($alunos['error']) ? 0 : count($alunos)) . '</p>';
                echo '<p><strong>Total de Módulos:</strong> ' . (isset($modulos['error']) ? 0 : count($modulos)) . '</p>';
                echo '<p><strong>Total de Turmas:</strong> ' . (isset($turmas['error']) ? 0 : count($turmas)) . '</p>';
                echo '<p><strong>Total de Formadores:</strong> ' . (isset($formadores['error']) ? 0 : count($formadores)) . '</p>';
                echo '<p><strong>Total de Cursos:</strong> ' . (isset($cursos['error']) ? 0 : count($cursos)) . '</p>';
                ?>
            </div>
        </div>
        <a href="index.php?action=exibir_login" class="btn btn-secondary mt-3">Sair</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>