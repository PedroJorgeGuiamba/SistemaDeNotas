<?php
class Turma {
    private $apiUrl = "http://localhost/SistemaDeNotas/Api/api.php?resource=turmas";

    private function enviarRequisicao($method, $data = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Erro na requisição cURL: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($response, true);
    }

    public function registrarTurma($data) {
        return $this->enviarRequisicao('POST', $data);
    }
}
?>