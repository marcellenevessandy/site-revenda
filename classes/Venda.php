<?php
class Venda {
    private $conn;

    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    public function cadastrarVenda($clienteId, $veiculoId, $dataVenda, $precoFinal, $formaPagamento, $descricao) {
        try {
            // SQL para inserir dados na tabela de vendas
            $sql = "INSERT INTO vendas (cliente_id, veiculo_id, data_venda, preco_final, forma_pagamento, descricao)
                    VALUES (:cliente_id, :veiculo_id, :data_venda, :preco_final, :forma_pagamento, :descricao)";

            // Preparar a consulta
            $stmt = $this->conn->prepare($sql);

            // Bind dos parâmetros
            $stmt->bindParam(':cliente_id', $clienteId);
            $stmt->bindParam(':veiculo_id', $veiculoId);
            $stmt->bindParam(':data_venda', $dataVenda);
            $stmt->bindParam(':preco_final', $precoFinal);
            $stmt->bindParam(':forma_pagamento', $formaPagamento);
            $stmt->bindParam(':descricao', $descricao);

            // Executa a consulta e retorna o resultado
            if ($stmt->execute()) {
                return true; // Venda cadastrada com sucesso
            } else {
                return false; // Erro ao cadastrar venda
            }
        } catch (PDOException $e) {
            // Se ocorrer erro, exibe a mensagem
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }
}

?>
