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
        $repeat = mysqli_num_rows($resultado);
        echo "<ul>";
        for ($i = 0; $i < $repeat; $i++) {
            $row = mysqli_fetch_assoc($resultado);
            echo "<li>{$row['nome']} - Aniversário: {$row['aniversario']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Não há aniversariantes registrados neste mês.</p>";
    }
    mysqli_close($conexao);
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