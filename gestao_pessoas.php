<?php
function inserirDadosPessoa($nome, $idade, $rua, $cidade, $numeroTelefone, $descricaoPedido, $valorPedido, $tipoTelefone)
{

    $conexao = mysqli_connect("localHost", "usuario", "senha", "nomedobanco");

    if (!$conexao) {
        die("conexão falhou: " . mysqli_connect_error());
    }
 
    mysqli_autocommit($conexao, false);

    $sqliPessoa = "INSERT INTO pessoas (nome, idade) VALUES ('$nome', $idade)";
    mysqli_query($conexao, $sqliPessoa);

    $idPessoa = mysqli_insert_id($conexao);

    $sqlEndereco = "INSERT INTO enderecos (rua, cidade, id_pessoa) VALUES ('$rua', '$cidade', $idPessoa)";
    mysqli_query($conexao, $sqlEndereco);

    $sqlTelefone = "INSERT INTO telefones (numero, tipo, id_pessoa) VALUES ('$numeroTelefone', '$tipoTelefone', $idPessoa)";
    mysqli_query($conexao, $sqlTelefone);

    $sqlPedido = "INSERT INTO pedidos (decricao, valor, id_pessoa) VALUES ('$descricaoPedido', $valorPedido, $idPessoa)";
    mysqli_query($conexao, $sqlPedido);

    if (mysqli_error($conexao)) {
        mysqli_rollback($conexao);
        mysqli_close($conexao);
        return "erro ao inserir dados: " . mysqli_error($conexao);
    } else {
        mysqli_commit($conexao);
        mysqli_close($conexao);
        return "dados inseridos com sucesso";
    }
}
