<?php
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "cookies_sa";

// Conectando
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>