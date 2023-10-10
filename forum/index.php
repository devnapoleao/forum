<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Login</title>
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
        input[type="text"],
        input[type="password"] {
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
    <h1>Para iniciar faça seu Login</h1>
    <div class="container">
        <form method="post" action="index.php">
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <input type="submit" name="login" value="ENTRAR">
        </form>
        <br>
        <div style="text-align: left;">
            <form method="post" action="cadastrar.php">
                <input type="submit" name="cadastrar" value="CADASTRAR">
            </form>
        </div>
        <?php
        // Inclui o arquivo de configuração do banco de dados
        include('config.php');

        // Verificar se o formulário foi enviado
        if (isset($_POST['login'])) {
            // Obter as credenciais do formulário
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];

            // Consultar o banco de dados com declaração preparada
            $query = "SELECT ID, Usuario, senha FROM Usuarios WHERE Usuario = ? AND senha = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'ss', $usuario, $senha);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $userID, $dbUsuario, $dbSenha);

            if (mysqli_stmt_fetch($stmt)) {
                // Credenciais válidas
                setcookie('usuarioID', $userID, time() + 3600, '/'); // O cookie expirará em 1 hora
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
    </div>
</body>
</html>
