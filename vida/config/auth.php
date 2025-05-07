<?php
session_start();
require_once 'db_connect.php';

// Função para cadastrar usuário
function registerUser($name, $email, $password) {
    global $conn;
    try {
        // Verifica se o email já existe
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            return ["success" => false, "message" => "Email já cadastrado"];
        }

        // Hash da senha
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insere o novo usuário
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);

        return ["success" => true, "message" => "Cadastro realizado com sucesso"];
    } catch(PDOException $e) {
        return ["success" => false, "message" => "Erro ao cadastrar: " . $e->getMessage()];
    }
}

// Função para login
function loginUser($email, $password) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                return ["success" => true, "message" => "Login realizado com sucesso"];
            }
        }
        return ["success" => false, "message" => "Email ou senha incorretos"];
    } catch(PDOException $e) {
        return ["success" => false, "message" => "Erro ao fazer login: " . $e->getMessage()];
    }
}

// Função para atualizar perfil
function updateProfile($userId, $name, $email, $age, $profileImage = null) {
    global $conn;
    try {
        $sql = "UPDATE users SET name = ?, email = ?, age = ?";
        $params = [$name, $email, $age];

        if ($profileImage) {
            $sql .= ", profile_image = ?";
            $params[] = $profileImage;
        }

        $sql .= " WHERE id = ?";
        $params[] = $userId;

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return ["success" => true, "message" => "Perfil atualizado com sucesso"];
    } catch(PDOException $e) {
        return ["success" => false, "message" => "Erro ao atualizar perfil: " . $e->getMessage()];
    }
}

// Função para verificar se usuário está logado
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Função para fazer logout
function logout() {
    session_destroy();
    return ["success" => true, "message" => "Logout realizado com sucesso"];
}
?>
