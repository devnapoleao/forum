Objetivo inicial é criar um fórum em que cada usuário pode publicar, receber comentários e pontos por interação.

O Código MySQL para o pseudocódigo é

-- Tabela de Usuários
CREATE TABLE Usuarios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(255) NOT NULL,
    Usuario VARCHAR(50) NOT NULL,
    Senha VARCHAR(255) NOT NULL
);

-- Tabela de Publicações
CREATE TABLE Publicacoes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Titulo VARCHAR(255) NOT NULL,
    Conteudo TEXT,
    AutorID INT,
    DataCriacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Pontos INT DEFAULT 0,
    FOREIGN KEY (AutorID) REFERENCES Usuarios(ID)
);

-- Tabela de Comentários
CREATE TABLE Comentarios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Conteudo TEXT,
    AutorID INT,
    PublicacaoID INT,
    DataCriacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Pontos INT DEFAULT 0,
    FOREIGN KEY (AutorID) REFERENCES Usuarios(ID),
    FOREIGN KEY (PublicacaoID) REFERENCES Publicacoes(ID)
);

-- Tabela de Votos
CREATE TABLE Votos (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Tipo ENUM('up', 'down') NOT NULL,
    UsuarioID INT,
    PublicacaoID INT,
    ComentarioID INT,
    FOREIGN KEY (UsuarioID) REFERENCES Usuarios(ID),
    FOREIGN KEY (PublicacaoID) REFERENCES Publicacoes(ID),
    FOREIGN KEY (ComentarioID) REFERENCES Comentarios(ID)
);


Já foram feitos os códigos iniciais, agora preciso enviar os votos corretamente (voto único para uma publicação ou comentário)
Após o clique na publicação vá para as respostas para ver os comentários.
