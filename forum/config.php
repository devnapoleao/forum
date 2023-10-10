<?php
$hostname = "localhost"; // Nome do servidor MySQL (geralmente "localhost")
$username = "u739537864_forum"; // Nome de usuário do banco de dados
$password = "Ajdj@#kj20218ju"; // Senha do banco de dados
$database = "u739537864_forum"; // Nome do banco de dados

$connection = mysqli_connect($hostname, $username, $password, $database);

if (!$connection) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}
?>
