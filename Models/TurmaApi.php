<?php
class TurmaApi {
    private $apiUrl = "http://localhost/SistemaDeNotas/api/api.php?resource=turmas";

    private function enviarRequisicao($method, $params = null) {
        $ch = curl_init();
        $url = $this->apiUrl;
        if ($params) {
            $url .= '&' . http_build_query($params);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Erro na requisição cURL: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($response, true);
    }

    public function listarTurmasFormador($formadorId) {
        $params = ['formador_id' => $formadorId];
        return $this->enviarRequisicao('GET', $params);
    }
}
?>