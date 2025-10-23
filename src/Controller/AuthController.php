<?php
    namespace Concessionaria\Projetob\Controller;
    use Concessionaria\Projetob\Model\user;

    class AuthController
{
     private \Twig\Environment $ambiente;
     private \Twig\Loader\FilesystemLoader $carregador;

     public function __construct()
     {
        $this->carregador = new \Twig\Loader\FilesystemLoader("./src/View");
 
        $this->ambiente = new \Twig\Environment($this->carregador);

     }  

     public function showRegisterForm(){
        $this->ambiente->render("Location: register.html");
     }

     public function register(){
        $nome = $_GET['nome'];
        $email = $_GET['email'];
        $senha = $_GET['senha'];

        if(isset($nome) && isset($email) && isset($senha)){
            if(!empty($nome) || !empty($email) || !empty($senha)){
                $cSQL = "SELECT * FROM USUARIOS WHERE $nome = nome";
                $cSQL = "SELECT * FROM USUARIOS WHERE $email = email";
                if(empty($cSQL)){
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "O endereço de e-mail é válido.";
                    } else {
                        echo "O endereço de e-mail é inválido.";
                    }
                    if($this->validarSenha($senha) === true){
                        password_hash($senha, PASSWORD_DEFAULT);
                        require_once 'user.php';

                        $userModel = new user($pdo);

                        $userData = [
                            'nome' => $_POST['nome'] ?? '',
                            'email' => $_POST['email'] ?? '',
                            'senha' => $_POST['senha'] ?? ''
                        ];

                        if ($userModel->create($userData)) {
                            
                            echo "Usuário cadastrado com sucesso!";
                        } else {
                            
                            $errors[] = "Ocorreu um erro ao cadastrar o usuário. Tente novamente.";
                        }
                }
            }
        }
     }
}

     public function Logout(){
        session_start();
        session_destroy();
        header("Location: login.html");
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
            header("Location: login.html");
            exit;
        } else{
            header("Location: inicio.html");
            exit;
        }
     }

    public function validarSenha($senha) {
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/';
    
        if (preg_match($regex, $senha)) {
            return true;
        } else {
            return false;
        }
    }
}
?>