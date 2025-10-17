<?php
// listar.php - Lógica de Leitura (READ)

require_once 'src/Venda.php';
$vendaObj = new Venda();

// Busca todos os registros de venda no banco
$vendas = $vendaObj->lerTodas();

// Verifica se há mensagem de sucesso (vindo do registrar.php ou editar.php)
$mensagem = '';
if (isset($_GET['sucesso'])) {
    $mensagem = htmlspecialchars($_GET['sucesso']);
}
?>
