<?php
class Veiculo
{
    private $conn;

    // Construtor que recebe a conexão com o banco de dados
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function cadastrar($placa, $modelo, $ano_fabricado, $ano_modelo, $marca, $cor, $tipo, $combustivel, $chassi, $renavan, $observacao, $status, $preco)
    {
        $query = "INSERT INTO veiculos (placa, modelo, ano_fabricado, ano_modelo, marca, cor, tipo, combustivel, chassi, renavan, observacao, status, preco)
                  VALUES (:placa, :modelo, :ano_fabricado, :ano_modelo, :marca, :cor, :tipo, :combustivel, :chassi, :renavan, :observacao, :status, :preco)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':placa', $placa);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':ano_fabricado', $ano_fabricado);
        $stmt->bindParam(':ano_modelo', $ano_modelo);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':cor', $cor);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':combustivel', $combustivel);
        $stmt->bindParam(':chassi', $chassi);
        $stmt->bindParam(':renavan', $renavan);
        $stmt->bindParam(':observacao', $observacao);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':preco', $preco);

        return $stmt->execute();
    }

    public function atualizar($id, $placa, $modelo, $ano_fabricado, $ano_modelo, $marca, $cor, $tipo, $combustivel, $chassi, $renavan, $observacao, $status, $preco)
    {
        $query = "UPDATE veiculos SET placa = :placa, modelo = :modelo, ano_fabricado = :ano_fabricado, ano_modelo = :ano_modelo,
                  marca = :marca, cor = :cor, tipo = :tipo, combustivel = :combustivel, chassi = :chassi, renavan = :renavan,
                  observacao = :observacao, status = :status, preco = :preco WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':placa', $placa);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':ano_fabricado', $ano_fabricado);
        $stmt->bindParam(':ano_modelo', $ano_modelo);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':cor', $cor);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':combustivel', $combustivel);
        $stmt->bindParam(':chassi', $chassi);
        $stmt->bindParam(':renavan', $renavan);
        $stmt->bindParam(':observacao', $observacao);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM veiculos WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para listar todos os veículos
    public function listarTodos()
    {
        $query = "SELECT * FROM veiculos";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Função para deletar um veículo
    public function deletar($id)
    {
        // SQL para excluir o veículo com base no ID
        $query = "DELETE FROM veiculos WHERE id = :id";

        // Prepara a consulta
        $stmt = $this->conn->prepare($query);

        // Bind do parâmetro ID
        $stmt->bindParam(':id', $id);

        // Executa a consulta e verifica se foi bem-sucedido
        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Erro ao excluir veículo.");
        }
    }

    public function listarDisponiveis()
    {
        $query = "SELECT id, modelo, placa FROM veiculos WHERE status = 'disponível'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Dentro da classe Veiculo
    public function pesquisar($search)
    {
        $query = "SELECT id, placa, modelo, marca, preco, ano_modelo FROM veiculos WHERE placa LIKE :search LIMIT 3";
        $stmt = $this->conn->prepare($query);
        $search = "%" . $search . "%";  // para realizar uma busca com LIKE
        $stmt->bindParam(':search', $search);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
