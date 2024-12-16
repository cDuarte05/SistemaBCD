<?php
include "../conexao.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cadastro de Alunos</title>
</head>

<body>
    <h1>Cadastro de Alunos</h1>
    <form enctype="multipart/form-data" method="post">
        Nome: <input type="text" name="nome" required><br><br>
        Sexo:
        <select name="sexo" required>
            <option value=""></option>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
        </select><br><br>
        Data de Nascimento: <input type="date" name="data_nascimento" required><br><br>
        Contato: <input type="text" name="contato"><br><br>
        Turma:
        <select required name="turma_id">
            <?php //opções do select serão puxadas do banco
            $SQL = "SELECT id, nome FROM turmas";
            $result = mysqli_query($conexao, $SQL);

            if (mysqli_num_rows($result) > 0) { // Verifica se a consulta foi bem-sucedida
                $number = mysqli_num_rows($result);
                for ($i = 0; $i < $number; $i++) {
                    $row = mysqli_fetch_row($result);
                    echo "<option value='$row[0]'>". $row[0] ." - ". $row[1]. "</option>";
                }
            } else {
                echo "Erro ao buscar turmas: " . mysqli_error($conexao);
            }
            ?>
        </select><br>
        <br>Declaração Médica (arquivo): <input type="file" name="declaracao_medica"><br><br>
        Observações Médicas: <textarea name="observacoes_medicas"></textarea><br><br>
        <button type="submit">Salvar</button>
    </form>
    <a href="../dashbord_adm.php">Voltar para o menu<br></a>
</body>
</html>

<?php
if (isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $data_nascimento = $_POST['data_nascimento'];
    $contato = $_POST['contato'];
    $turma_id = $_POST['turma_id'];
    $observacoes_medicas = $_POST['observacoes_medicas'];

    $sqlCheckTurma = "SELECT * FROM turmas WHERE id = $turma_id;";
    $result = mysqli_query($conexao, $sqlCheckTurma);
    $check = mysqli_fetch_assoc($result); 

    $sqlCheckAlunosTurma = "SELECT id, nome, turma_id FROM alunos WHERE turma_id = $turma_id;";
    $resultAlunos = mysqli_query($conexao, $sqlCheckAlunosTurma);


    if (mysqli_num_rows($resultAlunos) < $check['capacidade']) {
        if ($sexo[0] == $check['sexo']) {
            $sql = "INSERT INTO alunos (nome, sexo, data_nascimento, contato, turma_id,observacoes_medicas) 
            VALUES ('$nome', '$sexo', '$data_nascimento', '$contato', $turma_id, '$observacoes_medicas')";
            if (mysqli_query($conexao, $sql)) {
                echo "Aluno cadastrado com sucesso!";
                $aluno_id = mysqli_insert_id($conexao); // pegar o id do aluno logo após ele ser inserido
            } else {
                echo "Erro ao cadastrar aluno: " . mysqli_error($conexao);
            }
        } else {
            echo "Sexo incompatível com essa turma";
        }
    } else {
        echo "Turma Cheia"; 
    }
}

//inserir arquivo no banco
if (isset($_FILES['declaracao_medica']['name']) && $_FILES['declaracao_medica']['name'] != null && mysqli_num_rows($resultAlunos) < $check['capacidade'] && $sexo[0] == $check['sexo']) {
    $nome = $_POST['nome'];
    // Verificar se o arquivo foi enviado corretamente
    if ($_FILES['declaracao_medica']['name'] != null) {
        $nomeArquivo = $_FILES['declaracao_medica']['name'];
        $extensao = $_FILES['declaracao_medica']['type']; //puxar o tipo de arquivo
        $_FILES['declaracao_medica']['name'] = $aluno_id.$nomeArquivo; //mudar o nome do arquivo para colocar o id
        $nomeArquivo = $_FILES['declaracao_medica']['name'];
        $caminho = '../arquivos/' . $nomeArquivo;
        // Salvar o arquivo no diretório "arquivos"
        if (move_uploaded_file($_FILES['declaracao_medica']['tmp_name'], $caminho)) {
            // Inserir os dados do aluno no banco
            $sqlAluno = "UPDATE alunos SET declaracao_medica = '$nomeArquivo' WHERE id = $aluno_id";
            mysqli_query($conexao, $sqlAluno);
            } else {
                echo "Erro ao salvar o arquivo." . mysqli_error($conexao);
            }
        } else {
            echo "Erro ao identificar o arquivo.";
        }
    mysqli_close($conexao);
}
?>