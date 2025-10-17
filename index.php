<?php
// index.php - Dashboard e Geração do Gráfico

require_once 'src/Venda.php';
$vendaObj = new Venda();

// 1. Consulta os dados totalizados
// Retorna um array como: 
// [ ['nome_produto' => 'Notebook Gamer', 'total_vendido' => 8], ... ]
$dados_vendas = $vendaObj->lerTotalVendasPorProduto();

// 2. Prepara os dados para o Chart.js
// Vamos criar dois arrays, um para os rótulos (nomes) e outro para os valores (quantidades)
$labels = [];
$data = [];

foreach ($dados_vendas as $venda) {
    $labels[] = $venda['nome_produto'];
    // JSON_NUMERIC_CHECK garante que números sejam passados como números, não strings
    $data[] = (int)$venda['total_vendido'];
}

// 3. Converte os arrays PHP para strings JSON
// Essa é a etapa crucial de comunicação entre PHP e JavaScript
$labels_json = json_encode($labels);
$data_json = json_encode($data, JSON_NUMERIC_CHECK);

?>
