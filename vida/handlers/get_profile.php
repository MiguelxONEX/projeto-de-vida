<?php
require_once '../config/auth.php';

if (!isLoggedIn()) {
    echo json_encode(["success" => false, "message" => "Usuário não está logado"]);
    exit;
}

try {
    global $conn;
    $stmt = $conn->prepare("SELECT name, email, age, profile_image FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo json_encode(["success" => true, "data" => $user]);
    } else {
        echo json_encode(["success" => false, "message" => "Usuário não encontrado"]);
    }
} catch(PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro ao buscar dados: " . $e->getMessage()]);
}
?>
