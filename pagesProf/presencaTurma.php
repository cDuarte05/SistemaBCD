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
        <title>Presença da Turma</title>
        <style>
            table,td,th {
                border: 1px solid black;
            }
            td,th {
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <?php
            $idProfessor = $row['IDprofessor'];
            if ($idProfessor != null) {
                $sql = "SELECT * FROM turmas WHERE professor_id = $idProfessor";
                $result = mysqli_query($conexao,$sql);
                $i = 0;
                if (mysqli_num_rows($result) >= 1) {
                    for ($num = mysqli_num_rows($result); $num > 0; $num--) {
                        $row = mysqli_fetch_assoc($result);
                        $sql = "SELECT alunos.id as 'ID',alunos.nome as 'Aluno',turmas.nome as 'Turma' FROM alunos INNER JOIN turmas ON turmas.id = turma_id WHERE alunos.turma_id = {$row['id']};";
                        $newResult = mysqli_query($conexao,$sql);
                        $alunos = mysqli_num_rows($newResult);
                        for ($it = 0; $it < $alunos; $it++) {
                            $newRow = mysqli_fetch_assoc($newResult);
                            $idAlunos[$i] = $newRow["ID"];
                            $i++;
                        }
                    }
                    echo "<h3>Relação de alunos e porcentagem de presença</h3>";
                    echo "<table>";
                    echo "<tr><th>ID</th> <th>Nome</th> <th>Presença</th>";
                    for ($i = 0; $i < sizeof($idAlunos); $i++) {
                        $SQL = "SELECT alunos.nome,alunos.id,
                        100 - 
                        ((select count(*) from frequencias where aluno_id = alunos.id and status = 'ausente') / 
                        (select count(*) from frequencias where aluno_id = alunos.id) * 100) as 'Frequencia' 
                        from frequencias inner join alunos on aluno_id = alunos.id
                        where alunos.id = $idAlunos[$i]
                        group by alunos.nome
                        order by Frequencia";
                        $resultado = mysqli_query($conexao, $SQL);
                        if(mysqli_num_rows($resultado) > 0){

                            while ($row = mysqli_fetch_assoc($resultado)){
                                echo "<tr><td>" . $row['id'] . "</td><td>" . $row['nome'] . "</td><td>" . $row['Frequencia'] . "%</td></tr>";
                            }
                        }else echo "Não há alunos registrados";
                    }
                    echo "</table>";
                } else {
                    echo "Nenhum aluno/turma registrado para esse professor.<br>";
                }
            } else {
                echo "Nenhum aluno/turma registrado para esse professor.<br>";
            }
        ?>
            <a href="../dashbord_prof.php">Voltar ao menu</a>
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