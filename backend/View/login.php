<?php
session_start();
require_once __DIR__ . '/../../config.php'; // Caminho correto para o config.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Buscar usuário no banco de dados
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Login bem-sucedido - iniciar sessão
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $email;

        echo "<p>Login realizado com sucesso! Redirecionando...</p>";
        header("refresh:2; url=user.php"); // Redireciona após 2 segundos
        exit;
    } else {
        echo "<p style='color: red;'>E-mail ou senha incorretos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">

    <title>Pagina de login</title>
</head>

<body>
<div class="main">
        <div class="titulo">
            <h1>Projeto</h1> <label> de vida </label>
        </div>
        <h3>Vinicius Mendes</h3>
        <div class="login-container">
            <div class="login-box">
                <h1 class="login">Login</h1>
                <form method="POST">
                    <h6>E-mail</h6>
                    <input type="text" name="email" placeholder="Email " required>
                    <H5>Senha</H5>
                    <input type="password" name="password" placeholder="Senha" required>
                    <?php
                    if (isset($logged_in) && empty($logged_in)) {
                        echo "usuário ou senha estão errados, tente novamente!";
                    }

                    ?>
                    <button type="submit" class="login-btn">Entrar</button>
                    <p class="signup-text"><a href='Esqueci_senha.php'>Esqueci minha senha!</a></p>

                        <h3>ou</h3>
                        <h3>logue com o Google</h3>
                            <div class="google">
                                <script src="https://accounts.google.com/gsi/client" async></script>
                                <div id="g_id_onload"
                                    data-client_id="659345250941-hp6n6p2g45ogrgt0noqplur9tegi36vo.apps.googleusercontent.com"
                                    data-login_uri="http://localhost/Projeto-de-vida/login-google/includes/login.php"
                                    data-auto_prompt="false">
                                </div>
                            </div>
                            <div class="g_id_signin"
                                data-type="standard"
                                data-size="large"
                                data-theme="outline"
                                data-text="sign_in_with"
                                data-shape="rectangular"
                                data-logo_alignment="left">

                            </div>
                </form>
            </div>
        </div>
        <div>
            <p class="signup-text" style="color: #FFF">Não tem uma conta? <a href="register.php">Cadastre-se agora mesmo</a></p>
        </div>
    </div>

    </div>
    </div>
</body>

</html>