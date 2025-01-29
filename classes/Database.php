<?php
class Database {
    private $host = "mysql.marcellesandy.com.br"; // ou o endereço do seu banco de dados
    private $db_name = "marcellesandy";
    private $username = "marcellesa_add1";
    private $password = "banco123";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // Define opções de conexão PDO
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lança exceções em caso de erro
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" // Configura codificação UTF-8
            ];

            // Cria conexão PDO
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password,
                $options
            );
        } catch(PDOException $exception) {
            // Loga o erro para depuração
            error_log("Erro de conexão: " . $exception->getMessage());
            
            // Lança uma exceção para interromper a execução
            throw new Exception("Não foi possível conectar ao banco de dados. Por favor, contate o administrador.");
        }

        return $this->conn;
    }
}
?>
