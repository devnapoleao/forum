<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post" action="index.php">
        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>

        <input type="submit" name="login" value="Enviar">
        <input type="submit" name="cadastrar" value="Cadastrar">
    </form>

    <?php
    // Inclui o arquivo de configuração do banco de dados
    include('config.php');

    // Verificar se o formulário foi enviado
    if (isset($_POST['login'])) {
        // Obter as credenciais do formulário
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        // Verificar as credenciais no banco de dados
        $query = "SELECT * FROM usuarios WHERE nome = '$usuario' AND senha = '$senha'";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            // Credenciais válidas, redirecione para "forum.php"
            header("Location: forum.php");
            exit();
        } else {
            echo "Credenciais inválidas. Tente novamente.";
        }
    }

    // Redirecionar para "cadastrar.php" se o usuário pressionar "Cadastrar"
    if (isset($_POST['cadastrar'])) {
        header("Location: cadastrar.php");
        exit();
    }

    ?>

</body>
</html>
