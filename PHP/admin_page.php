<?php
require 'conexao.php'; // Arquivo de conexão com o banco de dados

// Query para buscar os pedidos e as informações dos clientes
$query = "SELECT p.id, p.cookies, p.status, p.data_pedido, c.nome, c.cpf, c.telefone, c.email, c.endereco, c.numero, c.complemento, c.cep
          FROM pedidos p 
          JOIN clientes c ON p.cliente_id = c.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookies S.A. • Admin</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/admin.css">
    <link rel="stylesheet" href="../CSS/inputs_style.css">
    <link rel="stylesheet" href="../CSS/footer.css">
    <link rel="shortcut icon" href="../Assets/Icons/s.a.ico" type="image/x-icon">
    <script src="../JS/auth.js" defer></script>
</head>
<body>
    <main>
        <img id="logo" src="../Assets/Images/logo.png" alt="Logo da Cookies S.A.">
        <h1>Lista de Pedidos</h1>
        <div class="tabela">
            <table border="1">
                <tr>
                    <th>Nº Pedido</th>
                    <th>Situação</th>
                    <th>Dt. Recebimento</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>E-Mail</th>
                    <th>Endereço</th>
                    <th>Nº</th>
                    <th>Complemento</th>
                    <th>CEP</th>
                </tr>

                <!-- Loop pelos resultados da query -->
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['data_pedido'])); ?></td>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo $row['cpf']; ?></td>
                        <td><?php echo $row['telefone']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['endereco']; ?></td>
                        <td><?php echo $row['numero']; ?></td>
                        <td><?php echo $row['complemento']; ?></td>
                        <td><?php echo $row['cep']; ?></td>
                        <td>
                            <!-- Botão para editar o pedido -->
                            <a href="editar_pedido.php?id=<?php echo $row['id']; ?>">Editar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </main>
    <footer>
        <p style="color: var(--primary-dark);">Copyright &copy; <a href="../index.html">Cookies S/A</a><br>Created by <a href="https://linktr.ee/birabalaz">Erick Monteiro</a></p>
    </footer>
</body>
</html>
