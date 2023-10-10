<?php
// Inclui o arquivo de configuração do banco de dados
include('config.php');

if (isset($_POST['criar_publicacao'])) {
    // Obtém os dados do formulário
    $titulo = mysqli_real_escape_string($connection, $_POST['titulo']);
    $conteudo = mysqli_real_escape_string($connection, $_POST['conteudo']);

    // Obtém o ID do autor a partir do cookie, se estiver definido
    if (isset($_COOKIE['usuarioID'])) {
        $autorID = $_COOKIE['usuarioID'];
    } else {
        // Lidar com o caso em que o ID do autor não está disponível
        echo "ID do autor não encontrado. Faça login para criar uma publicação.";
        exit();
    }

    // Insere a nova publicação no banco de dados
    $inserirQuery = "INSERT INTO Publicacoes (Titulo, Conteudo, AutorID) VALUES ('$titulo', '$conteudo', $autorID)";

    if (mysqli_query($connection, $inserirQuery)) {
        // Redireciona de volta para a página do fórum após a criação da publicação
        header("Location: forum.php");
        exit();
    } else {
        echo "Erro ao criar a publicação. Tente novamente.";
    }
} else {
    echo "Acesso não autorizado.";
}
?>
