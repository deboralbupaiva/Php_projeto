<?php
// registrar.php - Lógica de Criação (CREATE)

// Inclui a classe Venda
require_once 'src/Venda.php';
$vendaObj = new Venda();
$mensagem = '';

// Verifica se o formulário foi submetido (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Coleta e sanitiza os dados
    $nome_produto = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_STRING);
    $quantidade_vendida = filter_input(INPUT_POST, 'quantidade_vendida', FILTER_VALIDATE_INT);
    $data_venda = filter_input(INPUT_POST, 'data_venda', FILTER_SANITIZE_STRING);
    
    // 2. Validação simples
    if ($nome_produto && $quantidade_vendida && $data_venda) {
        // 3. Executa a inserção no banco
        if ($vendaObj->criar($nome_produto, $quantidade_vendida, $data_venda)) {
            $mensagem = "Venda de '{$nome_produto}' registrada com sucesso!";
            // Redireciona para a listagem para evitar reenvio do formulário
            header('Location: listar.php?sucesso=' . urlencode($mensagem));
            exit();
        } else {
            $mensagem = "Erro ao registrar a venda.";
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos corretamente.";
    }
}
?>
</html>
