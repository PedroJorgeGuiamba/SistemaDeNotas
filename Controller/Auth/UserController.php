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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_POST['email']) || !isset($_POST['senha'])) {
            header('Location: index.php?action=exibir_login&error=' . urlencode('Dados de login incompletos'));
            exit;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            header('Location: index.php?action=exibir_login&error=' . urlencode('Email inválido'));
            exit;
        }

        if (strlen($_POST['senha']) < 2) {
            header('Location: index.php?action=exibir_login&error=' . urlencode('Senha deve ter pelo menos 2 caracteres'));
            exit;
        }

        $data = [
            'action' => 'login',
            'email' => $_POST['email'],
            'senha' => $_POST['senha']
        ];
        $result = $this->model->autenticar($data);
        error_log("API Response: " . print_r($result, true));
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_login&error=' . urlencode($result['error']));
            exit;
        } else {
            if (isset($result['user_id']) && isset($result['tipo'])) {
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['tipo'] = $result['tipo'];
                error_log("Session set: user_id=" . $_SESSION['user_id'] . ", tipo=" . $_SESSION['tipo']);
                header('Location: index.php');
                exit;
            } else {
                error_log("Missing keys in result: " . print_r($result, true));
                header('Location: index.php?action=exibir_login&error=' . urlencode('Falha ao processar login'));
                exit;
            }
        }
    }

    public function exibirRegistro() {
        // if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
        //     header('Location: index.php?error=acesso_negado');
        //     exit;
        // }
        include __DIR__ . '/../../View/Auth/register.php';
    }

    public function realizarRegistro() {
        // if (!isset($_SESSION['tipo'])) {
        //     header('Location: index.php?error=acesso_negado');
        //     exit;
        // }
        if (!isset($_POST['nome']) || !isset($_POST['email']) || !isset($_POST['senha']) || !isset($_POST['tipo'])) {
            header('Location: index.php?action=exibir_registro&error=' . urlencode('Dados de registro incompletos'));
            exit;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            header('Location: index.php?action=exibir_registro&error=' . urlencode('Email inválido'));
            exit;
        }

        if (strlen($_POST['senha']) < 2) {
            header('Location: index.php?action=exibir_registro&error=' . urlencode('Senha deve ter pelo menos 2 caracteres'));
            exit;
        }

        $data = [
            'action' => 'register',
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'senha' => $_POST['senha'],
            'tipo' => $_POST['tipo']
        ];
        // $result = $this->model->registrar($data);
        // if (isset($result['error'])) {
        //     header('Location: index.php?action=exibir_registro&error=' . urlencode($result['error']));
        // } else {
        //     header('Location: index.php');
        // }

        $result = $this->model->registrar($data);
        // if (isset($result['error'])) {
        //     header('Location: index.php?action=exibir_registro&error=' . urlencode($result['error']));
        //     exit;
        // } else {
        //     header('Location: index.php?action=exibir_login&msg=' . urlencode('Registrado com sucesso, faça login.'));
        //     exit;
        // }
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_registro&error=' . urlencode($result['error']));
            exit;
        } else {
            header('Location: index.php?action=exibir_login&msg=' . urlencode('Registrado com sucesso, faça login.'));
            exit;
        }


    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: index.php?action=exibir_login&msg=' . urlencode('Sessão encerrada.'));
        exit;
    }

}
?>