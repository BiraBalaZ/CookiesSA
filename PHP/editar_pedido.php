<?php
require 'conexao.php'; // Conexão com o banco de dados

// Verificar se o ID do pedido foi passado via GET
if (isset($_GET['id'])) {
    $pedido_id = $_GET['id'];

    // Buscar os dados do pedido específico
    $stmt = $conn->prepare("SELECT p.id, p.cookies, p.status, p.data_pedido, c.nome, c.cpf, c.endereco, c.email, c.telefone 
                            FROM pedidos p 
                            JOIN clientes c ON p.cliente_id = c.id 
                            WHERE p.id = ?");
    $stmt->bind_param("i", $pedido_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pedido = $result->fetch_assoc();
    } else {
        echo "Pedido não encontrado.";
        exit;
    }
} else {
    echo "ID do pedido não informado.";
    exit;
}

// Se o formulário foi enviado, atualizar os dados no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cookies = $_POST['cookies'];
    $status = $_POST['status'];

    // Atualizar os dados no banco de dados
    $stmt = $conn->prepare("UPDATE clientes c, pedidos p 
                            SET c.nome = ?, c.cpf = ?, c.endereco = ?, c.email = ?, c.telefone = ?, p.cookies = ?, p.status = ?
                            WHERE p.id = ? AND c.id = p.cliente_id");
    $stmt->bind_param("sssssssi", $nome, $cpf, $endereco, $email, $telefone, $cookies, $status, $pedido_id);

    if ($stmt->execute()) {
        echo "Pedido atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o pedido.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido</title>
</head>
<body>
    <h1>Editar Pedido</h1>

    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $pedido['nome']; ?>" required><br>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" value="<?php echo $pedido['cpf']; ?>" required><br>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" value="<?php echo $pedido['endereco']; ?>" required><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?php echo $pedido['email']; ?>" required><br>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?php echo $pedido['telefone']; ?>" required><br>

        <label for="cookies">Pedido de Cookies:</label><br>
        <textarea id="cookies" name="cookies" rows="4" cols="50" required><?php echo $pedido['cookies']; ?></textarea><br>

        <label for="status">Status do Pedido:</label>
        <select id="status" name="status" required>
            <option value="Pendente" <?php if ($pedido['status'] == 'Pendente') echo 'selected'; ?>>Pendente</option>
            <option value="Concluído" <?php if ($pedido['status'] == 'Concluído') echo 'selected'; ?>>Concluído</option>
        </select><br><br>

        <input type="submit" value="Atualizar Pedido">
    </form>

    <a href="admin_page.php">Voltar à Página de Administração</a>
</body>
</html>
