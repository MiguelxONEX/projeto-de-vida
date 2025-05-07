<?php
require_once '../config/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Email e senha são obrigatórios"]);
        exit;
    }

    $result = loginUser($email, $password);
    if ($result['success']) {
        // Redireciona para a página inicial após login bem-sucedido
        header('Location: ../index.html');
        exit;
    } else {
        echo json_encode($result);
    }
}
?>
