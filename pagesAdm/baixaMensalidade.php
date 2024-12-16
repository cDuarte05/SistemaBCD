<?php
    include ("../conexao.php");
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
                    <meta http-equiv = "refresh" content = "3; url = login.php">
                    <title>Login inválido</title>
                    <p>Login inválido para acessar essa página</p><br>
                </head>
            <?php
        }
        if ($usuario == 'admin' && $senha == '123456') { 
            ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <h2>Dar Baixa em Mensalidades</h2>
        <br><a href="mensalidades.php">Voltar</a>
        <br><a href="../dashbord_adm.php">Voltar para o menu</a>
        <form action="darBaixaMensalidade.php" method="POST">
            <br><select name="mensalidade">
                <?php
                    $sql = "SELECT mensalidades.id as 'ID',alunos.nome as 'Aluno',valor,data_vencimento as 'Vencimento' 
                        FROM mensalidades INNER JOIN alunos ON aluno_id = alunos.id 
                        ORDER BY data_vencimento;";
                    $result = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($result) >= 1) {
                        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                            $row = mysqli_fetch_assoc($result);
                            echo "<option value='{$row['ID']}'>{$row['Aluno']} - R$ {$row['valor']}: {$row['Vencimento']}</option>";
                        }
                    }
                ?>
            </select>
            <input type="submit" value="Dar baixa">
        </form>
    </body>
</html>

<?php
        } else {
            ?>
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv = "refresh" content = "3; url = common.php">
                    <title>Usuário inválido</title>
                    <p>Usuário inválido para acessar essa página</p><br>
                </head>
            <?php
        }
    } else {
        ?>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv = "refresh" content = "3; url = login.php">
                <title>Login inválido</title>
                <p>Login inválido para acessar essa página</p><br>
            </head>
        <?php
    }
?>