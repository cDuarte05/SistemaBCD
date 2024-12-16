<?php
    include ("conexao.php");
    session_start();
?>


<body>
    <form method="POST">
        <h2>Usuário</h2>
        <input type="text" placeholder="Nome do usuário" name="nomeUsuario">
        <h2>Senha</h2>
        <input type="password" placeholder="Senha" name="senhaUsuario"><br><br>
        <input type="submit" value="Conectar">
    </form>
    <a href="">Sair</a><br>
</body>

<?php
    if (isset($_POST['nomeUsuario']) && isset($_POST['senhaUsuario'])) {
        $sql = "SELECT * FROM usuarios WHERE nome = '{$_POST['nomeUsuario']}' AND senha = '{$_POST['senhaUsuario']}'";
        $result = mysqli_query($conexao, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['usuario'] = $row['nome'];
            $_SESSION['senha'] = $row['senha'];
            echo "Acessando: ".$row['nome'];
            ?>
                <head>
                    <meta http-equiv="refresh" content = "1; url = common.php">
                </head>
            <?php
        }
    } else {
        echo "Insira um login";
    }
?>