<?php
// excluir.php - Lógica de Exclusão (DELETE)

require_once 'src/Venda.php';
$vendaObj = new Venda();

// 1. Coleta o ID da URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$mensagem = '';

if ($id) {
    // 2. Executa a exclusão
    if ($vendaObj->excluir($id)) {
        $mensagem = "Venda ID {$id} excluída com sucesso!";
    } else {
        $mensagem = "Erro ao excluir a venda ID {$id} ou ID não encontrado.";
    }
} else {
    $mensagem = "ID de venda inválido.";
}

// Redireciona de volta para a lista, com a mensagem de status
header('Location: listar.php?sucesso=' . urlencode($mensagem));
exit();
?>
