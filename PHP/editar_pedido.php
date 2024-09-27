<?php
require 'conexao.php'; // Arquivo de conexão com o banco de dados

// Pega o ID do pedido da URL
$id_pedido = $_GET['id'];

// Query para buscar os dados do pedido específico
$query = "SELECT p.id, p.cookies, p.status, p.data_pedido, c.nome, c.cpf, c.telefone, c.email, c.endereco, c.numero, c.complemento, c.cep
          FROM pedidos p 
          JOIN clientes c ON p.cliente_id = c.id
          WHERE p.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_pedido);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se encontrou o pedido
if ($result->num_rows > 0) {
    $pedido = $result->fetch_assoc();
} else {
    echo "Pedido não encontrado!";
    exit();
}

// Decodificar os cookies em um array
$cookies = json_decode($pedido['cookies'], true);

// Definir o valor por caixa de cookies
$valor_por_caixa = 10.00;
$total_pedido = 0;

// Mapear os nomes dos sabores
$sabores = [
    'Sabor 1' => 'Fúria Vermelha',
    'Sabor 2' => 'Brocado de Cacau',
    'Sabor 3' => 'Fibroso',
    'Sabor 4' => 'Mata Fome',
    'Sabor 5' => 'Brocado de Recheio',
    'Sabor 6' => 'Mata Fome 2.0',
    'Sabor 7' => 'Sortidos'
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookies S.A. • Pedido</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/inputs_style.css"> 
    <link rel="stylesheet" href="../CSS/edit_style.css">
    <link rel="stylesheet" href="../CSS/footer.css">
    <link rel="shortcut icon" href="../Assets/Icons/s.a.ico" type="image/x-icon">
</head>
<body>
    <main>
        <img id="logo" src="../Assets/Images/logo.png" alt="Logo da Cookies S.A.">

        <div id="cabecalho">
            <h2>Pedido Número: <?php echo $pedido['id']; ?></h2>
            <h2>Situação: <?php echo $pedido['status']; ?></h2>
        </div>

        <div class="container">
            <div class="aligned">
                <label for="nome">Nome: </label>
                <input type="text" id="nome" name="nome" value="<?php echo $pedido['nome']; ?>" required>
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" value="<?php echo $pedido['cpf']; ?>" minlength="11" maxlength="15" required>
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?php echo $pedido['telefone']; ?>" minlength="9" maxlength="14" required>
            </div>

            <div class="aligned">
                <label for="endereco">End.:  </label>
                <input type="text" id="endereco" name="endereco" value="<?php echo $pedido['endereco']; ?>" required>
                <label for="numero"> Nº: </label>
                <input type="text" id="numero" name="numero" value="<?php echo $pedido['numero']; ?>" minlength="1" maxlength="5" class="number" required>
                <label for="complemento">Complemento:</label>
                <input type="text" id="complemento" name="complemento" value="<?php echo $pedido['complemento']; ?>">
            </div>

            <div class="aligned">
                <label for="email">E-mail: </label>
                <input type="email" id="email" name="email" value="<?php echo $pedido['email']; ?>" required>
                <label for="cep">CEP:</label>
                <input type="number" id="cep" name="cep" value="<?php echo $pedido['cep']; ?>" required>
            </div>

            <!-- Mais campos, caso necessário -->

            <h3>Alterar Situação do Pedido</h3>
            <div class="custom-select">
                <select name="status">
                    <option value="Pendente" <?php echo $pedido['status'] == 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                    <option value="Concluído" <?php echo $pedido['status'] == 'Concluído' ? 'selected' : ''; ?>>Concluído</option>
                    <option value="Cancelado" <?php echo $pedido['status'] == 'Cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                </select>
            </div>

            <!-- Botão para salvar alterações -->
            <div class="buttons">
                <input type="submit" value="Salvar">
            </div>

            <hr>

            <h2>Detalhes do Pedido:</h2>
            <textarea id="cookies" name="cookies" rows="4" cols="50" required><?php echo $pedido['cookies']; ?></textarea>
            <table>
                <tr>
                    <th>Sabor</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                </tr>
                <?php 
                foreach ($cookies as $sabor => $quantidade) {
                    if ($quantidade > 0) {
                        // Verificar se o sabor está no array de mapeamento e usar o nome correspondente
                        $nome_sabor = isset($sabores[$sabor]) ? $sabores[$sabor] : $sabor;
                        $valor = $quantidade * $valor_por_caixa;
                        $total_pedido += $valor;
                        echo "<tr>
                                <td>$nome_sabor</td>
                                <td>$quantidade</td>
                                <td>R$ " . number_format($valor, 2, ',', '.') . "</td>
                              </tr>";
                    }
                }
                ?>
            </table>
            <h3>TOTAL :  R$ <?php echo number_format($total_pedido, 2, ',', '.'); ?></h3>
        </div>
    </main>
    <footer>
        <p style="color: var(--primary-dark);">Copyright &copy; <a href="../index.html">Cookies S/A</a><br>Created by <a href="https://linktr.ee/birabalaz">Erick Monteiro</a></p>
    </footer>
</body>
</html>
