<?php
class ModuloApi {
    private $apiUrl = "http://localhost/SistemaDeNotas/api/api.php?resource=modulos";

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

    public function listarModulosFormadorTurma($formadorId, $turmaId) {
        $params = ['formador_id' => $formadorId, 'turma_id' => $turmaId];
        return $this->enviarRequisicao('GET', $params);
    }
}
?>