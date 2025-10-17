<?php
// config/Conexao.php

class Conexao {
    private static $host = "localhost"; // Geralmente 'localhost'
    private static $dbname = "controle_vendas_db"; // O nome do seu banco de dados
    private static $user = "root"; // Usuário do seu MySQL/MariaDB
    private static $password = ""; // Senha do seu MySQL/MariaDB (Geralmente vazia no XAMPP/WAMP)

    // A variável que vai guardar a instância da conexão PDO
    private static $instance = null;

    // O construtor é privado para garantir que a classe só possa ser instanciada por ela mesma (Singleton)
    private function __construct() {
        // Nada a fazer aqui
    }

    // Método estático para obter a conexão
    public static function getConexao() {
        // Se a conexão ainda não existe, cria uma nova
        if (self::$instance == null) {
            try {
                // String de conexão DSN (Data Source Name)
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8mb4";
                
                // Cria a instância PDO
                self::$instance = new PDO($dsn, self::$user, self::$password);
                
                // Configurações para tratamento de erros (muito importante!)
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Configuração para buscar dados como array associativo por padrão
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                // Se a conexão falhar, paramos a aplicação e mostramos a mensagem de erro.
                die("Erro na conexão com o banco de dados: " . $e->getMessage());
            }
        }
        // Retorna a conexão existente
        return self::$instance;
    }
}
?>
