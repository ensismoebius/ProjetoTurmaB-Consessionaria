<?php

namespace Concessionaria\Projetob\Model;
use PDO;
use PDOException;

class Database
{
    private static ?PDO $conexao = null;
      private static string $charset = "utf8mb4";

    
    //private static string $host = "192.168.0.12";
    //private static string $dbname = "PRJ2DSB";
    //private static string $usuario = "Aluno2DS";
    //private static string $senha = "SenhaBD2";

    // // Configurações de ambiente local (para usar em casa)
     private static string $host = 'localhost';
     private static string $dbname = 'concessionaria';
     private static string $usuario = 'root';
     private static string $senha = '';

    private static function initializeConfig(): void
    {
        if (empty(self::$host)) {
            self::$host = $_ENV['DB_HOST'];
            self::$dbname = $_ENV['DB_NAME'];
            self::$usuario = $_ENV['DB_USER'];
            self::$senha = $_ENV['DB_PASS'];
        }
    }

    public static function getConexao(): PDO
    {
        self::initializeConfig();

        if (self::$conexao === null) {

            $dsn = "mysql:host=" . self::$host .
                ";dbname=" . self::$dbname .
                ";charset=" . self::$charset;

            try {
                self::$conexao = new PDO($dsn, self::$usuario, self::$senha, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_PERSISTENT => false
                ]);
            } catch (PDOException $e) {
                throw new \Exception("Falha ao conectar ao banco", 500);
            }
        }

        return self::$conexao;
    }

}