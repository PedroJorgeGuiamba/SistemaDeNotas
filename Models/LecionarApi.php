<?php
class LecionarApi {
    private $apiUrl = "http://localhost/SistemaDeNotas/Api/api.php?resource=lecionar";

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
        return json_decode($response, true)['leciona'];
    }

    public function verificarLecionar($formadorId, $moduloId, $turmaId) {
        $params = ['formador_id' => $formadorId, 'modulo_id' => $moduloId, 'turma_id' => $turmaId];
        return $this->enviarRequisicao('GET', $params);
    }
}
?>