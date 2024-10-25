<link rel="stylesheet" href="style.css">
<?php
// Conexão à base de dados
$conn = new mysqli('localhost', 'root', '', 'gestao_alunos');
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $contacto = $_POST['contacto'];

    // Validar os dados (podes adicionar mais validações)
    if (empty($nome) || empty($email) || empty($contacto)) {
        ?>
        <div id=obg>Todos os campos são obrigatórios.</div>
        <?php
    } else {
        // Preparar e executar a inserção
        $stmt = $conn->prepare("INSERT INTO alunos (nome, email, contacto) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $contacto);

        if ($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            echo "Erro: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Aluno</title>
</head>
<body>
    <h1>Adicionar Novo Aluno</h1>
    <form method="post" action="">
        Nome: <input type="text" name="nome"><br><br>
        Email: <input type="email" name="email"><br><br>
        Contacto: <input type="text" name="contacto"><br><br>
        <input type="submit" value="Adicionar">
    </form>
    <br>
    <a href="index.php">Voltar à lista</a>
</body>
</html>

<?php
$conn->close();
?>