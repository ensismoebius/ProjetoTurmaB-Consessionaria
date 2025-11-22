<?php

    namespace Concessionaria\Projetob\Controller;
    use PDO;
    use Concessionaria\Projetob\Model\Usuario;
    use Concessionaria\Projetob\Model\UserRepository;
    use Concessionaria\Projetob\Model\Database; 

    class AuthController
{

    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;
    private \PDO $conexao;

    public function __construct()
    {
        $this->carregador = new \Twig\Loader\FilesystemLoader("./src/View/auth");
        $this->ambiente = new \Twig\Environment($this->carregador);
        $this->conexao = Database::getConexao();
    }

    public function showRegisterForm(){
           session_start();
       $tipo_msg = $_SESSION['tipo_msg'] ?? null;
       $msg = $_SESSION['msg'] ?? null;

       unset($_SESSION['tipo_msg'], $_SESSION['msg']);

       echo $this->ambiente->render("register.html", [
           'tipo_msg' => $tipo_msg,
           'msg' => $msg,
       ]);
    }

    public function register(){
            session_start();
        $nome = trim($_POST['Nome_Usuario'] ?? '');
        $email = trim($_POST['Email_Usuario'] ?? '');
        $senha = $_POST['Senha_Usuario'] ?? '';

<<<<<<< Updated upstream
        if (empty($nome) || empty($email) || empty($senha)) {
            echo $this->ambiente->render('register.html', [
                'tipo_msg' => 'erro',
                'msg' => 'Preencha todos os campos.',
                'nome' => $nome,
                'email' => $email,
            ]);
=======
    if (empty($nome) || empty($email) || empty($senha)) {
        echo "Preencha todos os campos.";
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "E-mail inválido.";
        return;
    }

    $conexao = new PDO("mysql:host=localhost;dbname=PRJ2DSB", "root", "");

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
>>>>>>> Stashed changes
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo $this->ambiente->render('register.html', [
                'tipo_msg' => 'erro',
                'msg' => 'E-mail inválido.',
                'nome' => $nome,
                'email' => $email,
            ]);
            return;
        }

        $user = new UserRepository($this->conexao);

        if ($user->existeEmail($email)) {
            echo $this->ambiente->render('register.html', [
                'tipo_msg' => 'erro',
                'msg' => 'E-mail já cadastrado.',
                'nome' => $nome,
                'email' => $email,
            ]);
            return;
        }

        if ($user->criar($nome, $email, $senha)) {
            $_SESSION['tipo_msg'] = 'sucesso';
            $_SESSION['msg'] = 'Cadastro concluído com sucesso.';
            header('Location: /ProjetoTurmaB-Consessionaria/login');
            exit;
        } else {
            echo $this->ambiente->render('register.html', [
                'tipo_msg' => 'erro',
                'msg' => 'Erro ao cadastrar usuário.',
                'nome' => $nome,
                'email' => $email,
            ]);
        }
    }

    public function showLoginForm(){
           session_start();
       $tipo_msg = $_SESSION['tipo_msg'] ?? null;
       $msg = $_SESSION['msg'] ?? null;

       unset($_SESSION['tipo_msg'], $_SESSION['msg']);

       echo $this->ambiente->render("login.html", [
           'tipo_msg' => $tipo_msg,
           'msg' => $msg,
       ]);
    }
    
    public function login(){
        session_start();
        
        $email = $_POST['Email_Usuario'] ?? '';
        $senha = trim($_POST['Senha_Usuario'] ?? '');

        if (empty($email) || empty($senha)) {
            $_SESSION['tipo_msg'] = 'erro';
            $_SESSION['msg'] = 'Preencha todos os campos.';
            header('Location: /ProjetoTurmaB-Consessionaria/login');
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['tipo_msg'] = 'erro';
            $_SESSION['msg'] = 'E-mail inválido.';
            header('Location: /ProjetoTurmaB-Consessionaria/login');
            exit();
        }

        $this->conexao = Database::getConexao();

        $stmt = $this->conexao->prepare("SELECT id, senha FROM USUARIOS WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if($usuario && password_verify($senha, $usuario['senha'])){
            $_SESSION["user_id"] = $usuario['id'];
            header("Location: /ProjetoTurmaB-Consessionaria/");
            exit();
        }
        
        $_SESSION['tipo_msg'] = 'erro';
        $_SESSION['msg'] = 'E-mail ou senha inválidos.';
        header('Location: /ProjetoTurmaB-Consessionaria/login');
        exit();
    }

    public function logout(){
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

    public function salvarVeiculos() {
    $id = $_POST['id'] ?? null;
    $marca = $_POST['marca'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $imagem = null;

    
    if (!empty($_FILES['imagem']['name'])) {
        $pasta = './uploads/';
        if (!is_dir($pasta)) mkdir($pasta, 0777, true);
        $arquivo = $pasta . basename($_FILES['imagem']['name']);
        move_uploaded_file($_FILES['imagem']['tmp_name'], $arquivo);
        $imagem = $arquivo;
    }
    }
}
?>
