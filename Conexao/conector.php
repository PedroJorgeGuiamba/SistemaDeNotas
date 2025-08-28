<?php
class Conector {
    private $host = 'localhost';
    private $dbname = 'sistemanotas';
    private $username = 'root';
    private $password = 'Familiaguiamba1';
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException('Erro de conexão: ' . $e->getMessage());
        }
    }

    public function getConexao() {
        return $this->pdo;
    }
}
?>