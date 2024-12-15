<?php
include "../conexao.php";

// Consulta SQL para buscar aniversariantes
$SQL = "SELECT nome, DATE_FORMAT(data_nascimento, '%d/%m') AS aniversario, MONTH(data_nascimento) AS mes 
        FROM alunos 
        WHERE MONTH(data_nascimento) = MONTH(CURDATE()) 
        ORDER BY DAY(data_nascimento)";
$resultado = mysqli_query($conexao, $SQL);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aniversariantes</title>
</head>

<body>
    <h1>Aniversariantes do Mês</h1>
    <?php
    if (mysqli_num_rows($resultado) > 0) {
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<li>{$row['nome']} - Aniversário: {$row['aniversario']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Não há aniversariantes registrados neste mês.</p>";
    }
    mysqli_close($conexao);
    ?>
    <a href="../dashbord_prof.html">Voltar ao menu</a>
</body>

</html>