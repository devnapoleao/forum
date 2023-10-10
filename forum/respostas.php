<?php
// Inclua o arquivo de configuração do banco de dados (substitua pelo caminho correto)
include('config.php');

// Verifique se o ID da publicação foi passado via GET
if (isset($_GET['id'])) {
    $publicacaoID = $_GET['id'];

    // Consulta SQL para obter os dados da publicação
    $query = "SELECT * FROM Publicacoes WHERE ID = $publicacaoID";
    $result = mysqli_query($connection, $query);

    // Verifique se a consulta foi bem-sucedida e se há resultados
    if ($result && mysqli_num_rows($result) > 0) {
        $publicacao = mysqli_fetch_assoc($result);

        // Obtenha o nome do autor com base no AutorID da publicação
        $autorID = $publicacao['AutorID'];
        $queryAutor = "SELECT Nome FROM Usuarios WHERE ID = $autorID";
        $resultAutor = mysqli_query($connection, $queryAutor);

        // Verifique se a consulta do autor foi bem-sucedida
        if ($resultAutor) {
            $autor = mysqli_fetch_assoc($resultAutor);
        }

        // Consulta SQL para obter os comentários da publicação
        $queryComentarios = "SELECT Comentarios.*, Usuarios.Nome AS NomeAutor FROM Comentarios JOIN Usuarios ON Comentarios.AutorID = Usuarios.ID WHERE PublicacaoID = $publicacaoID";
        $resultComentarios = mysqli_query($connection, $queryComentarios);
    }
}

// Processa o envio de comentários
if (isset($_POST['enviar_comentario'])) {
    if (isset($_POST['conteudo']) && !empty($_POST['conteudo'])) {
        $conteudo = mysqli_real_escape_string($connection, $_POST['conteudo']);

        // Obtenha o ID do autor a partir dos cookies
        if (isset($_COOKIE['usuarioID'])) {
            $autorID = $_COOKIE['usuarioID'];

            // Insira o novo comentário no banco de dados
            $inserirComentarioQuery = "INSERT INTO Comentarios (Conteudo, AutorID, PublicacaoID, DataCriacao) VALUES ('$conteudo', $autorID, $publicacaoID, NOW())";

            if (mysqli_query($connection, $inserirComentarioQuery)) {
                // Recarregue a página após o envio do comentário para exibir os comentários atualizados
                header("Location: respostas.php?id=$publicacaoID");
                exit();
            } else {
                echo "Erro ao enviar o comentário. Tente novamente.";
            }
        } else {
            echo "Erro: O ID do autor não foi encontrado nos cookies.";
        }
    } else {
        echo "O conteúdo do comentário não pode estar vazio.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Respostas</title>
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
            max-width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .publicacao {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
            background-color: #fff;
        }
        .publicacao a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }
        .publicacao a:hover {
            text-decoration: underline;
        }
        textarea {
            width: 90%;
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
                padding: 10px;
            }
            .publicacao {
                padding: 5px;
            }
            textarea {
                padding: 5px;
            }
        }
    </style>
</head>
<body>
<h1>Publicação</h1>

<div class="container">
    <?php if (isset($publicacao)): ?>
        <!-- Exibir informações da publicação -->
        <div class="publicacao">
            <h2><?php echo $publicacao['Titulo']; ?></h2>
            Autor: <?php echo isset($autor) ? $autor['Nome'] : 'Autor Desconhecido'; ?><br>
            <?php echo $publicacao['Conteudo']; ?>
        </div>

        <div>
            <h2 style="font-weight: bold; color: #3498db;">Comentários</h2>

            <?php
            if (isset($resultComentarios) && mysqli_num_rows($resultComentarios) > 0) {
                while ($comentario = mysqli_fetch_assoc($resultComentarios)) {
                    echo '<div class="publicacao" style="border: 1px solid #ddd; padding: 10px; margin: 10px 0; background-color: #fff;">';
                    echo '<span style="font-weight: bold; color: #3498db;">Autor:</span> ' . $comentario['NomeAutor'] . '<br>';
                    echo $comentario['Conteudo'];
                    echo '</div>';
                }
            } else {
                echo '<p style="font-weight: bold; color: #3498db;">Nenhum comentário encontrado.</p>';
            }
            ?>

            <h2 style="font-weight: bold; color: #3498db;">Adicionar Comentário</h2>

            <form method="post" action="respostas.php?id=<?php echo $publicacaoID; ?>">
                <label for="conteudo" style="font-weight: bold; color: #3498db;">Comentário:</label>
                <textarea id="conteudo" name="conteudo" rows="4" required style="width: 100%; padding: 10px; margin: 5px 0;"></textarea>

                <input type="submit" name="enviar_comentario" value="Enviar Comentário"
                       style="background-color: #3498db; color: #fff; padding: 10px 20px; border: none; cursor: pointer;">
            </form>
        </div>

    <?php else: ?>
        <p style="font-weight: bold; color: #3498db;">Publicação não encontrada.</p>
    <?php endif; ?>
</div>
</body>
</html>
