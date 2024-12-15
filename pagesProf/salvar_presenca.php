<?php
include "../conexao.php";

// Verificar se os dados foram enviados
if (isset($_POST['turma_id']) && isset($_POST['presenca'])) {
    $turma_id = $_POST['turma_id'];
    $presencas = $_POST['presenca'];

    // Inserir presenças no banco
    foreach ($presencas as $aluno_id => $presente) {
        $SQL = "INSERT INTO presencas (aluno_id, turma_id, data_presenca) 
                VALUES ($aluno_id, $turma_id, NOW())";
        mysqli_query($conexao, $SQL);
    }

    echo "<p>Presenças salvas com sucesso!</p>";
} else {
    echo "<p>Erro: Dados não enviados corretamente.</p>";
}

echo "<a href='registroPresencas.php'>Voltar para a página anterior</a><br>";
echo "<a href='../dashbord_prof.html'>Voltar para o menu</a>";
?>
