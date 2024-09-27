<?php
$dbHost = 'Localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'cookiessa';

// Conectando
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Receber dados do formulário
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$endereco = $_POST['endereco'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];

// Sabores e quantidades
$quantidade_sabor1 = $_POST['quantidade_sabor1'];
$quantidade_sabor2 = $_POST['quantidade_sabor2'];
$quantidade_sabor3 = $_POST['quantidade_sabor3'];
$quantidade_sabor4 = $_POST['quantidade_sabor4'];
$quantidade_sabor5 = $_POST['quantidade_sabor5'];
$quantidade_sabor6 = $_POST['quantidade_sabor6'];
$quantidade_sabor7 = $_POST['quantidade_sabor7'];

// Montar string com os cookies e quantidades
$cookies = "Sabor 1: $quantidade_sabor1, Sabor 2: $quantidade_sabor2, Sabor 3: $quantidade_sabor3, Sabor 4: $quantidade_sabor4, Sabor 5: $quantidade_sabor5, Sabor 6: $quantidade_sabor6, Sabor 7: $quantidade_sabor7";

// Inserir dados na tabela clientes
$sql_cliente = "INSERT INTO clientes (nome, cpf, telefone, email, endereco, numero, complemento) VALUES ('$nome', '$cpf', '$telefone', '$email', '$endereco', '$numero', '$complemento')";

if ($conn->query($sql_cliente) === TRUE) {
    // Obter o ID do cliente inserido
    $cliente_id = $conn->insert_id;

    // Inserir dados na tabela pedidos
    $sql_pedido = "INSERT INTO pedidos (cliente_id, cookies) VALUES ('$cliente_id', '$cookies')";

    if ($conn->query($sql_pedido) === TRUE) {
        echo "Pedido inserido com sucesso!";
    } else {
        echo "Erro ao inserir pedido: " . $conn->error;
    }
} else {
    echo "Erro ao inserir cliente: " . $conn->error;
}

// Fechar a conexão
$conn->close();
?>