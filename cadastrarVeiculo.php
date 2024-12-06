<?php
// Inicia a sessão
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver logado
    exit();
}

include_once './config/config.php'; // Conexão com o banco de dados
include_once './classes/Veiculo.php'; // Inclusão da classe Veiculo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Coleta os dados do formulário
        $placa = $_POST['placa'];
        $modelo = $_POST['modelo'];
        $ano_fabricado = $_POST['ano_fabricado'];
        $ano_modelo = $_POST['ano_modelo'];
        $marca = $_POST['marca'];
        $cor = $_POST['cor'];
        $tipo = $_POST['tipo'];
        $combustivel = $_POST['combustivel'];
        $chassi = $_POST['chassi'];
        $renavan = $_POST['renavan'];
        $observacao = $_POST['observacao'];
        $status = $_POST['status'];
        $preco = $_POST['preco']; // Coleta o valor de preço corretamente

        // Cria uma instância da classe Veiculo
        $veiculo = new Veiculo($db);

        // Chama o método para cadastrar o veículo
        $veiculo->cadastrar($placa, $modelo, $ano_fabricado, $ano_modelo, $marca, $cor, $tipo, $combustivel, $chassi, $renavan, $observacao, $status, $preco);

        echo "Veículo cadastrado com sucesso!"; // Mensagem de sucesso
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage(); // Mensagem de erro
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Veículo</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Cadastro de Veículo</h2>

        <form method="POST" action="cadastrarVeiculo.php">
            <!-- Placa -->
            <div class="mb-3">
                <label for="placa" class="form-label">Placa</label>
                <input type="text" class="form-control" id="placa" name="placa" placeholder="Digite a placa" required>
            </div>

            <!-- Modelo -->
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Digite o modelo" required>
            </div>

              <!-- Preço -->
            <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
            </div>

            <!-- Ano Fabricado -->
            <div class="mb-3">
                <label for="ano_fabricado" class="form-label">Ano Fabricado</label>
                <input type="number" class="form-control" id="ano_fabricado" name="ano_fabricado" placeholder="Digite o ano de fabricação" required>
            </div>

            <!-- Ano Modelo -->
            <div class="mb-3">
                <label for="ano_modelo" class="form-label">Ano Modelo</label>
                <input type="number" class="form-control" id="ano_modelo" name="ano_modelo" placeholder="Digite o ano do modelo" required>
            </div>

            <!-- Marca -->
            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" placeholder="Digite a marca" required>
            </div>

            <!-- Cor -->
            <div class="mb-3">
                <label for="cor" class="form-label">Cor</label>
                <input type="text" class="form-control" id="cor" name="cor" placeholder="Digite a cor" required>
            </div>

            <!-- Tipo -->
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Digite o tipo" required>
            </div>

            <!-- Combustível -->
            <div class="mb-3">
                <label for="combustivel" class="form-label">Combustível</label>
                <input type="text" class="form-control" id="combustivel" name="combustivel" placeholder="Digite o tipo de combustível" required>
            </div>

            <!-- Chassi -->
            <div class="mb-3">
                <label for="chassi" class="form-label">Chassi</label>
                <input type="text" class="form-control" id="chassi" name="chassi" placeholder="Digite o chassi" required>
            </div>

            <!-- Renavan -->
            <div class="mb-3">
                <label for="renavan" class="form-label">Renavan</label>
                <input type="text" class="form-control" id="renavan" name="renavan" placeholder="Digite o Renavan" required>
            </div>

            <!-- Observação -->
            <div class="mb-3">
                <label for="observacao" class="form-label">Observação</label>
                <textarea class="form-control" id="observacao" name="observacao" rows="3" placeholder="Digite uma observação"></textarea>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="">Selecione o status</option>
                    <option value="disponivel">Disponível</option>
                    <option value="reservado">Reservado</option>
                    <option value="manutencao">Em Manutenção</option>
                    <option value="vendido">Vendido</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
