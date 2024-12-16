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
// Verificar se os dados foram enviados
if (isset($_POST['turma_id']) && isset($_POST['presenca']))  {
    $contagem = 0;
    $alunosPresentes;
    $turma_id = $_POST['turma_id'];
    $dataAula = $_POST['dataAula'];
    $presencas = $_POST['presenca'];

    // Inserir presenças no banco
    foreach ($presencas as $aluno_id => $presente) {
        $SQL = "INSERT INTO frequencias (aluno_id, data, status) VALUES ($aluno_id, '$dataAula', 'presente')";
        mysqli_query($conexao, $SQL);
        $alunosPresentes[$contagem] = $aluno_id;
        $contagem += 1;
    }
    $alunosPresentes[$contagem] = 0; 
    $alunosPresentes[$contagem+1] = 0; 

    $sql = "SELECT id FROM alunos WHERE turma_id = $turma_id";
    $resultado = mysqli_query($conexao, $sql);
    $contagem = 0;
    
    for ($i = 0; $i < mysqli_num_rows($resultado); $i++) {
        $aluno = mysqli_fetch_assoc($resultado);
        if ($aluno['id'] != $alunosPresentes[$contagem]) {
            $SQL = "INSERT INTO frequencias (aluno_id, data, status) VALUES ({$aluno['id']}, '$dataAula', 'ausente')";
            mysqli_query($conexao, $SQL);
        } else {
            $contagem++;
        }
    }

    echo "<p>Presenças salvas com sucesso!</p>";
} else {
    echo "<p>Erro: Dados não enviados corretamente.</p>";
}

echo "<a href='registroPresencas.php'>Voltar para a página anterior</a><br>";
echo "<a href='../dashbord_prof.php'>Voltar para o menu</a>";
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
