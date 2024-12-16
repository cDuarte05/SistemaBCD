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
        <h2>Gerenciar Mensalidades</h2>
        <a href="adicionarMensalidade.php">Adicionar Mensalidade</a><br>
        <a href="baixaMensalidade.php">Dar Baixa Em Mensalidade</a><br>
        <a href="todasMensalidades.php">Ver Todas Mensalidades</a>
        <br><a href="../dashbord_adm.php">Voltar para o menu</a>
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