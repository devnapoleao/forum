<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            background-color: #3498db;
            color: #fff;
            padding: 20px 0;
        }
        .container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }
        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .erro {
            color: #FF0000;
            text-align: center;
        }
          /* Estilos para dispositivos móveis */
          @media screen and (max-width: 600px) {
            .container {
                max-width: 100%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <h1>Cadastro</h1>
    <div class="container">
        <form method="post" action="cadastrar.php">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

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
            $query = "SELECT * FROM Usuarios WHERE usuario = '$usuario'";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                $erros[] = "O nome de usuário já está em uso. Escolha outro.";
            }

            if (empty($erros)) {
                // Os dados são válidos, inserir o novo usuário no banco de dados
                $inserirQuery = "INSERT INTO Usuarios (nome, usuario, senha) VALUES ('$nome', '$usuario', '$senha')";
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
    </div>
</body>
</html>
