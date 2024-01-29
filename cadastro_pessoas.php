<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "socorrodeus";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


$sqli_pessoas = "CREATE TABLE IF NOT EXISTS pessoas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255)
)";

if ($conn->query($sqli_pessoas) === TRUE) {
    echo "Tabela 'pessoas' criada com sucesso";
} else {
    echo "Erro ao criar tabela 'pessoas': " . $conn->error;
}

$sqli_pedidos = "CREATE TABLE IF NOT EXISTS pedidos (
    id_pedido INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNSIGNED,
    produto VARCHAR(255) NOT NULL,
    quantidade INT,
    FOREIGN KEY (id_usuario) REFERENCES pessoas(id)
)";

if ($conn->query($sqli_pedidos) === TRUE) {
    echo "Tabela 'pedidos' criada com sucesso";
} else {
    echo "Erro ao criar tabela 'pedidos': " . $conn->error;
}

// Inserção de dados na tabela 'pessoas'
$sql_inserir_pessoa = "INSERT INTO pessoas (nome, email) VALUES ('João Silva', 'joao.silva@example.com')";

if ($conn->query($sql_inserir_pessoa) === TRUE) {
    echo "Dados de pessoa inseridos com sucesso";
} else {
    echo "Erro ao inserir dados de pessoa: " . $conn->error;
}

// Inserção de dados 
$sql_inserir_pedido = "INSERT INTO pedidos (id_usuario, produto, quantidade) VALUES (1, 'Produto A', 5)";

if ($conn->query($sql_inserir_pedido) === TRUE) {
    echo "Dados de pedido inseridos com sucesso";
} else {
    echo "Erro ao inserir dados de pedido: " . $conn->error;
}

// Função para obter todos os pedidos da tabela 'pedidos'
function getAllPedidos($conn) {
    $sql_pedidos = "SELECT * FROM pedidos";
    $result_pedidos = $conn->query($sql_pedidos);

    if ($result_pedidos->num_rows > 0) {
        return $result_pedidos->fetch_all(MYSQLI_ASSOC);
    } else {
        return "Nenhum resultado de pedido encontrado";
    }
}

$data_pedidos = getAllPedidos($conn);
print_r($data_pedidos);


$conn->close();
?>

