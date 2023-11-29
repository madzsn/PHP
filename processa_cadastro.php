<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Usuário</title>
</head>
<body>
 
<h2>Cadastro de Usuário</h2>

<form action="processa_cadastro.php" method="post">
Nome: <input type="text" name="nome"><br>
    E-mail: <input type="email" name="email"><br>
    <input type="submit" value="Enviar">
</form>
</body>
</html>
<?php
$servername= "localhost";
$username = "root";
$password = "";
$dbname = "friboi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou! " . $conn->connect_error);
}

$nome = $_POST['nome'];
$email = $_POST['email'];

$sql = "INSERT INTO usuarios (nome, email) VALUES ('$nome', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar." . $conn->error;
}
$conn->close();
?>