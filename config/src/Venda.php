<?php
// src/Venda.php

// Inclui o arquivo de conexão
require_once __DIR__ . '/../config/Conexao.php';

class Venda {
    private $pdo;
    private $tabela = 'vendas';

    // Construtor: obtém a conexão PDO ao criar um objeto Venda
    public function __construct() {
        $this->pdo = Conexao::getConexao();
    }

    // --- CREATE (Criar uma nova venda) ---
    public function criar($nome_produto, $quantidade_vendida, $data_venda) {
        // Usando Prepared Statements com placeholders nomeados (:nome, :qtd, :data)
        $sql = "INSERT INTO {$this->tabela} (nome_produto, quantidade_vendida, data_venda) 
                VALUES (:nome, :qtd, :data)";
        
        $stmt = $this->pdo->prepare($sql);
        
        // Bind dos parâmetros: Proteção contra SQL Injection
        $stmt->bindParam(':nome', $nome_produto);
        $stmt->bindParam(':qtd', $quantidade_vendida, PDO::PARAM_INT);
        $stmt->bindParam(':data', $data_venda);
        
        return $stmt->execute();
    }

    // --- READ (Listar todas as vendas) ---
    public function lerTodas() {
        $sql = "SELECT id, nome_produto, quantidade_vendida, DATE_FORMAT(data_venda, '%d/%m/%Y') AS data_formatada 
                FROM {$this->tabela} 
                ORDER BY data_venda DESC, id DESC";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // --- READ (Buscar uma venda específica) ---
    public function lerPorId($id) {
        $sql = "SELECT id, nome_produto, quantidade_vendida, data_venda 
                FROM {$this->tabela} 
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(); // Retorna apenas uma linha
    }

    // --- UPDATE (Atualizar uma venda) ---
    public function atualizar($id, $nome_produto, $quantidade_vendida, $data_venda) {
        $sql = "UPDATE {$this->tabela} 
                SET nome_produto = :nome, quantidade_vendida = :qtd, data_venda = :data 
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        
        // Bind dos parâmetros
        $stmt->bindParam(':nome', $nome_produto);
        $stmt->bindParam(':qtd', $quantidade_vendida, PDO::PARAM_INT);
        $stmt->bindParam(':data', $data_venda);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // --- DELETE (Excluir uma venda) ---
    public function excluir($id) {
        $sql = "DELETE FROM {$this->tabela} WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // --- Dados para o GRÁFICO (Totalização com GROUP BY) ---
    public function lerTotalVendasPorProduto() {
        $sql = "SELECT nome_produto, SUM(quantidade_vendida) AS total_vendido 
                FROM {$this->tabela} 
                GROUP BY nome_produto 
                ORDER BY total_vendido DESC";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
}
?>
