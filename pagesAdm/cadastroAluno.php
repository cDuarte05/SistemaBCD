<?php 
include "conexao.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Alunos</title>
</head>
<body>
    <h1>Cadastro de Alunos</h1>
    <form method="post" action="">
        Nome: <input type="text" name="nome" required><br>
        Sexo: 
        <select name="sexo" required> 
            <option value=""></option>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
        </select><br>
        Data de Nascimento: <input type="date" name="data_nascimento" required><br>
        Contato: <input type="number" name="contato"><br>
        Turma: 
        <select name="turma_id">
            <?php //puxar as turmas que tem
            $result = $conn->query("SELECT id, nome FROM turmas");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
            }
            ?>
        </select><br>
        Declaração Médica (arquivo): <input type="text" name="declaracao_medica"><br>
        Observações Médicas: <textarea name="observacoes_medicas"></textarea><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>