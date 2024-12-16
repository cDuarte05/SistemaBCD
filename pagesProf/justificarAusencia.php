<?php
include "../conexao.php";
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha'])) {
    $usuario = $_SESSION['usuario'];
    $senha = $_SESSION['senha'];
    $sql = "SELECT * FROM usuarios WHERE nome = '$usuario' AND senha  = '$senha'";
    $result = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($result) >= 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        ?>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv = "refresh" content = "3 url = ../login.php">
                <title>Usuário inválido</title>
                <p>Usuário inválido para acessar essa página</p>
            </head>
        <?php
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Faltas do Aluno</title>
        <style>
        table,td,tr,th {
            border: 1px black solid;
        }
        td,th {
            padding: 5px;
        }
    </style>
    </head>
    <body>
        <?php
            $idAluno = $_POST['aluno'];
            $sql = "SELECT alunos.nome as 'Nome',turmas.nome as 'Turma',data,status 
            FROM `frequencias` 
            INNER JOIN alunos ON aluno_id = alunos.id 
            INNER JOIN turmas ON alunos.turma_id = turmas.id 
            WHERE aluno_id = $idAluno AND status = 'ausente';";
            $result = mysqli_query($conexao, $sql);
            if (mysqli_num_rows($result) >= 1) {
                echo "<table>
                    <tr><th>Nome</th> <th>Turma</th> <th>Data</th> <th>Status</th></tr>";
                for ($i = 0; $i < mysqli_num_rows($result);$i++) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<tr><td>{$row['Nome']}</td> <td>{$row['Turma']}</td> <td>{$row['data']}</td> <td>{$row['status']}</td></tr>";
                }
                echo "</table>";
            } else {
                echo "Esse aluno não possuí faltas.";
            }
        ?>
        <form method="POST">
            <?php echo"<input type='hidden' value='$idAluno' name='aluno'>"?>
            Data 
            <select name="data" required>
                <?php
                    $sql = "SELECT data FROM frequencias WHERE aluno_id = $idAluno AND status = 'ausente'";
                    $result = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($result) >= 1) {
                        for ($i = 0; $i < mysqli_num_rows($result);$i++) {
                            $row = mysqli_fetch_assoc($result);
                            echo "<option>{$row['data']}</option>";
                        }
                    }
                ?>
            </select><br>
            Justificativa <br>
            <textarea style="width: 150px; height: 100px" name="justificativa" required></textarea><br>
            <input type="submit" value="Alterar">
        </form>
    <a href="presencaTurma.php">Voltar</a>
    </body>
</html>
<?php

if (isset($_POST['data']) && $_POST['justificativa'] != null) {
    $data = $_POST['data'];
    $justificativa = $_POST['justificativa'];
    $sql = "UPDATE frequencias SET status = 'presente', observacoes = '$justificativa' WHERE data = '$data' AND aluno_id = $idAluno;";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        echo "<br>Frequência Atualizada com Sucesso (Recarregue a Tela).";
    } else {
        echo "<br>Erro ao atualizar frequencia.";
    }
}

} else {
    ?>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv = "refresh" content = "3 url = ../login.php">
            <title>Login inválido</title>
            <p>Login inválido para acessar essa página</p>
        </head>
    <?php

}
?>