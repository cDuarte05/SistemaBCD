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
    <form method="POST">
        <label for="turma">Selecione a Turma:</label>
        <select name="turma" required>
            <option value="">-- Selecione --</option>
            <?php //puxa as turmas
            while ($turma = mysqli_fetch_assoc($resultado)) {
                echo "<option value='{$turma['id']}'>{$turma['nome']}</option>";
            }
            ?>
        </select>
        <button type="submit">Registrar Presença</button><br>
        <a href="../dashbord_prof.php">Cancelar</a>
    </form>
<?php
//registrar a presença 
    $turma_id = isset($_POST['turma']) ? $_POST['turma'] : null; // Verifica se uma turma foi enviada
    if ($turma_id != null) {
        // Consulta os alunos da turma selecionada
        $SQL = "SELECT id, nome FROM alunos WHERE turma_id = $turma_id";
        $resultado = mysqli_query($conexao, $SQL);

        if (mysqli_num_rows($resultado) > 0) { ?>
            <form action="salvar_presenca.php" method="POST">
                <input type="date" name="dataAula">
                <input type="hidden" name="turma_id" value="<?= $turma_id ?>">
                <table>
                    <tr>
                        <th>Nome</th>
                        <th>Presença</th>
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
                <button type="submit">Salvar Presenças</button><br>
                <a href="../dashbord_prof.php">Cancelar</a>
            </form>
        <?php } else { ?>
            <p>Não há alunos cadastrados nesta turma.</p>
        <?php } 
    }
    ?>
</body>
</html>
<?php
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



