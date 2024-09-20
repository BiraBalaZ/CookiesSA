<?php
require 'conexao.php';

function validarCPF($cpf) {
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    // Verifica se tem 11 dígitos e se todos os números são iguais (invalidando CPF sequenciais)
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Calcula os dígitos verificadores
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }

    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cookies = $_POST['cookies'];

    // Valida o CPF antes de continuar
    if (!validarCPF($cpf)) {
        echo "CPF inválido. Por favor, insira um CPF válido.";
        exit();
    }

    // Insere o cliente no banco de dados
    $stmt = $conn->prepare("INSERT INTO clientes (nome, cpf, endereco, email, telefone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nome, $cpf, $endereco, $email, $telefone);
    $stmt->execute();
    $cliente_id = $stmt->insert_id;

    // Insere o pedido no banco de dados
    $stmt2 = $conn->prepare("INSERT INTO pedidos (cliente_id, cookies) VALUES (?, ?)");
    $stmt2->bind_param("is", $cliente_id, $cookies);
    $stmt2->execute();

    // Envia e-mail para o administrador
    $to = "admin@cookies.com"; // E-mail do administrador
    $subject = "Novo Pedido Recebido";
    $message = "Novo pedido de $nome\nCookies: $cookies\n";
    mail($to, $subject, $message);

    echo "Pedido enviado com sucesso!";
}
?>