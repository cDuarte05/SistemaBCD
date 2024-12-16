
<?php
    include ("conexao.php");
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
                    <meta http-equiv = "refresh" content = "3 url = login.php">
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
                    <title>Painel do Professor</title>
                </head>
                <body>
                    <h1>Painel do Professor</h1>
                    <nav>
                        <ul>
                            <li><a href="pagesProf/niverNoMes.php">Relação de aniversariantes do mês atual</a></li>
                            <li><a href="pagesProf/registroPresencas.php">Registro de presenças diárias</a></li>
                            <li><a href="pagesProf/presencaTurma.php">Lista de presença da turma</a></li>
                            <li><a href="common.php">Voltar</a></li>
                            <li><a href="logout.php">Sair</a></li>
                        </ul>
                    </nav>
                    <p>Bem-vindo ao painel do professor. Escolha uma opção no menu acima para continuar.</p>
                </body>
            </html>
        <?php
    } else {
        ?>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv = "refresh" content = "3 url = login.php">
                <title>Login inválido</title>
                <p>Login inválido para acessar essa página</p>
            </head>
        <?php
    }
?>



