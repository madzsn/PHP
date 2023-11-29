<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exercicio";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlCreatePessoas = "
        CREATE TABLE IF NOT EXISTS Pessoas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100),
            idade INT
        );
    ";

    $sqlCreateEnderecos = "
        CREATE TABLE IF NOT EXISTS Enderecos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            rua VARCHAR(255),
            cidade VARCHAR(100),
            id_pessoa INT,
            FOREIGN KEY (id_pessoa) REFERENCES Pessoas(id)
        );
    ";

    $sqlCreateTelefones = "
        CREATE TABLE IF NOT EXISTS Telefones (
            id INT AUTO_INCREMENT PRIMARY KEY,
            numero VARCHAR(15),
            tipo VARCHAR(20),
            id_pessoa INT,
            FOREIGN KEY (id_pessoa) REFERENCES Pessoas(id)
        );
    ";

    $sqlCreatePedidos = "
        CREATE TABLE IF NOT EXISTS Pedidos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            descricao VARCHAR(255),
            valor DECIMAL(10,2),
            id_pessoa INT,
            FOREIGN KEY (id_pessoa) REFERENCES Pessoas(id)
        );
    ";

    $conn->exec($sqlCreatePessoas);
    $conn->exec($sqlCreateEnderecos);
    $conn->exec($sqlCreateTelefones);
    $conn->exec($sqlCreatePedidos);

    function inserirDadosPessoa($conn, $nome, $idade, $rua, $cidade, $numeroTelefone, $tipoTelefone, $descricaoPedido, $valorPedido)
    {
        try {
            $conn->beginTransaction();

            $stmtPessoa = $conn->prepare("INSERT INTO Pessoas (nome, idade) VALUES (:nome, :idade)");
            $stmtPessoa->bindParam(':nome', $nome);
            $stmtPessoa->bindParam(':idade', $idade);
            $stmtPessoa->execute();

            $idPessoa = $conn->lastInsertId();

            $stmtEndereco = $conn->prepare("INSERT INTO Enderecos (rua, cidade, id_pessoa) VALUES (:rua, :cidade, :idPessoa)");
            $stmtEndereco->bindParam(':rua', $rua);
            $stmtEndereco->bindParam(':cidade', $cidade);
            $stmtEndereco->bindParam(':idPessoa', $idPessoa);
            $stmtEndereco->execute();

            $stmtTelefone = $conn->prepare("INSERT INTO Telefones (numero, tipo, id_pessoa) VALUES (:numeroTelefone, :tipoTelefone, :idPessoa)");
            $stmtTelefone->bindParam(':numeroTelefone', $numeroTelefone);
            $stmtTelefone->bindParam(':tipoTelefone', $tipoTelefone);
            $stmtTelefone->bindParam(':idPessoa', $idPessoa);
            $stmtTelefone->execute();

            $stmtPedido = $conn->prepare("INSERT INTO Pedidos (descricao, valor, id_pessoa) VALUES (:descricaoPedido, :valorPedido, :idPessoa)");
            $stmtPedido->bindParam(':descricaoPedido', $descricaoPedido);
            $stmtPedido->bindParam(':valorPedido', $valorPedido);
            $stmtPedido->bindParam(':idPessoa', $idPessoa);
            $stmtPedido->execute();

            $conn->commit();

            echo "Dados inseridos com sucesso!";
        } catch (PDOException $e) {
            
            $conn->rollBack();
            echo "Erro ao inserir dados: " . $e->getMessage();
        }
    }

    inserirDadosPessoa($conn, "Maria", 28, "Rua XYZ", "Cidade ABC", "987654321", "Celular", "Pedido exemplo", 200.00);

    function getDetalhesCompras($conn, $idPessoa)
    {
        try {
            $stmt = $conn->prepare("
                SELECT P.*, E.rua, E.cidade, T.numero, T.tipo, PD.descricao, PD.valor
                FROM Pessoas P
                LEFT JOIN Enderecos E ON P.id = E.id_pessoa
                LEFT JOIN Telefones T ON P.id = T.id_pessoa
                LEFT JOIN Pedidos PD ON P.id = PD.id_pessoa
                WHERE P.id = :idPessoa
            ");

            $stmt->bindParam(':idPessoa', $idPessoa);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return null;
        }
    }

    $detalhesCompras = getDetalhesCompras($conn, 1); 

    if ($detalhesCompras) {
        foreach ($detalhesCompras as $detalhe) {
            echo "Nome: " . $detalhe['nome'] . "<br>";
            echo "Idade: " . $detalhe['idade'] . "<br>";
            echo "Rua: " . $detalhe['rua'] . "<br>";
            echo "Cidade: " . $detalhe['cidade'] . "<br>";
            echo "Número de Telefone: " . $detalhe['numero'] . "<br>";
            echo "Tipo de Telefone: " . $detalhe['tipo'] . "<br>";
            echo "Descrição do Pedido: " . $detalhe['descricao'] . "<br>";
            echo "Valor do Pedido: " . $detalhe['valor'] . "<br>";
            echo "------------------------<br>";
        }
    }

    function atualizarDetalhesPessoa($conn, $idPessoa, $novoNome, $novaIdade, $novoEndereco, $novoTelefone)
    {
        try {
            $conn->beginTransaction();

            $stmtPessoa = $conn->prepare("UPDATE Pessoas SET nome = :novoNome, idade = :novaIdade WHERE id = :idPessoa");
            $stmtPessoa->bindParam(':novoNome', $novoNome);
            $stmtPessoa->bindParam(':novaIdade', $novaIdade);
            $stmtPessoa->bindParam(':idPessoa', $idPessoa);
            $stmtPessoa->execute();

            $stmtEndereco = $conn->prepare("UPDATE Enderecos SET rua = :novoEndereco WHERE id_pessoa = :idPessoa");
            $stmtEndereco->bindParam(':novoEndereco', $novoEndereco);
            $stmtEndereco->bindParam(':idPessoa', $idPessoa);
            $stmtEndereco->execute();

            $stmtTelefone = $conn->prepare("UPDATE Telefones SET numero = :novoTelefone WHERE id_pessoa = :idPessoa");
            $stmtTelefone->bindParam(':novoTelefone', $novoTelefone);
            $stmtTelefone->bindParam(':idPessoa', $idPessoa);
            $stmtTelefone->execute();

            $conn->commit();

            echo "Detalhes da pessoa atualizados com sucesso!";
        } catch (PDOException $e) {

            $conn->rollBack();
            echo "Erro ao atualizar detalhes da pessoa: " . $e->getMessage();
        }
    }

    atualizarDetalhesPessoa($conn, 1, "Novo Nome", 30, "Nova Rua", "123456789");

    function excluirPessoaCompleta($conn, $idPessoa)
    {
        try {
            
            $conn->beginTransaction();

            $stmtTelefone = $conn->prepare("DELETE FROM Telefones WHERE id_pessoa = :idPessoa");
            $stmtTelefone->bindParam(':idPessoa', $idPessoa);
            $stmtTelefone->execute();

            $stmtPedido = $conn->prepare("DELETE FROM Pedidos WHERE id_pessoa = :idPessoa");
            $stmtPedido->bindParam(':idPessoa', $idPessoa);
            $stmtPedido->execute();

            $stmtEndereco = $conn->prepare("DELETE FROM Enderecos WHERE id_pessoa = :idPessoa");
            $stmtEndereco->bindParam(':idPessoa', $idPessoa);
            $stmtEndereco->execute();

            $stmtPessoa = $conn->prepare("DELETE FROM Pessoas WHERE id = :idPessoa");
            $stmtPessoa->bindParam(':idPessoa', $idPessoa);
            $stmtPessoa->execute();

            $conn->commit();

            echo "Pessoa e seus detalhes excluídos com sucesso!";
        } catch (PDOException $e) {
           
            $conn->rollBack();
            echo "Erro ao excluir pessoa e seus detalhes: " . $e->getMessage();
        }
    }

    excluirPessoaCompleta($conn, 2); 

} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
