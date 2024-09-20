CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    cpf VARCHAR(14),
    endereco VARCHAR(255),
    email VARCHAR(100),
    telefone VARCHAR(20)
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    cookies TEXT,
    status VARCHAR(50) DEFAULT 'Pendente', -- Pode ser 'Concluído' ou 'Pendente'
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);
