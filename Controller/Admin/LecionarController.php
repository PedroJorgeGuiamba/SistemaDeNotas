<?php
require_once __DIR__ ."/../../Models/Lecionar.php";

class LecionarController {
    private $model;

    public function __construct() {
        $this->model = new Lecionar();
    }

    public function exibirAtribuicaoModulo() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        include __DIR__ . '/../../View/Admin/AtribuirModuloFormador.php';
    }

    public function realizarAtribuicaoModulo() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        if (!isset($_POST['FormadorID']) || !isset($_POST['ModuloID']) || !isset($_POST['TurmaID'])) {
            header('Location: index.php?action=exibir_atribuicao_modulo&error=' . urlencode('Dados incompletos'));
            exit;
        }
        $data = [
            'FormadorID' => $_POST['FormadorID'],
            'ModuloID' => $_POST['ModuloID'],
            'TurmaID' => $_POST['TurmaID']
        ];
        $result = $this->model->atribuirModulo($data);
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_atribuicao_modulo&error=' . urlencode($result['error']));
        } else {
            header('Location: index.php');
        }
    }
}
?>