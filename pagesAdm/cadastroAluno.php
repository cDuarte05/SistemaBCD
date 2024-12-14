<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $data_nascimento = $_POST['data_nascimento'];
    $contato = $_POST['contato'];
    $turma_id = $_POST['turma_id'];
    $declaracao_medica = $_POST['declaracao_medica'];
    $observacoes_medicas = $_POST['observacoes_medicas'];

    $sql = "INSERT INTO alunos (nome, sexo, data_nascimento, contato, turma_id,observacoes_medicas) 
            VALUES ('$nome', '$sexo', '$data_nascimento', '$contato', $turma_id, '$observacoes_medicas')";

    if (mysqli_query($conexao, $sql)) {
        echo "Aluno cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar aluno: " . mysqli_error($conexao);
    }
}


//inserir arquivo no banco
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $declaracao = $_FILES['declaracao_medica'];

    // Verificar se o arquivo foi enviado corretamente
    if ($declaracao['error'] === UPLOAD_ERR_OK) {
        $nomeArquivo = basename($declaracao['nome']);
        $extensao = pathinfo($declaracao['name'], PATHINFO_EXTENSION); //puxar o tipo de arquivo
        $novoNome = uniqid('declaracao_' . $aluno_id . '_') . '.' . $extensao; //mudar o nome do arquivo para colocar o id
        $caminho = 'arquivos/' . $nomeArquivo;

        // Salvar o arquivo no diretório "arquivos"
        if (move_uploaded_file($declaracao['tmp_name'], $caminho)) {
            // Inserir os dados do aluno no banco
            $sqlAluno = "INSERT INTO alunos (nome) VALUES ('$nome')";
            if (mysqli_query($conexao, $sqlAluno)) {
                // Pegar o ID do aluno recém-cadastrado
                $aluno_id = mysqli_insert_id($conexao);

                // Inserir os dados do arquivo na tabela "arquivos"
                $sqlArquivo = "INSERT INTO arquivos (aluno_id, nome_arquivo, caminho)
                        VALUES ($aluno_id, '$nomeArquivo', '$caminho')";
                if (mysqli_query($conexao, $sqlArquivo)) {
                    echo "Aluno e arquivo cadastrados com sucesso!";
                } else {
                    echo "Erro ao cadastrar arquivo: " . mysqli_error($conexao);
                }
            } else {
                echo "Erro ao cadastrar aluno: " . mysqli_error($conexao);
            }
        } else {
            echo "Erro ao salvar o arquivo.";
        }
    } else {
        echo "Erro no upload do arquivo.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cadastro de Alunos</title>
</head>

<body>
    <h1>Cadastro de Alunos</h1>
    <form method="post" action="">
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
        <select name="turma_id">
            <?php //opções do select serão puxadas do banco
            $SQL = "SELECT id, nome FROM turmas";
            $result = mysqli_query($conexao, $SQL);

            if ($result) { // Verifica se a consulta foi bem-sucedida
                if($row = mysqli_fetch_array($result)) {
                    while ($row = mysqli_fetch_assoc($result)) { //o valor da opção será meio que auto incrementado e depois terá o nome
                        echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                    }
                }else{
                    echo "<option value= 0> vazio </option>";
                }
            }else {
                    echo "Erro ao buscar turmas: " . mysqli_error($conexao);
            }
            ?>
        </select><br>
        Declaração Médica (arquivo): <input type="file" name="declaracao_medica"><br><br>
        Observações Médicas: <textarea name="observacoes_medicas"></textarea><br><br>
        <button type="submit">Salvar</button>
    </form>
</body>

</html>