<!DOCTYPE html>
<html>
<head>
    <title>Cadastro</title>
</head>
<body>
    <h1>Cadastro</h1>
    
    <form method="post" action="cadastrar.php">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>

        <input type="submit" name="cadastrar" value="Cadastrar">
    </form>

    <?php
    // Inclui o arquivo de configuração do banco de dados
    include('config.php');

    // Verificar se o formulário foi submetido
    if (isset($_POST['cadastrar'])) {
        // Obter os dados do formulário
        $nome = $_POST['nome'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        // Validar os dados do formulário
        $erros = array();

        if (empty($nome) || empty($usuario) || empty($senha)) {
            $erros[] = "Todos os campos são obrigatórios.";
        }

        // Verificar se o nome de usuário já está em uso (substitua pela lógica real)
        $query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
            $erros[] = "O nome de usuário já está em uso. Escolha outro.";
        }

        if (empty($erros)) {
            // Os dados são válidos, inserir o novo usuário no banco de dados
            $inserirQuery = "INSERT INTO usuarios (nome, usuario, senha) VALUES ('$nome', '$usuario', '$senha')";
            if (mysqli_query($connection, $inserirQuery)) {
                header("Location: index.php?cadastro=success");
                exit();
            } else {
                echo "Erro ao cadastrar o usuário. Tente novamente.";
            }
        } else {
            // Exibir mensagens de erro
            echo '<div class="erro">';
            foreach ($erros as $erro) {
                echo $erro . '<br>';
            }
            echo '</div>';
        }
    }
    ?>

</body>
</html>
