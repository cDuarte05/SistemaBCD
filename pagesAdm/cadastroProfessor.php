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
        echo "Professor cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar professor: " . mysqli_error($conexao);
    }

    // Fechar a conexão
    mysqli_close($conexao);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Professores</title>
</head>
<body>
    <h1>Cadastro de Professores</h1>
    <form method="post" action="">
        Nome: <input type="text" name="nome" required><br><br>
        Especialidade: <input type="text" name="especialidade"><br><br>
        Contato: <input type="text" name="contato"><br><br>
        <button type="submit">Salvar</button>
    </form>
    <a href="../dashbord_adm.html">Voltar para o menu</a>
</body>
</html>
