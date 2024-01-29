<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "socorrodeus";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


$sqli_produto = "CREATE TABLE IF NOT EXISTS produto (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome_produto VARCHAR(255) NOT NULL,
    quantidade VARCHAR(100) NOT NULL,
    preço DECIMAL(10,2)
)";

if ($conn->query($sqli_produto) === TRUE) {
    echo "Tabela 'produto' criada com sucesso";
} else {
    echo "Erro ao criar tabela 'produto': " . $conn->error;
}

$sqli_categoria = "CREATE TABLE IF NOT EXISTS produto (
    id_produto INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    categoria VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES produto(id)
)";

if ($conn->query($sqli_categoria) === TRUE) {
    echo "Tabela 'categoria' criada com sucesso";
} else {
    echo "Erro ao criar tabela 'categoria': " . $conn->error;
}

// Inserção de dados na tabela 'pessoas'
$sql_inserir_produto = "INSERT INTO produto (nome_produto,quantidade, preço) VALUES ('batata frita', '400g', '13,40')";

if ($conn->query($sql_inserir_pessoa) === TRUE) {
    echo "Dados do produto inseridos com sucesso";
} else {
    echo "Erro ao inserir dados do produto: " . $conn->error;
}

// Inserção de dados 
$sql_inserir_categoria = "INSERT INTO categoria (id_produto, categoria) VALUES (1, 'Porçoes fritas')";

if ($conn->query($sql_inserir_produto) === TRUE) {
    echo "Dados de categoria inseridos com sucesso";
} else {
    echo "Erro ao inserir dados de categoria: " . $conn->error;
}

// Função para obter todos os pedidos da tabela 'pedidos'
function getAllPedidos($conn) {
    $sql_produto = "SELECT * FROM pedidos";
    $result_produto = $conn->query($sql_produto);

    if ($result_produto->num_rows > 0) {
        return $result_produto->fetch_all(MYSQLI_ASSOC);
    } else {
        return "Nenhum resultado de pedido encontrado";
    }
}

$data_produto = getAllPedidos($conn);
print_r($data_produto);


$conn->close();
?>

