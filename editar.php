<link rel="stylesheet" href="style.css">
<?php
// Conexão à base de dados
$conn = new mysqli('localhost', 'root', '', 'gestao_alunos');
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obter dados atuais
    $stmt = $conn->prepare("SELECT * FROM alunos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $aluno = $resultado->fetch_assoc();
    $stmt->close();

    if (!$aluno) {
        echo "Aluno não encontrado!";
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $contacto = $_POST['contacto'];

    // Validar os dados
    if (empty($nome) || empty($email) || empty($contacto)) {
        ?>
        <div id=obg>Todos os campos são obrigatórios.</div>
        <?php
    } else {
        // Atualizar registo
        $stmt = $conn->prepare("UPDATE alunos SET nome = ?, email = ?, contacto = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nome, $email, $contacto, $id);

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
    <title>Editar Aluno</title>
</head>
<body>
    <h1>Editar Aluno</h1>
    <form method="post" action="">
        Nome: <input type="text" name="nome" value="<?php echo $aluno['nome']; ?>"><br><br>
        Email: <input type="email" name="email" value="<?php echo $aluno['email']; ?>"><br><br>
        Contacto: <input type="text" name="contacto" value="<?php echo $aluno['contacto']; ?>"><br><br>
        <input type="submit" value="Atualizar">
    </form>
    <br>
    <a href="index.php">Voltar à lista</a>
</body>
</html>

<?php
$conn->close();
?>