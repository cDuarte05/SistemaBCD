<?php
include "../conexao.php";
$SQL = "SELECT id, nome FROM turmas";
$resultado = mysqli_query($conexao, $SQL);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Presenças</title>
</head>

<body>
<!-- Escolher a turma para registrar a presença-->
    <h1>Registro de Presenças</h1>
    <form action="salvar_presenca.php" method="POST">
        <label for="turma">Selecione a Turma:</label>
        <select name="turma" id="turma" required>
            <option value="">-- Selecione --</option>
            <?php //puxa as turmas
            while ($turma = mysqli_fetch_assoc($resultado)) {
                echo "<option value='{$turma['id']}'>{$turma['nome']}</option>";
            }
            ?>
        </select>
        <button type="submit">Registrar Presença</button>
    </form>
<?php
//registrar a presença 
    $turma_id = isset($_POST['turma']) ? $_POST['turma'] : null; // Verifica se uma turma foi enviada
    if ($turma_id) {
        // Consulta os alunos da turma selecionada
        $SQL = "SELECT id, nome FROM alunos WHERE turma_id = $turma_id";
        $resultado = mysqli_query($conexao, $SQL);

        if (mysqli_num_rows($resultado) > 0) { ?>
            <form action="salvar_presenca.php" method="POST">
                <input type="hidden" name="turma_id" value="<?= $turma_id ?>">
                <table>
                    <tr>
                        <th>Nome</th>
                        <th>Presente?</th>
                    </tr>
                    <?php while ($aluno = mysqli_fetch_assoc($resultado)) { ?>
                        <tr>
                            <td><?= $aluno['nome'] ?></td>
                            <td>
                                <input type="checkbox" name="presenca[<?= $aluno['id'] ?>]" value="1">
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <button type="submit">Salvar Presenças</button>
            </form>
        <?php } else { ?>
            <p>Não há alunos cadastrados nesta turma.</p>
        <?php } 
    }
    ?>
</body>
</html>




