<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lançar Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Lançar Nota</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></div>
        <?php endif; ?>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="realizar_lancar_nota">
            <div class="mb-3">
                <label for="turma_id" class="form-label">Turma</label>
                <select class="form-control" id="turma_id" name="turma_id" required onchange="loadModulosAndMatriculas(this.value)">
                    <?php
                    require_once __DIR__ ."/../../Models/TurmaApi.php";
                    $turmaApi = new TurmaApi();
                    $turmas = $turmaApi->listarTurmasFormador($_SESSION['user_id']);
                    foreach ($turmas as $turma): ?>
                        <option value="<?php echo htmlspecialchars($turma['TurmaID']); ?>"><?php echo htmlspecialchars($turma['Nome']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="ModuloID" class="form-label">Módulo</label>
                <select class="form-control" id="ModuloID" name="ModuloID" required>
                    <!-- Opções carregadas via JS -->
                </select>
            </div>
            <div class="mb-3">
                <label for="MatriculaID" class="form-label">Aluno (Matrícula)</label>
                <select class="form-control" id="MatriculaID" name="MatriculaID" required>
                    <!-- Opções carregadas via JS -->
                </select>
            </div>
            <div class="mb-3">
                <label for="Periodo" class="form-label">Período</label>
                <input type="text" class="form-control" id="Periodo" name="Periodo" maxlength="2" required>
            </div>
            <div class="mb-3">
                <label for="Valor" class="form-label">Valor (0-20)</label>
                <input type="number" step="0.1" min="0" max="20" class="form-control" id="Valor" name="Valor" required>
            </div>
            <button type="submit" class="btn btn-primary">Lançar</button>
            <a href="index.php?action=exibir_notas" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
    <script>
        function loadModulosAndMatriculas(turmaId) {
            // Carregar módulos
            fetch(`http://localhost/project/api/api.php?resource=modulos&formador_id=${<?php echo $_SESSION['user_id']; ?>}&turma_id=${turmaId}`)
                .then(response => response.json())
                .then(modulos => {
                    let select = document.getElementById('ModuloID');
                    select.innerHTML = '';
                    modulos.forEach(modulo => {
                        let option = document.createElement('option');
                        option.value = modulo.ModuloID;
                        option.text = modulo.Nome;
                        select.appendChild(option);
                    });
                });

            // Carregar matrículas (alunos)
            fetch(`http://localhost/project/api/api.php?resource=matriculas&turma_id=${turmaId}`)
                .then(response => response.json())
                .then(matriculas => {
                    let select = document.getElementById('MatriculaID');
                    select.innerHTML = '';
                    matriculas.forEach(matricula => {
                        let option = document.createElement('option');
                        option.value = matricula.MatriculaID;
                        option.text = `${matricula.Nome} (ID: ${matricula.AlunoID})`;
                        select.appendChild(option);
                    });
                });
        }
        // Carregar inicial para a primeira turma
        document.addEventListener('DOMContentLoaded', () => {
            let turmaSelect = document.getElementById('turma_id');
            if (turmaSelect.options.length > 0) {
                loadModulosAndMatriculas(turmaSelect.value);
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>