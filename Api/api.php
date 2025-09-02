<?php
require_once __DIR__ ."/../Conexao/conector.php";

header('Content-Type: application/json');

try {
    $db = new Conector();
    $pdo = $db->getConexao();
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);
$resource = isset($_GET['resource']) ? $_GET['resource'] : null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$resource) {
    echo json_encode(['error' => 'Recurso não especificado']);
    exit;
}

switch ($resource) {
    case 'auth':
    switch ($method) {
        case 'POST':
            if (isset($input['action']) && $input['action'] === 'login') {
                if (!isset($input['email']) || !isset($input['senha'])) {
                    echo json_encode(['error' => 'Dados de login incompletos']);
                    exit;
                }
                if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                    echo json_encode(['error' => 'Email inválido']);
                    exit;
                }
                if (strlen($input['senha']) < 2) {  // Ajuste mínimo conforme necessário
                    echo json_encode(['error' => 'Senha deve ter pelo menos 6 caracteres']);
                    exit;
                }
                $stmt = $pdo->prepare('SELECT UsuarioId, Tipo, Senha FROM usuario WHERE Email = ?');
                $stmt->execute([$input['email']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user && $input['senha'] === $user['Senha']) {  // Comparação de texto plano
                    echo json_encode([
                        'user_id' => $user['UsuarioId'],
                        'tipo' => $user['Tipo'],
                        'message' => 'Login realizado com sucesso'
                    ]);
                } else {
                    echo json_encode(['error' => 'Credenciais inválidas']);
                }
            } elseif (isset($input['action']) && $input['action'] === 'register') {
                if (isset($input['nome'], $input['email'], $input['senha'], $input['tipo'])) {
                    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                        echo json_encode(['error' => 'Email inválido']);
                        exit;
                    }
                    if (strlen($input['senha']) < 2) {
                        echo json_encode(['error' => 'Senha deve ter pelo menos 6 caracteres']);
                        exit;
                    }
                    $senhaHash = $input['senha'];  // Remova password_hash para texto plano
                    $stmt = $pdo->prepare('INSERT INTO usuario (Nome, Email, Senha, Tipo) VALUES (?, ?, ?, ?)');
                    $stmt->execute([$input['nome'], $input['email'], $senhaHash, $input['tipo']]);
                    $id = $pdo->lastInsertId();
                    echo json_encode(['id' => $id, 'message' => 'Registrado com sucesso']);
                } else {
                    echo json_encode(['error' => 'Dados incompletos']);
                }
            }
            break;
    }
    break;

    case 'notas':
        switch ($method) {
            case 'GET':
                if ($id) {
                    $stmt = $pdo->prepare('SELECT * FROM nota WHERE NotaID = ?');
                    $stmt->execute([$id]);
                    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
                } else {
                    $stmt = $pdo->query('SELECT * FROM nota');
                    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                }
                break;
            case 'POST':
                if (isset($input['MatriculaID'], $input['ModuloID'], $input['Periodo'], $input['Valor'])) {
                    if (!is_numeric($input['Valor']) || $input['Valor'] < 0 || $input['Valor'] > 20) {
                        echo json_encode(['error' => 'Valor da nota deve ser um número entre 0 e 20']);
                        exit;
                    }
                    // Verificar se o formador leciona o módulo na turma da matrícula
                    $matriculaId = (int)$input['MatriculaID'];
                    $moduloId = (int)$input['ModuloID'];
                    $stmt = $pdo->prepare('SELECT m.TurmaID FROM matricula m WHERE m.MatriculaID = ?');
                    $stmt->execute([$matriculaId]);
                    $turma = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (!$turma) {
                        echo json_encode(['error' => 'Matrícula inválida']);
                        exit;
                    }
                    $turmaId = $turma['TurmaID'];
                    $formadorId = isset($_SERVER['HTTP_X_FORMADOR_ID']) ? (int)$_SERVER['HTTP_X_FORMADOR_ID'] : null;
                    if (!$formadorId) {
                        echo json_encode(['error' => 'ID do formador não fornecido']);
                        exit;
                    }
                    $stmt = $pdo->prepare('SELECT LecionaID FROM lecionar WHERE FormadorID = ? AND ModuloID = ? AND TurmaID = ?');
                    $stmt->execute([$formadorId, $moduloId, $turmaId]);
                    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo json_encode(['error' => 'Você não leciona este módulo nesta turma']);
                        exit;
                    }
                    $stmt = $pdo->prepare('INSERT INTO nota (MatriculaID, ModuloID, Periodo, Valor) VALUES (?, ?, ?, ?)');
                    $stmt->execute([$input['MatriculaID'], $input['ModuloID'], $input['Periodo'], $input['Valor']]);
                    $id = $pdo->lastInsertId();
                    echo json_encode(['id' => $id, 'message' => 'Nota lançada com sucesso']);
                } else {
                    echo json_encode(['error' => 'Dados incompletos para lançar nota']);
                }
                break;
            case 'PUT':
                if ($id && isset($input['Valor'])) {
                    if (!is_numeric($input['Valor']) || $input['Valor'] < 0 || $input['Valor'] > 20) {
                        echo json_encode(['error' => 'Valor da nota deve ser um número entre 0 e 20']);
                        exit;
                    }
                    $stmt = $pdo->prepare('UPDATE nota SET Valor = ? WHERE NotaID = ?');
                    $stmt->execute([$input['Valor'], $id]);
                    echo json_encode(['message' => 'Nota atualizada com sucesso']);
                } else {
                    echo json_encode(['error' => 'Dados incompletos para atualizar nota']);
                }
                break;
            case 'DELETE':
                if ($id) {
                    $stmt = $pdo->prepare('DELETE FROM nota WHERE NotaID = ?');
                    $stmt->execute([$id]);
                    echo json_encode(['message' => 'Nota removida com sucesso']);
                } else {
                    echo json_encode(['error' => 'ID não especificado para remover nota']);
                }
                break;
        }
        break;

    case 'alunos':
        switch ($method) {
            case 'GET':
                $stmt = $pdo->query('SELECT a.AlunoID, a.Nome FROM aluno a');
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                break;
            
            case 'POST':
                if (isset($input['Nome'], $input['DataNascimento'])) {
                    $nome = trim($input['Nome']);
                    $dataNascimento = $input['DataNascimento'];
                    if(empty($nome)) {
                        echo json_encode(['error' => 'Nome do aluno é obrigatório']);
                        exit;
                    }
                    try {
                        $stmt = $pdo->prepare('INSERT INTO aluno (Nome, DataNascimento) VALUES (?, ?)');
                        $stmt->execute([$nome, $dataNascimento]);
                        $id = $pdo->lastInsertId();
                        echo json_encode(['id' => $id, 'message' => 'Aluno registrado com sucesso']);
                    } catch (PDOException $e) {
                        echo json_encode(['error' => 'Erro ao registrar o curso: ' . $e->getMessage()]);
                    }
                } else {
                    echo json_encode(['error' => 'Dados incompletos para registrar aluno']);
                }
                break;
        }
        break;

    case 'formador':
        switch ($method) {
            case 'POST':
                if (isset($input['Nome'], $input['DataNascimento'])) {
                    $nome = trim($input['Nome']);
                    $dataNascimento = $input['DataNascimento'];
                    if(empty($nome)) {
                        echo json_encode(['error' => 'Nome do aluno é obrigatório']);
                        exit;
                    }
                    try {
                        $stmt = $pdo->prepare('INSERT INTO aluno (Nome, DataNascimento) VALUES (?, ?)');
                        $stmt->execute([$nome, $dataNascimento]);
                        $id = $pdo->lastInsertId();
                        echo json_encode(['id' => $id, 'message' => 'Aluno registrado com sucesso']);
                    } catch (PDOException $e) {
                        echo json_encode(['error' => 'Erro ao registrar o curso: ' . $e->getMessage()]);
                    }
                } else {
                    echo json_encode(['error' => 'Dados incompletos para registrar aluno']);
                }
                break;
        }
        break;

    case 'turmas':
        switch ($method) {
            case 'GET':
                if (isset($_GET['formador_id'])) {
                    $formadorId = (int)$_GET['formador_id'];
                    $stmt = $pdo->prepare('SELECT DISTINCT t.TurmaID, t.Nome FROM turma t JOIN lecionar l ON t.TurmaID = l.TurmaID WHERE l.FormadorID = ?');
                    $stmt->execute([$formadorId]);
                    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                } else {
                    $stmt = $pdo->query('SELECT TurmaID, Nome FROM turma');
                    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                }
                break;
        }
        break;

    case 'modulos':
        switch ($method) {
            case 'GET':
                if (isset($_GET['formador_id']) && isset($_GET['turma_id'])) {
                    $formadorId = (int)$_GET['formador_id'];
                    $turmaId = (int)$_GET['turma_id'];
                    $stmt = $pdo->prepare('SELECT m.ModuloID, m.Nome FROM modulo m JOIN lecionar l ON m.ModuloID = l.ModuloID WHERE l.FormadorID = ? AND l.TurmaID = ?');
                    $stmt->execute([$formadorId, $turmaId]);
                    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                } else {
                    $stmt = $pdo->query('SELECT ModuloID, Nome FROM modulo');
                    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                }
                break;
            case 'POST':
                if (isset($input['Nome'], $input['CursoID'])) {
                    $nome = trim($input['Nome']);
                    $cursoID = $input['CursoID'];
                    if (empty($nome)) {
                        echo json_encode(['error' => 'Nome do módulo é obrigatório']);
                        exit;
                    }
                    try {
                        $stmt = $pdo->prepare('INSERT INTO modulo (Nome, CursoID) VALUES (?, ?)');
                        $stmt->execute([$nome, $cursoID]);
                        $id = $pdo->lastInsertId();
                        echo json_encode(['id' => $id, 'message' => 'Módulo registrado com sucesso']);
                    } catch (PDOException $e) {
                        echo json_encode(['error' => 'Erro ao registrar o módulo: ' . $e->getMessage()]);
                    }
                } else {
                    echo json_encode(['error' => 'Dados incompletos para registrar módulo']);
                }
                break;
        }
        break;

    case 'matriculas':
        switch ($method) {
            case 'GET':
                if (isset($_GET['turma_id'])) {
                    $turmaId = (int)$_GET['turma_id'];
                    $stmt = $pdo->prepare('SELECT m.MatriculaID, a.AlunoID, a.Nome FROM matricula m JOIN aluno a ON m.AlunoID = a.AlunoID WHERE m.TurmaID = ?');
                    $stmt->execute([$turmaId]);
                    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                } else {
                    echo json_encode(['error' => 'Turma não especificada']);
                }
                break;
        }
        break;

    case 'lecionar':
        switch ($method) {
            case 'GET':
                if (isset($_GET['formador_id']) && isset($_GET['modulo_id']) && isset($_GET['turma_id'])) {
                    $formadorId = (int)$_GET['formador_id'];
                    $moduloId = (int)$_GET['modulo_id'];
                    $turmaId = (int)$_GET['turma_id'];
                    $stmt = $pdo->prepare('SELECT LecionaID FROM lecionar WHERE FormadorID = ? AND ModuloID = ? AND TurmaID = ?');
                    $stmt->execute([$formadorId, $moduloId, $turmaId]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo json_encode(['leciona' => !empty($result)]);
                } else {
                    echo json_encode(['error' => 'Dados incompletos para verificação']);
                }
                break;
        }
        break;

    case 'cursos':
        switch ($method) {
            case 'GET':
                $stmt = $pdo->query('SELECT CursoID, Nome FROM curso');
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                break;
            case 'POST':
                if (isset($input['Nome'])) {
                    $nome = trim($input['Nome']);
                    if (empty($nome)) {
                        echo json_encode(['error' => 'Nome do curso é obrigatório']);
                        exit;
                    }
                    try {
                        $stmt = $pdo->prepare('INSERT INTO curso (Nome) VALUES (?)');
                        $stmt->execute([$nome]);
                        $id = $pdo->lastInsertId();
                        echo json_encode(['id' => $id, 'message' => 'Curso registrado com sucesso']);
                    } catch (PDOException $e) {
                        echo json_encode(['error' => 'Erro ao registrar o curso: ' . $e->getMessage()]);
                    }
                } else {
                    echo json_encode(['error' => 'Dados incompletos para registrar curso']);
                }
                break;
            }
        break;

    default:
        echo json_encode(['error' => 'Recurso inválido']);
        break;
}
?>