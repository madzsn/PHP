<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestao_pessoas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
 }

 $sql = "CREATE TABLE pessoas (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    idade INT(3) NOT NULL,
    sexo VARCHAR(1)
 )";

if ($conn->query($sql) === TRUE) {
    echo "Tabela 'pessoas' criada com sucesso";
 } else {
    echo "Erro ao criar tabela: " . $conn->error;
 }

$sql = "CREATE TABLE telefone (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(20) NOT NULL,
    tipoTel INT(3) NOT NULL,
    id_pessoa INT
 )";

$sql = "CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    descricao VARCHAR(255),
    preco DECIMAL(10,2),
    quantidade INT
);
