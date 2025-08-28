<?php
class Usuario {
    private $apiUrl = "http://localhost/SistemaDeNotas/Api/api.php?resource=auth";

    private function enviarRequisicao($data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Erro na requisição cURL: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($response, true);
    }

    public function autenticar($data) {
        return $this->enviarRequisicao($data);
    }

    public function registrar($data) {
        return $this->enviarRequisicao($data);
    }
}
?>