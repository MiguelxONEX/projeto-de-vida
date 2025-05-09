<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$db   = 'projeto_vida'; // Nome do banco
$user = 'root';          // Substitua se for diferente
$pass = '';              // Substitua se necessário
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['texto_soueu'])) {
        $texto = $_POST['texto_soueu'];

        $stmt = $pdo->prepare("INSERT INTO textos_soueu (texto) VALUES (:texto)");
        $stmt->bindParam(':texto', $texto);

        $stmt->execute();

        echo "<script>alert('Enviado com sucesso!'); window.location.href='soueu.html';</script>";
    } else {
        echo "<script>alert('Texto vazio ou requisição inválida.'); window.location.href='soueu.html';</script>";
    }
} catch (PDOException $e) {
    echo "<script>alert('Erro no banco de dados: " . $e->getMessage() . "'); window.location.href='soueu.html';</script>";
}
?>
