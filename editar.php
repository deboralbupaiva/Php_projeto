<?php
// editar.php - Lógica de Atualização (UPDATE)

require_once 'src/Venda.php';
$vendaObj = new Venda();
$mensagem = '';
$venda = null;

// 1. Receber o ID da URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    // Se não tiver ID válido, redireciona de volta
    header('Location: listar.php');
    exit();
}

// Lógica para submissão do formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta dados POST
    $id_post = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nome_produto = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_STRING);
    $quantidade_vendida = filter_input(INPUT_POST, 'quantidade_vendida', FILTER_VALIDATE_INT);
    $data_venda = filter_input(INPUT_POST, 'data_venda', FILTER_SANITIZE_STRING);

    if ($id_post && $nome_produto && $quantidade_vendida && $data_venda) {
        // Executa a atualização
        if ($vendaObj->atualizar($id_post, $nome_produto, $quantidade_vendida, $data_venda)) {
            $mensagem = "Venda ID {$id_post} atualizada com sucesso!";
            // Redireciona para a listagem
            header('Location: listar.php?sucesso=' . urlencode($mensagem));
            exit();
        } else {
            $mensagem = "Erro ao atualizar a venda.";
        }
    } else {
        $mensagem = "Dados inválidos para a atualização.";
    }
}

// 2. Carregar os dados atuais da venda (para preencher o formulário)
$venda = $vendaObj->lerPorId($id);

if (!$venda) {
    $mensagem = "Venda não encontrada.";
    // Se não encontrar, redireciona e exibe a mensagem de erro (opcional)
    header('Location: listar.php?erro=' . urlencode($mensagem));
    exit();
}

?>
</html>
