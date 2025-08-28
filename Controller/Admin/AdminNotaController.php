<?php
require_once __DIR__ ."/../../Models/Nota.php";

class AdminNotaController {
    private $model;

    public function __construct() {
        $this->model = new Nota();
    }

    public function exibirNotasAluno() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        $alunoId = isset($_GET['aluno_id']) ? (int)$_GET['aluno_id'] : null;
        if (!$alunoId) {
            header('Location: index.php?error=' . urlencode('ID do aluno não especificado'));
            exit;
        }
        // Buscar matrículas do aluno para obter notas
        $stmt = $pdo->prepare('SELECT m.MatriculaID FROM matricula m WHERE m.AlunoID = ?');
        $stmt->execute([$alunoId]);
        $matriculas = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $notas = [];
        if ($matriculas) {
            $stmt = $pdo->prepare('SELECT * FROM nota WHERE MatriculaID IN (' . implode(',', array_fill(0, count($matriculas), '?')) . ')');
            $stmt->execute($matriculas);
            $notas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        include 'views/admin/notas_aluno.php';
    }
}
?>