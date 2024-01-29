<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "socorrodeus";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


$sqli_clientes = "CREATE TABLE IF NOT EXISTS clientes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255)
)";

if ($conn->query($sqli_clientes) === TRUE) {
    echo "Tabela 'clientes' criada com sucesso";
} else {
    echo "Erro ao criar tabela 'clientes': " . $conn->error;
}
$sql_vendas = "CREATE TABLE IF NOT EXISTS vendas (
    id_cliente INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    produto_vendido VARCHAR(255) NOT NULL,
    valor DECIMAL (10,2),
    FOREIGN KEY (id_vendas) REFERENCES clientes(id)
);";

if ($conn->query($sql_vendas) === TRUE) {
    echo "Tabela 'vendas' criada com sucesso";
} else {
    echo "Erro ao criar tabela 'vendas': " . $conn->error;
}
$sql_inserir_clientes = "INSERT INTO id_clientes (nome, email) VALUES ('João Silva', 'joao.silva@example.com')";

if ($conn->query($sql_inserir_clientes) === TRUE) {
    echo "Dados de clientes inseridos com sucesso";
} else {
    echo "Erro ao inserir dados de clientes: " . $conn->error;
}

$sql_inserir_vendas = "INSERT INTO id_vendas (id_cliente, produto_vendido, valor) VALUES (1, porção de batatas, 13.00)";

if ($conn->query($sql_inserir_vendas) === TRUE) {
    echo "Dados de vendas inseridos com sucesso";
} else {
    echo "Erro ao inserir dados de vendas: " . $conn->error;
}

$data_vendas = getAllvendas($conn);
print_r($data_vendas);

$conn->close();
?>
