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
                <h2>Mensalidades</h2>
                <a href="mensalidades.php">Voltar</a>
                <br><a href="../dashbord_adm.php">Voltar para o menu</a><br><br>
                    <?php
                        $SQL = "SELECT alunos.nome, alunos.id as 'ID', mensalidades.id, mensalidades.valor, mensalidades.data_vencimento, mensalidades.status 
                        FROM mensalidades
                        INNER JOIN alunos ON aluno_id = alunos.id";
                         $resultado = mysqli_query($conexao, $SQL);
                         if(mysqli_num_rows($resultado) > 0){
                             echo "<h3>Relação de alunos com mensalidades atrasadas</h3>";
                             echo "<table>
                                 <tr><th>Aluno</th> <th>ID</th> <th>Valor</th> <th>Vencimento</th> <th>Status</th:</tr>";
                             while($row = mysqli_fetch_assoc($resultado)){
                                 echo "<tr><td>{$row['nome']}</td> <td>{$row['ID']}</td> <td>R$ {$row['valor']}</td> <td>{$row['data_vencimento']}</td> <td>{$row['status']}</td></tr>";
                             }
                             echo"</table>";
                         }else echo "Não há mensalidades registradas.";
                    ?>
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