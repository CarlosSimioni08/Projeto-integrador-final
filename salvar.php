<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meubanco";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$cpf_cnpj = $_POST['cpf_cnpj'];
$nome     = $_POST['nome'];
$assunto  = $_POST['assunto'];
$mensagem = $_POST['mensagem'];
$situacao = $_POST['situacao'];

$imagem = null;

if (!empty($_FILES['imagens']['name'][0])) {

    $pasta = "uploads/";
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $nome_original = $_FILES['imagens']['name'][0];
    $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);

    $novo_nome = uniqid() . "." . $extensao;
    $caminho = $pasta . $novo_nome;

    move_uploaded_file($_FILES['imagens']['tmp_name'][0], $caminho);

    $imagem = $caminho;
}

$sql = "INSERT INTO usuarios 
        (cpf_cnpj, nome, assunto, mensagem, imagem, situacao)
        VALUES 
        ('$cpf_cnpj', '$nome', '$assunto', '$mensagem', '$imagem', '$situacao')";

if ($conn->query($sql) === TRUE) {
    header("Location: /meusite/next.php");
    exit();
} else {
    die("Erro ao salvar chamado: " . $conn->error);
}

$conn->close();
?>
