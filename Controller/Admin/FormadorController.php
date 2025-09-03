<?php
require_once __DIR__ ."/../../Models/Formador.php";

class FormadorController {
    private $model;

    public function __construct() {
        $this->model = new Formador();
    }

    public function exibirRegistroFormador() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        include __DIR__ . '/../../View/Admin/RegistrarFormador.php';
    }

    public function realizarRegistroFormador() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        if (!isset($_POST['Nome'])) {
            header('Location: index.php?action=exibir_registro_formador&error=' . urlencode('Dados incompletos'));
            exit;
        }
        $data = [
            'Nome' => $_POST['Nome']
        ];
        $result = $this->model->registrarFormador($data);
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_registro_formador&error=' . urlencode($result['error']));
        } else {
            header('Location: index.php');
        }
    }
}
?>