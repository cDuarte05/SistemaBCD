<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
</head>

<body>
    <h3>Gerador de relatórios</h3>
    <form action="" method="POST" name="opcRelatorio">
        <select name="relatorios" id="">
            <option value=""></option>
            <option value="1">Relação de alunos por turma</option>
            <option value="2">Todos os alunos ordenando por nome</option>
            <option value="3">Relação de aniversários por mês</option>
            <option value="4">Relação de alunos com mensalidades atrasadas</option>
            <option value="5">Relação de alunos e porcentagem de presença</option>
        </select>
        <input type="submit" value="Montar">
    </form>
</body>

</html>

<?php 
//obs: As chaves usadas para associar os vetores servem como interpolação
//obs 2: Detalhe importante, colocar comentários nos codigos sql faz ele quebrar
include "../conexao.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['relatorios']) && !empty($_POST['relatorios'])) { //confere se foi definida e se é diferente de vazio
        $escolha = $_POST["relatorios"];
        switch ($escolha) {
            case "1": //relação de alunos por turma
                $SQL = "SELECT turmas.nome as Turma, alunos.nome as Alunos 
                        FROM alunos INNER JOIN turmas on alunos.turma_id = turmas.id
                        ORDER BY turma,alunos";
                $resultado = mysqli_query($conexao, $SQL);
                if(mysqli_num_rows($resultado) > 0){    
                    echo "<h3>Relação de alunos por turma: </h3>";
                    echo "<ul>";
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<li>Turma: {$row['turma']} - Aluno: {$row['aluno']}</li>";
                    }
                    echo "</ul>";
                }else{
                    echo "Não há alunos registrados";   
                }   
                break;

            case "2": //todos os alunos por nome
                //a diferença ao usar o left join é a de que todos os dados serão mostrados, mesmo os que só tenham correspondencia em uma tabela 
                $SQL = "SELECT 
                    alunos.id, 
                    alunos.nome, 
                    alunos.sexo, 
                    alunos.data_nascimento, 
                    alunos.contato, 
                    alunos.observacoes_medicas, 
                    turmas.nome AS turma,
                    arquivos.caminho as arquivos
                FROM 
                    alunos 
                LEFT JOIN 
                    turmas ON alunos.turma_id = turmas.id
                LEFT JOIN 
                arquivos ON alunos.id = arquivos.aluno_id";
                $resultado = mysqli_query($conexao, $SQL);
                // Verifica se há resultados
               if (mysqli_num_rows($resultado) > 0) {
                echo "<table border='1' cellspacing='0' cellpadding='5'>";
                echo "<tr> 
                    <th>ID</th> 
                    <th>Nome</th> 
                    <th>Sexo</th> 
                    <th>Data de Nascimento</th> 
                    <th>Contato</th> 
                    <th>Observações Médicas</th> 
                    <th>Turma</th>
                    <th>Arquivo</th>
                    </tr>";
    // Loop para exibir os dados na tabela
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['nome']}</td>";
                        echo "<td>{$row['sexo']}</td>";
                        echo "<td>{$row['data_nascimento']}</td>";
                        echo "<td>{$row['contato']}</td>";
                        echo "<td>{$row['observacoes_medicas']}</td>";
                        echo "<td>{$row['turma']}</td>";

                        // Verifica se há um arquivo associado
                        if (!empty($row['caminho'])) {
                            // Link para download
                            echo "<td><a href='{$row['caminho']}' download>Baixar Arquivo</a></td>";
                        } else {
                            echo "<td>Sem arquivo</td>";
                        }
                            
                        echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Nenhum aluno encontrado.";
            }
            break;
            case "3": //relação de aniversáriantes por mês
                $SQL = "SELECT nome, DATE_FORMAT(data_nascimento, '%d/%m') AS aniversario, MONTH(data_nascimento) AS mes 
                     FROM alunos ORDER BY MONTH(data_nascimento), DAY(data_nascimento)";
                $resultado = mysqli_query($conexao, $SQL);
                if (mysqli_num_rows($resultado) > 0) {
                    $meses = [ //atribuir os meses a um vetor
                        1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril",
                        5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto",
                        9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro"
                    ];
                    $mes_atual = 0;
                    echo "<h3>Relação de aniversariantes por mês</h3>";
                    echo "<ul>";
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        $mes_aniversario = (int)$row['mes']; //garante que a data será considerada int
                        // Verifica se o mês mudou para exibir o cabeçalho do novo mês
                        if ($mes_aniversario !== $mes_atual){
                            if ($mes_atual !== 0) {
                                echo "</ul>"; // Fecha a lista do mês anterior
                            }
                            echo "<h4>{$meses[$mes_aniversario]}</h4>";
                            echo "<ul>"; // Abre uma nova lista para o mês atual
                            $mes_atual = $mes_aniversario;
                        }
                        echo "<li>Aluno: {$row['nome']} - Aniversário: {$row['aniversario']}</li>";
                    }
                    echo "</ul>"; // Fecha a lista do último mês
                } else {
                    echo "<p>Não há aniversariantes registrados.</p>";
                }
            break;
            case "4": //relação de alunos e mensalidades atrasadas
                $SQL = "SELECT alunos.nome, mensalidades.valor, mensalidades.data_vencimento 
                        FROM alunos 
                        INNER JOIN mensalidades ON alunos.id = mensalidades.aluno_id 
                        WHERE mensalidades.status = '%pendente%' AND mensalidades.data_vencimento < CURDATE() 
                        ORDER BY mensalidades.data_vencimento";
                $resultado = mysqli_query($conexao, $SQL);
                if(mysqli_num_rows($resultado) > 0){
                    echo "<h3>Relação de alunos com mensalidades atrasadas</h3>";
                    echo "<ul>";
                    while($row = mysqli_fetch_assoc($resultado)){
                        echo "<li>Aluno: {$row['nome']} - Valor: {$row['valor']} - Vencimento: {$row['data_vencimento']}</li>";
                    }
                    echo"</ul>";
                }else echo "Não há alunos com mensalidade atrasada";   
            break;
            case "5": //relaçao de alunos e porcentagem de presença
                //--loucura pra conseguir esse negocio
                $SQL = "SELECT alunos.nome, 
                (COUNT(frequencias.id) / (SELECT COUNT(*) FROM turmas WHERE id = alunos.turma_id)) * 100 AS porcentagem 
                FROM alunos 
                LEFT JOIN frequencias ON alunos.id = frequencias.aluno_id 
                GROUP BY alunos.id 
                ORDER BY porcentagem ASC";
                $resultado = mysqli_query($conexao, $SQL);
                if(mysqli_num_rows($resultado) > 0){
                    echo "<h3>Relação de alunos e porcentagem de presença</h3>";
                    echo "<ul>";
                    while ($row = mysqli_fetch_assoc($resultado)){
                        echo "ID: " . $row['id'] . " - Nome: " . $row['nome'] . " - Porcentagem de Presença: " . $row['porcentagem'] . "%<br>";
                    }
                    echo "</ul>";
                }else echo "Não há alunos registrados";
                break;
            default:
                echo "<script>alert('opção inválida')</script>";
                break;
        }
        mysqli_close(mysql: $conexao);
    }else echo "váriavel não definada ou vazia";
}else{
    echo "ERRO AO ENVIAR FORMULARIO";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <br><a href="../dashbord_adm.html">Voltar para o menu</a>
</body>
</html>