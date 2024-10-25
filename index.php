<link rel="stylesheet" href="style.css">
<?php
// Conexão à base de dados
$conn = new mysqli('localhost', 'root', '', 'gestao_alunos');
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta SQL para selecionar os registos
$sql = "SELECT * FROM alunos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Alunos</title>
</head>
<body>
    <h1>Lista de Alunos</h1>
    <a href="adicionar.php">Adicionar Novo Aluno</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Contacto</th>
            <th>Ações</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($linha = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $linha['id'] . "</td>";
                echo "<td>" . $linha['nome'] . "</td>";
                echo "<td>" . $linha['email'] . "</td>";
                echo "<td>" . $linha['contacto'] . "</td>";
                echo "<td>
                    <a href='editar.php?id=" . $linha['id'] . "'>Editar</a> | 
                    <a href='eliminar.php?id=" . $linha['id'] . "' onclick='return confirm(\"Tem a certeza que deseja eliminar este registo?\")'>Eliminar</a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nenhum registo encontrado.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>