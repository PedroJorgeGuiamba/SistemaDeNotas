<?php
require_once __DIR__ ."/../../Models/Usuario.php";
class UserController {
    private $model;

    public function __construct() {
        $this->model = new Usuario();
    }

    public function exibirLogin() {
        include 'View/Auth/login.php';
    }

    public function realizarLogin() {
        if (!isset($_POST['email']) || !isset($_POST['senha'])) {
            header('Location: index.php?action=exibir_login&error=' . urlencode('Dados de login incompletos'));
            exit;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            header('Location: index.php?action=exibir_login&error=' . urlencode('Email inválido'));
            exit;
        }

        if (strlen($_POST['senha']) < 6) {
            header('Location: index.php?action=exibir_login&error=' . urlencode('Senha deve ter pelo menos 6 caracteres'));
            exit;
        }

        $data = [
            'action' => 'login',
            'email' => $_POST['email'],
            'senha' => $_POST['senha']
        ];
        $result = $this->model->autenticar($data);
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_login&error=' . urlencode($result['error']));
        } else {
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['tipo'] = $result['tipo'];
            header('Location: index.php');
        }
    }

    public function exibirRegistro() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        include 'views/auth/register_user.php';
    }

    public function realizarRegistro() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        if (!isset($_POST['nome']) || !isset($_POST['email']) || !isset($_POST['senha']) || !isset($_POST['tipo'])) {
            header('Location: index.php?action=exibir_registro&error=' . urlencode('Dados de registro incompletos'));
            exit;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            header('Location: index.php?action=exibir_registro&error=' . urlencode('Email inválido'));
            exit;
        }

        if (strlen($_POST['senha']) < 6) {
            header('Location: index.php?action=exibir_registro&error=' . urlencode('Senha deve ter pelo menos 6 caracteres'));
            exit;
        }

        $data = [
            'action' => 'register',
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'senha' => $_POST['senha'],
            'tipo' => $_POST['tipo']
        ];
        $result = $this->model->registrar($data);
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_registro&error=' . urlencode($result['error']));
        } else {
            header('Location: index.php');
        }
    }
}
?>