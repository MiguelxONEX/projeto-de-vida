<?php
$db = new SQLite3('soueu.db');

// Cria a tabela com apenas 1 linha permitida
$db->exec("CREATE TABLE IF NOT EXISTS SouEu (
    id INTEGER PRIMARY KEY CHECK (id = 1),
    descricao TEXT
)");

$descricao = $_POST['descricao'] ?? '';

// Insere ou atualiza o único registro (id = 1)
$stmt = $db->prepare("INSERT INTO SouEu (id, descricao) VALUES (1, :descricao)
                      ON CONFLICT(id) DO UPDATE SET descricao = excluded.descricao");
$stmt->bindValue(':descricao', $descricao, SQLITE3_TEXT);
$result = $stmt->execute();

echo $result ? "Descrição pessoal salva com sucesso!" : "Erro ao salvar.";
?>
