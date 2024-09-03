<?php
require_once("../core/header.php");

function getComboTurma($codigoTurma = false){
    $arDadosTurmas = array();
    $dadosTurmas = @file_get_contents("../turma/turmas.json");
    if($dadosTurmas){
        // transforma os dados lidos em ARRAY, que estavam em JSON
        $arDadosTurmas = json_decode($dadosTurmas, true);
    }

    $html = '<div style="display:flex;gap:5px;flex-direction:row;">';

    $html .= '  <label for="turma">Curso:</label>';
    $html .= '  <select id="turma" name="turma">';
    $html .= '    <option value="0">Selecione</option>';

    //  preencher com php - mais options de turma
    foreach($arDadosTurmas as $aDados){
        $selected = "";
        if($codigoTurma == $aDados["codigo"]){
            $selected = " selected ";                    
        }

        $html .= '<option value="'. $aDados["codigo"] .'" ' . $selected .'>' . $aDados["nome"] . '</option>';
    }

    $html .= '</select>';
    $html .= '</div>';

    return $html;
}

function getDadosMateria($codigoMateriaAlterar){
    $codigo = "";
    $turma = "";
    $nome = "";

    $dadosMateria = @file_get_contents("materia.json");
    $arDadosMateria = json_decode($dadosMateria, true);

    $encontrouMateria = false;
    foreach($arDadosMateria as $aDados){
        $codigoAtual = $aDados["codigo"];
        if($codigoMateriaAlterar == $codigoAtual){
            $encontrouMateria = true;            
            $turma       = $aDados["turma"];
            $nome         = $aDados["nome"];

            break;
        }
    }

    return array(
        $codigoMateriaAlterar,
        $turma,
        $nome,
    );
}

// Verificar se existe acao
$codigoMateria = "";
$turma = "";
$nome = "";

$codigoMateria = false;
$acaoFormulario = "INCLUIR";
if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];
    if($acao == "ALTERAR"){
        $acaoFormulario = "ALTERAR";

        $display = "none;";
        $codigoMateria = $_GET["codigo"];
        
        list($codigoMateria,
            $turma,
            $nome,
        
            $encontrouMateria) = getDadosMateria($codigoMateria);

        if($encontrouMateria){
            $codigoMateria = $turma;

            // Limpa a mensagem de erro
            $mensagemMateriaNaoEncontrado = "";
        } else {
            // Adiciona o codigo do aluno no fim
            $mensagemMateriaNaoEncontrado = "Não foi encontrado nenhuma turma para o codigo informado!Código: ";
            $mensagemMateriaNaoEncontrado .= $codigo;
        }
    }
}

$sHTML = '<div><link rel="stylesheet" href="../css/formulario.css">';

$comboTurma = getComboTurma($codigoTurma);

// FORMULARIO DE CADASTRO DE TURMAS
$sHTML .= '<h2 style="text-align:center;">Formulário de Materia</h2>
    <h3>' . $mensagemMateriaNaoEncontrado . '</h3>
    <form action="cadastrar_materia.php" method="POST">
        <input type="hidden" id="ACAO" name="ACAO" value="' . $acaoFormulario . '">

        <label for="codigo">Código:</label>
        <input type="hidden" id="codigo" name="codigo" value="' . $codigoMateria . '" required>
        <input type="text" id="codigoTela" name="codigoTela" value="' . $codigoMateria . '" disabled>
        
        ' . $comboTurma . '
        
        <br>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required value="' . $nome . '">

   

        <input type="submit" value="Enviar">
    </form>';

// CONSULTA DE ALUNOS
$sHTML .= '</div>';

echo $sHTML;

require_once("../core/footer.php");
