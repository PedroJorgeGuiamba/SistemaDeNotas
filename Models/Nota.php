<?php
class Nota {
    private $apiUrl = "http://localhost/SistemaDeNotas/Api/api.php?resource=notas";

    private function enviarRequisicao($method, $data = null, $id = null) {
        $ch = curl_init();
        $url = $this->apiUrl;
        if ($id) {
            $url .= '&id=' . $id;
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = ['Content-Type: application/json'];
        if (isset($_SESSION['user_id']) && $method === 'POST') {
            $headers[] = 'X-Formador-ID: ' . $_SESSION['user_id'];
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($method === 'POST' || $method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Erro na requisição cURL: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($response, true);
    }


    public function listarNotas() {
        return $this->enviarRequisicao('GET');
    }

    public function obterNota($id) {
        return $this->enviarRequisicao('GET', null, $id);
    }

    public function lancarNota($data) {
        return $this->enviarRequisicao('POST', $data);
    }

    public function editarNota($id, $data) {
        return $this->enviarRequisicao('PUT', $data, $id);
    }

    public function excluirNota($id) {
        return $this->enviarRequisicao('DELETE', null, $id);
    }


    public function listarNotasPorAluno($alunoId) {
        return $this->enviarRequisicao('GET', ['aluno_id' => $alunoId]);
    }
}
?>