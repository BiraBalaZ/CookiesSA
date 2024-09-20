<?php
require 'conexao.php'; // Arquivo de conexão com o banco de dados

// Query para buscar os pedidos
$query = "SELECT p.id, p.cookies, p.status, p.data_pedido, c.nome, c.cpf, c.endereco, c.email, c.telefone 
          FROM pedidos p 
          JOIN clientes c ON p.cliente_id = c.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Administração</title>
</head>
<body>
    <h1>Página de Administração - Pedidos</h1>

    <table border="1">
        <tr>
            <th>ID Pedido</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Endereço</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Cookies</th>
            <th>Status</th>
            <th>Data Pedido</th>
            <th>Ações</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['cpf']; ?></td>
                <td><?php echo $row['endereco']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['telefone']; ?></td>
                <td><?php echo $row['cookies']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['data_pedido']; ?></td>
                <td>
                    <a href="editar_pedido.php?id=<?php echo $row['id']; ?>">Editar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
