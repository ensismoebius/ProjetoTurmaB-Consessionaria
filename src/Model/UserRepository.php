<?php

namespace Concessionaria\Projetob\Model;

use PDO;
use Concessionaria\Projetob\Model\Usuario;

class UserRepository
{
    private PDO $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function loadUserById(int $id): ?Usuario
    {
        $stmt = $this->conexao->prepare("SELECT id, nome, email, senha, role FROM USUARIOS WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Usuario::class);
        $usuario = $stmt->fetch();

        if ($usuario instanceof Usuario) {
            return $usuario;
        }

        return null;
    }

    public function existeEmail(string $email): bool
    {
        $stmt = $this->conexao->prepare("SELECT id FROM USUARIOS WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function criar(string $nome, string $email, string $senha, int $role): bool
    {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $this->conexao->prepare(
            "INSERT INTO USUARIOS (nome, email, senha, role) VALUES (:nome, :email, :senha, :role)"
        );
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":senha", $senhaHash);
        $stmt->bindValue(":role", $role);

        return $stmt->execute();
    }
}
