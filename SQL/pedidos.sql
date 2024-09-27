CREATE DATABASE cookiessa;

USE cookiessa;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco VARCHAR(255),
    numero VARCHAR(10),
    complemento VARCHAR(100),
    cep VARCHAR(10)
) DEFAULT CHARSET = utf8;

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    cookies TEXT,
    status VARCHAR(50) DEFAULT 'Pendente',
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_recebimento DATETIME,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
) DEFAULT CHARSET = utf8;


