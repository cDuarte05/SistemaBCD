<?php
    include "../conexao.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Turmas</title>
</head>
<body>
    <h1>Cadastro de Turmas</h1>
    <form method="post" action="">
        Nome: <input type="text" name="nome" required><br>
        Sexo:
        <select name="sexo" required>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
        </select><br>
        Professor:
        <select name="professor_id">
            <?php
            $SQL = "SELECT id, nome FROM professores";
            $result = mysqli_query($conexao, $SQL);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
            }
            ?>
        </select><br>
        Horário: <input type="text" name="horario"><br>
        Capacidade: <input type="number" name="capacidade" min="1" max="8"><br>
        <button type="submit">Salvar</button>
    </form>
    <a href="../dashbord_adm.php">Voltar para o menu</a><br>
</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $professor_id = $_POST['professor_id'];
    $horario = $_POST['horario'];
    $capacidade = $_POST['capacidade'];

    $sql = "INSERT INTO turmas (nome, sexo, professor_id, horario, capacidade) 
            VALUES ('$nome', '$sexo', $professor_id, '$horario', $capacidade)";

    if (mysqli_query($conexao,$sql) === TRUE) {
        echo "Turma cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar turma: " . mysqli_error($conexao);
    }
    mysqli_close($conexao);
}
?>
