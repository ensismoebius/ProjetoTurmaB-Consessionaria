<?php
namespace Concessionaria\Projetob\Model;

class Usuario
{
    public int $id;
    public string $nome;
    public string $email;
    public string $senha;
    public int $role;

    private \PDO $conexao;

    public function __construct(PDO $conexao){
        $this->conexao = $conexao;
    }

    public function existeEmail(string $email): bool
    {
        $stmt = $this->conexao->prepare("SELECT id FROM USUARIOS WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function criar(string $nome, string $email, string $senha): bool
    {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $this->conexao->prepare(
            "INSERT INTO USUARIOS (nome, email, senha) VALUES (:nome, :email, :senha)"
        );
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":senha", $senhaHash);

        return $stmt->execute();
    }
}
