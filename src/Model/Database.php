<?php

namespace Concessionaria\Projetob\Model;
use PDO;
use PDOException;

class Database
{
    private static ?PDO $conexao = null;
    private static string $host = "localhost";
    private static string $dbname = "PRJ2DSB";
    private static string $usuario = "root";
    private static string $senha = "";
    private static string $charset = "utf8mb4";

    public static function getConexao(): PDO
    {
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

    public static function loadUserById(int $id): ?Usuario
    {
        $stmt = self::getConexao()->prepare("SELECT id, nome, email, senha FROM USUARIOS WHERE id = :id"); //crie uma query para procurar o id
        $stmt->bindValue(":id", $id, PDO::PARAM_INT); //substitui o valor do id na query
        $stmt->execute(); //executa

        $usuario = $stmt->fetchObject(Usuario::class); //transforma o resultado da consulta em um objeto da classe Usuario com os dados do banco

        if ($usuario) { //se existir o usuário retorna o usuário
            return $usuario;
        }

        return null;
    }

    public static function existeEmail(string $email): bool
    {
        $stmt = self::getConexao()->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public static function criar(string $nome, string $email, string $senha): bool
    {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = self::getConexao()->prepare(
            "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)"
        );
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":senha", $senhaHash);

        return $stmt->execute();
    }
}