<?php
require_once("../core/header.php");

function getDadosAluno($codigoAlunoAlterar){
    $nome = "";
    $email = "";

    // VAI BUSCAR OS DADOS DE ALUNO.JSON
    $dadosAlunos = @file_get_contents("alunos.json");

    // TRANSFORMAR EM ARRAY
    $arDadosAlunos = json_decode($dadosAlunos, true);

    $encontrouAluno = false;
    foreach($arDadosAlunos as $aDados){
        $codigoAtual = $aDados["codigo"];
        if($codigoAlunoAlterar == $codigoAtual){
            $encontrouAluno = true;
            $nome = $aDados["nome"];
            $email = $aDados["email"];

            // para a execução do loop
            break;
        }
    }

    return array($nome, $email, $encontrouAluno);
}

// Verificar se existe acao
$codigo = "";
$nome = "";
$email = "";
$display = "block;";

$encontrouAluno = false;
$mensagemAlunoNaoEncontrado = "Não foi encontrado nenhum aluno para o codigo informado!Código: ";

$acaoFormulario = "INCLUIR";
if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];
    if($acao == "ALTERAR"){
        $acaoFormulario = "ALTERAR";

        $display = "none;";
        $codigo = $_GET["codigo"];
        list($nome, $email, $encontrouAluno) = getDadosAluno($codigo);

        if($encontrouAluno){
            // Limpa a mensagem de erro
            $mensagemAlunoNaoEncontrado = "";
        } else {
            // Adiciona o codigo do aluno no fim
            $mensagemAlunoNaoEncontrado .= $codigoAluno;
        }
    }
}

$sHTML = '<div> <link rel="stylesheet" href="../css/formulario.css">';

// FORMULARIO DE CADASTRO DE ALUNOS
$sHTML .= '<h2 style="text-align:center;">Formulário de Aluno</h2>
    <h3>' . $mensagemAlunoNaoEncontrado . '</h3>
    <form action="cadastrar_aluno.php" method="POST">
        <input type="hidden" id="ACAO" name="ACAO" value="' . $acaoFormulario . '">

        <label for="codigo">Código:</label>
        <input type="hidden" id="codigo" name="codigo" value="' . $codigo . '" required>
        <input type="text" id="codigoTela" name="codigoTela" value="' . $codigo . '" disabled>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required value="' . $nome . '">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required value="' . $email . '">

        <div style="display:' . $display . ';">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" value="">
        </div>

        <input type="submit" value="Enviar">
    </form>';

// CONSULTA DE ALUNOS
$sHTML .= '</div>';

echo $sHTML;

require_once("../core/footer.php");
