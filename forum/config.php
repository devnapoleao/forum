<?php
$hostname = "localhost"; // Nome do servidor MySQL (geralmente "localhost")
$username = "root"; // Nome de usuário do banco de dados
$password = ""; // Senha do banco de dados
$database = "forum_database"; // Nome do banco de dados

$connection = mysqli_connect($hostname, $username, $password, $database);

if (!$connection) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}
?>
