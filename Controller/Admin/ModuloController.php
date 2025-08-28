<?php
require_once __DIR__ ."/../../Models/Modulo.php";

class ModuloController {
    private $model;

    public function __construct() {
        $this->model = new Modulo();
    }

    public function exibirRegistroModulo() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        include 'views/admin/register_modulo.php';
    }

    public function realizarRegistroModulo() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        if (!isset($_POST['Nome'])) {
            header('Location: index.php?action=exibir_registro_modulo&error=' . urlencode('Dados incompletos'));
            exit;
        }
        $data = [
            'Nome' => $_POST['Nome']
        ];
        $result = $this->model->registrarModulo($data);
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_registro_modulo&error=' . urlencode($result['error']));
        } else {
            header('Location: index.php');
        }
    }
}
?>