<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$db   = 'projeto_vida';
$user = 'root';  // altere conforme seu ambiente
$pass = '';      // altere conforme seu ambiente
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['profissao_texto'])) {
        $texto = $_POST['profissao_texto'];

        $stmt = $pdo->prepare("INSERT INTO textos_profissao (texto) VALUES (:texto)");
        $stmt->bindParam(':texto', $texto);

        $stmt->execute();

        echo "<script>alert('Enviado com sucesso!'); window.location.href='profissao.html';</script>";
    } else {
        echo "<script>alert('Texto vazio ou requisição inválida.'); window.location.href='profissao.html';</script>";
    }
} catch (PDOException $e) {
    echo "<script>alert('Erro no banco de dados: " . $e->getMessage() . "'); window.location.href='profissao.html';</script>";
}
?>
