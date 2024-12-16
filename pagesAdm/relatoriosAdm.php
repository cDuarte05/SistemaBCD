<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
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
    <h3>Gerador de relatórios</h3>
    <form action="" method="POST" name="opcRelatorio">
        <select name="relatorios" >
            <option value="0"></option>
            <option value="1">Relação de alunos por turma</option>
            <option value="2">Todos os alunos ordenando por nome</option>
            <option value="3">Relação de aniversários por mês</option>
            <option value="4">Relação de alunos com mensalidades atrasadas</option>
            <option value="5">Relação de alunos e porcentagem de presença</option>
        </select>
        <input type="submit" value="Montar"><br>
        <select name="turma">
            <?php
                include "../conexao.php";
                $SQL = "SELECT id, nome FROM turmas";
                $result = mysqli_query($conexao, $SQL);
    
                if (mysqli_num_rows($result) > 0) { // Verifica se a consulta foi bem-sucedida
                    $number = mysqli_num_rows($result);
                    for ($i = 0; $i < $number; $i++) {
                        $row = mysqli_fetch_row($result);
                        echo "<option value='$row[0]'>". $row[1]. "</option>";
                    }
                } else {
                    echo "Erro ao buscar turmas: " . mysqli_error($conexao);
                }
            ?>
        </select> - Só incluencia na relação de alunos por turma (Primeira opção)
    </form>

<?php 
//obs: As chaves usadas para associar os vetores servem como interpolação
//obs 2: Detalhe importante, colocar comentários nos codigos sql faz ele quebrar
if (isset($_POST['relatorios']) && $_POST['relatorios'] != 0) {
    if (isset($_POST['relatorios']) && !empty($_POST['relatorios'])) { //confere se foi definida e se é diferente de vazio
        $escolha = $_POST["relatorios"];
        switch ($escolha) {
            case "1": //relação de alunos por turma
                $turma = $_POST['turma'];
                $SQL = "SELECT turmas.nome AS 'Turma', alunos.nome AS 'Alunos' 
                FROM alunos 
                INNER JOIN turmas ON alunos.turma_id = turmas.id
                WHERE turmas.id = $turma 
                ORDER BY Turma,Alunos";
                $resultado = mysqli_query($conexao, $SQL);
                if(mysqli_num_rows($resultado) > 0){    
                    echo "<h3>Relação de alunos por turma: </h3>";
                    echo "<table><tr><th>Turma</th><th>Aluno</th>";
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr><td>{$row['Turma']}</td><td>{$row['Alunos']}</td></tr>";
                    }
                    echo "</table>";
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
                    alunos.declaracao_medica, 
                    turmas.nome AS turma
                FROM 
                    alunos 
                LEFT JOIN 
                    turmas ON alunos.turma_id = turmas.id
                ORDER BY 
                    alunos.nome; ";
                $resultado = mysqli_query($conexao, $SQL);
                // Verifica se há resultados
               if (mysqli_num_rows($resultado) > 0) {
                echo "<h3>Todos os alunos: </h3>";
                echo "<table>";
                echo "<tr> 
                    <th>ID</th> 
                    <th>Nome</th> 
                    <th>Sexo</th> 
                    <th>Data de Nascimento</th> 
                    <th>Contato</th> 
                    <th>Observações Médicas</th> 
                    <th>Turma</th>
                    <th>Arquivo Médico</th>
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
                        if (!empty($row['declaracao_medica'])) {
                            // Link para download
                            echo "<td><a href='../arquivos/{$row['declaracao_medica']}'download>Baixar Arquivo</a></td>";
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
                $SQL = "SELECT alunos.nome, alunos.id as 'ID', mensalidades.id, mensalidades.valor, mensalidades.data_vencimento FROM mensalidades
                        INNER JOIN alunos ON aluno_id = alunos.id
                        WHERE STATUS = 'pendente' AND mensalidades.data_vencimento < CURRENT_DATE";
                $resultado = mysqli_query($conexao, $SQL);
                if(mysqli_num_rows($resultado) > 0){
                    echo "<h3>Relação de alunos com mensalidades atrasadas</h3>";
                    echo "<table>
                        <tr><th>Aluno</th> <th>ID</th> <th>Valor</th> <th>Vencimento</th></tr>";
                    while($row = mysqli_fetch_assoc($resultado)){
                        echo "<tr><td>{$row['nome']}</td> <td>{$row['ID']}</td> <td>R$ {$row['valor']}</td> <td>{$row['data_vencimento']}</td></tr>";
                    }
                    echo"</table>";
                }else echo "Não há alunos com mensalidade atrasada";   
            break;
            case "5": //relaçao de alunos e porcentagem de presença
                //--loucura pra conseguir esse negocio -> concordo, até pra fazer esse outro aqui foi loucura
                $SQL = "SELECT alunos.nome,alunos.id,
                100 - 
                ((select count(*) from frequencias where aluno_id = alunos.id and status = 'ausente') / 
                (select count(*) from frequencias where aluno_id = alunos.id) * 100) as 'Frequencia' 
                from frequencias inner join alunos on aluno_id = alunos.id 
                group by alunos.nome
                order by Frequencia";
                $resultado = mysqli_query($conexao, $SQL);
                if(mysqli_num_rows($resultado) > 0){
                    echo "<h3>Relação de alunos e porcentagem de presença</h3>";
                    echo "<table>";
                    echo "<tr><th>ID</th> <th>Nome</th> <th>Presença</th>";
                    while ($row = mysqli_fetch_assoc($resultado)){
                        echo "<tr><td>" . $row['id'] . "</td><td>" . $row['nome'] . "</td><td>" . $row['Frequencia'] . "%</td></tr>";
                    }
                    echo "</table>";
                }else echo "Não há alunos registrados";
                break;
            default:
                echo "<script>alert('opção inválida')</script>";
                break;
        }
        mysqli_close(mysql: $conexao);
    } else echo "váriavel não definada ou vazia";
} else {
    echo "Escolha uma das opções de relatórios.";
}
?>

    <br><a href="../dashbord_adm.php">Voltar para o menu</a>
</body>
</html>