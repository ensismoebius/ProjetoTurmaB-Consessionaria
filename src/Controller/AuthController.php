<?php

    namespace Concessionaria\Projetob\Controller;
    use PDO;
    use Concessionaria\Projetob\Model\Usuario;

    class AuthController
{

    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;
    private \PDO $conexao;

    public function __construct()
    {
        $this->carregador = new \Twig\Loader\FilesystemLoader("./src/View/auth");
 
        $this->ambiente = new \Twig\Environment($this->carregador);

     }  

    public function showRegisterForm(){
       echo $this->ambiente->render("register.html");
    }

    public function register(){
        $nome = $_POST['Nome_Usuario'] ?? '';
        $email = $_POST['Email_Usuario'] ?? '';
        $senha = $_POST['Senha_Usuario'] ?? '';

    if (empty($nome) || empty($email) || empty($senha)) {
        echo "Preencha todos os campos.";
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "E-mail inválido.";
        return;
    }

    $conexao = new PDO("mysql:host=192.168.0.12;dbname=PRJ2DSB", "Aluno2DS", "SenhaBD2");

    $user = new Usuario($conexao);

    if ($user->existeEmail($email)) {
        header("Location: /ProjetoTurmaB-Consessionaria/register");
        return;
    }

    if ($user->criar($nome, $email, $senha)) {
        header("Location: /ProjetoTurmaB-Consessionaria/");
    } else {
        echo "Erro ao cadastrar usuário.";
    }
}

    public function showLoginForm(){
       echo $this->ambiente->render("login.html");
    }

    public function login(){
        $email = $_POST['Email_Usuario'] ?? '';
        $senha = trim($_POST['Senha_Usuario'] ?? '');

        if (empty($email) || empty($senha)) {
            echo "Preencha todos os campos.";
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "E-mail inválido.";
            return;
        }

        try {
            $this->conexao = new \PDO("mysql:host=192.168.0.12;dbname=PRJ2DSB", "Aluno2DS", "SenhaBD2");
            $this->conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Erro ao conectar ao banco de dados.";
            return;
        }


        $stmt = $this->conexao->prepare("SELECT senha FROM USUARIOS WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        

        if($usuario && password_verify($senha,$usuario['senha'])){
            session_start();
            header("Location: http://localhost/ProjetoTurmaB-Consessionaria/");
            $_SESSION["user_id"] = $usuario['id'];
            exit;
        } else {
            echo "Senha inválida.";
            return;
        }
    }

    public function Logout(){
        session_start();
        session_destroy();
        header("Location: http://localhost/ProjetoTurmaB-Consessionaria/login");
        exit;
     }
    
    public function is_logged_in(){
        if(isset($_SESSION["user_id"])){
            return true;
        } else{
            return false;
        }
     }

    public function auth_middleware(){
        if(false === $this->is_logged_in()){
            header("Location: http://localhost/ProjetoTurmaB-Consessionaria/login");
            exit;
        } else {
            header("Location: http://localhost/ProjetoTurmaB-Consessionaria/");
            exit;
        }
    }
}
?>
