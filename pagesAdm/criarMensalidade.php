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
            $idAluno = $_POST['aluno'];
            $dataVencimento = $_POST['dataVencimento'];
            $valor = $_POST['valor'];
            $sql = "INSERT INTO mensalidades (aluno_id,valor,data_vencimento,status) VALUES
            ($idAluno, $valor, '$dataVencimento', 'pendente')";
            $result = mysqli_query($conexao, $sql); 
            if ($result) {
                echo "<br>Mensalidade criada com sucesso.";
        ?>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv = "refresh" content = "3; url = adicionarMensalidade.php">
            <title>Mensalidade Criada</title>
        </head>
        <?php
    } else {
        echo "<br>Falha ao criar mensalidade.";
        ?>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv = "refresh" content = "3; url = adicionarMensalidade.php">
            <title>Falha ao Criar mensalidade</title>
        </head>
        <?php
    }
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