<?php
// Conexão com o banco de dados (substitua pelos seus próprios dados)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "promiscuaSafada";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
   die("Conexão falhou: " . $conn->connect_error);
}


// Query para criar a tabela
$sql = "CREATE TABLE pessoas (
   id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   nome VARCHAR(255) NOT NULL,
   idade INT(3) NOT NULL,
   sexo VARCHAR(1)
)";

// Executar a query
if ($conn->query($sql) === TRUE) {
   echo "Tabela 'pessoas' criada com sucesso";
} else {
   echo "Erro ao criar tabela: " . $conn->error;
}

// Conectar ao banco (código de conexão)

// Query para inserir dados
$sql = "INSERT INTO pessoas (nome, idade, sexo) VALUES
   ('João', 25, 'M'),
   ('Maria', 20, 'F')";

// Executar a query
if ($conn->query($sql) === TRUE) {
   echo "Dados inseridos com sucesso";
} else {
   echo "Erro ao inserir dados: " . $conn->error;
}

// Conectar ao banco (código de conexão)

// Função para retornar todos os registros da tabela
function getAllPessoas($conn) {
   $sql = "SELECT * FROM pessoas";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
   } else {
        return "Nenhum resultado encontrado";
   }
}

// Uso da função
$data = getAllPessoas($conn);
print_r($data);

// Fechar a conexão
$conn->close();
?>