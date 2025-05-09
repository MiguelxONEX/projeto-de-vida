CREATE TABLE profissoes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_profissao VARCHAR(100) NOT NULL,
    descricao TEXT,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);