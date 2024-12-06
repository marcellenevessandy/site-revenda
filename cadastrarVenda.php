<?php
// Inclua os arquivos necessários (conexão com o banco de dados, classes Cliente e Veiculo)
include_once './config/config.php'; // Arquivo com a configuração de conexão ao banco
include_once './classes/Cliente.php';
include_once './classes/Veiculo.php';
include_once './classes/Venda.php'; // Crie uma classe para gerenciar as vendas

$cliente = new Cliente($);
$veiculo = new Veiculo($conn);
$venda = new Venda($conn); // Supondo que a classe Venda foi criada para gerenciar vendas

// Variáveis para armazenar dados recebidos
$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $clienteId = $_POST['cliente-id'];
    $veiculoId = $_POST['veiculo-id'];
    $dataVenda = $_POST['data_venda'];
    $desconto = $_POST['desconto'] ?? 0;  // Desconto, caso o usuário tenha fornecido
    $formaPagamento = $_POST['forma_pagamento'];
    $descricao = $_POST['descricao'];

    // Recupera os dados do cliente e veículo
    $clienteInfo = $cliente->buscarPorId($clienteId);
    $veiculoInfo = $veiculo->buscarPorId($veiculoId);

    // Calcula o preço com desconto
    $precoFinal = $veiculoInfo['preco'] - ($veiculoInfo['preco'] * ($desconto / 100));

    // Cria a venda no banco de dados
    $vendaCriada = $venda->cadastrarVenda($clienteId, $veiculoId, $dataVenda, $precoFinal, $formaPagamento, $descricao);
    
    if ($vendaCriada) {
        $mensagem = "Venda registrada com sucesso!";
    } else {
        $mensagem = "Erro ao registrar a venda.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Venda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Cadastrar Venda</h2>
    <?php if ($mensagem) { ?>
        <div class="alert alert-info"><?php echo $mensagem; ?></div>
    <?php } ?>
    
    <form method="POST" action="cadastrarVenda.php">
        <!-- Cliente -->
        <div class="mb-3">
            <label for="cliente" class="form-label">Cliente (Nome ou CPF)</label>
            <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Digite o nome ou CPF" onkeyup="searchCliente()">
            <input type="hidden" id="cliente-id" name="cliente-id">
            <div id="cliente-results" class="list-group"></div>
        </div>
        
        <!-- Veículo -->
        <div class="mb-3">
            <label for="veiculo" class="form-label">Veículo (Placa)</label>
            <input type="text" class="form-control" id="veiculo" name="veiculo" placeholder="Digite a placa do veículo" onkeyup="searchVeiculo()">
            <input type="hidden" id="veiculo-id" name="veiculo-id">
            <div id="veiculo-results" class="list-group"></div>
        </div>

        <!-- Data da Venda -->
        <div class="mb-3">
            <label for="data_venda" class="form-label">Data da Venda</label>
            <input type="date" class="form-control" id="data_venda" name="data_venda" required>
        </div>

        <!-- Desconto -->
        <div class="mb-3">
            <label for="desconto" class="form-label">Desconto (%)</label>
            <input type="number" class="form-control" id="desconto" name="desconto" min="0" max="100" value="0">
        </div>

        <!-- Forma de Pagamento -->
        <div class="mb-3">
            <label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
            <select class="form-control" id="forma_pagamento" name="forma_pagamento" required>
                <option value="pix">PIX</option>
                <option value="dinheiro">Dinheiro</option>
                <option value="boleto">Boleto</option>
                <option value="cartao_credito">Cartão de Crédito</option>
                <option value="cartao_debito">Cartão de Débito</option>
            </select>
        </div>

        <!-- Descrição -->
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Venda</button>
    </form>
</div>

<script>
    // Função para pesquisa de cliente
    function searchCliente() {
        let search = document.getElementById('cliente').value;
        if (search.length > 2) {
            fetch(`cadastrarVenda.php?search_cliente=${search}`)
                .then(response => response.json())
                .then(data => {
                    let results = document.getElementById('cliente-results');
                    results.innerHTML = '';  // Limpar resultados anteriores
                    if (data.length > 0) {
                        data.forEach(cliente => {
                            let item = document.createElement('div');
                            item.classList.add('list-group-item');
                            item.textContent = `${cliente.nome} - ${cliente.cpf}`;
                            item.onclick = () => selectCliente(cliente);
                            results.appendChild(item);
                        });
                    } else {
                        results.innerHTML = '<div class="list-group-item">Nenhum cliente encontrado.</div>';
                    }
                });
        }
    }

    function selectCliente(cliente) {
        document.getElementById('cliente').value = cliente.nome;
        document.getElementById('cliente-id').value = cliente.id;  // Salvar ID do cliente
        document.getElementById('cliente-results').innerHTML = '';  // Limpar sugestões
    }

    // Função para pesquisa de veículo
    function searchVeiculo() {
        let search = document.getElementById('veiculo').value;
        if (search.length > 2) {
            fetch(`cadastrarVenda.php?search_veiculo=${search}`)
                .then(response => response.json())
                .then(data => {
                    let results = document.getElementById('veiculo-results');
                    results.innerHTML = '';  // Limpar resultados anteriores
                    if (data.length > 0) {
                        data.forEach(veiculo => {
                            let item = document.createElement('div');
                            item.classList.add('list-group-item');
                            item.textContent = `${veiculo.placa} - ${veiculo.modelo}`;
                            item.onclick = () => selectVeiculo(veiculo);
                            results.appendChild(item);
                        });
                    } else {
                        results.innerHTML = '<div class="list-group-item">Nenhum veículo encontrado.</div>';
                    }
                });
        }
    }

    function selectVeiculo(veiculo) {
        document.getElementById('veiculo').value = veiculo.placa;
        document.getElementById('veiculo-id').value = veiculo.id;  // Salvar ID do veículo
        document.getElementById('veiculo-results').innerHTML = '';  // Limpar sugestões
    }
</script>
</body>
</html>
