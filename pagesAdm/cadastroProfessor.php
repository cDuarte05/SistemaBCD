<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Professores</title>
</head>
<body>
    <h1>Cadastro de Professores</h1>
    <form method="post" action="">
        <h3>Dados do Professor</h3>
        Nome: <input type="text" name="nome" required><br><br>
        Especialidade: <input type="text" name="especialidade" required><br><br>
        Contato: <input type="text" name="contato" required><br>
        <h3>Usuário de acesso para o professor</h3>
        Usuario: <input type="text" name="usuario" placeholder="Nome de usuário" required><br><br>
        Senha: <input type="password" name="senha" placeholder="Senha do usuário" required><br><br>
        <button type="submit">Salvar</button>
    </form>
    <a href="../dashbord_adm.php">Voltar para o menu</a>
</body>
</html>

<?php
include "../conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $especialidade = $_POST['especialidade'];
    $contato = $_POST['contato'];
    // SQL para inserir o professor
    $sql = "INSERT INTO professores (nome, especialidade, contato) 
                VALUES ('$nome', '$especialidade', '$contato')";
    // Executando a query
    if (mysqli_query($conexao, $sql)) {
        $professor_id = mysqli_insert_id($conexao);
        echo "<br>Professor cadastrado com sucesso!";
    } else {
        echo "<br>Erro ao cadastrar professor: " . mysqli_error($conexao);
    }

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $sql = "INSERT INTO usuarios (nome, senha, IDprofessor) VALUES ('$usuario', '$senha', $professor_id)";
    if (mysqli_query($conexao, $sql)) {
        $professor_id = mysqli_insert_id($conexao);
        echo "<br>Usuário cadastrado com sucesso!";
    } else {
        echo "<br>Erro ao cadastrar usuário: " . mysqli_error($conexao);
    }
    // Fechar a conexão
    mysqli_close($conexao);
}
?>
