<?php
require_once __DIR__ ."/../../Models/Aluno.php";

class AlunoController {
    private $model;

    public function __construct() {
        $this->model = new Aluno();
    }

    public function exibirRegistroAluno() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        include 'views/admin/register_aluno.php';
    }

    public function realizarRegistroAluno() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        if (!isset($_POST['Nome'])) {
            header('Location: index.php?action=exibir_registro_aluno&error=' . urlencode('Dados incompletos'));
            exit;
        }
        $data = [
            'Nome' => $_POST['Nome']
        ];
        $result = $this->model->registrarAluno($data);
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_registro_aluno&error=' . urlencode($result['error']));
        } else {
            header('Location: index.php');
        }
    }
}
?>