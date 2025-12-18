<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meubanco";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* ====== ORDEM DE PRIORIDADE ======
Urgente -> Médio -> Fácil
*/
$sql = "
SELECT * FROM usuarios
ORDER BY 
    CASE situacao
        WHEN 'Urgente' THEN 1
        WHEN 'Médio' THEN 2
        WHEN 'Fácil' THEN 3
        ELSE 4
    END,
    data_abertura DESC
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Chamados</title>
    <link rel="stylesheet" href="stylenext.css">
</head>
<body>

<h2>Lista de Chamados</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Prioridade</th>
        <th>Nome</th>
        <th>CPF/CNPJ</th>
        <th>Assunto</th>
        <th>Mensagem</th>
        <th>Imagem</th>
        <th>Data</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['situacao'] ?></td>
            <td><?= $row['nome'] ?></td>
            <td><?= $row['cpf_cnpj'] ?></td>
            <td><?= $row['assunto'] ?></td>
            <td><?= $row['mensagem'] ?></td>
            <td>
                <?php if ($row['imagem']) { ?>
                    <img src="<?= $row['imagem'] ?>" width="80">
                <?php } else { ?>
                    —
                <?php } ?>
            </td>
            <td><?= date('d/m/Y H:i', strtotime($row['data_abertura'])) ?></td>
        </tr>
    <?php } ?>

</table>

</body>
</html>