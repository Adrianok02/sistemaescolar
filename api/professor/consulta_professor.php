<?php

function getAcaoExcluirProfessor($codigoProfessor){
    $sHTML = "<a id='acaoExcluir' href='http://localhost/sistemaescolar/api/professor/cadastrar_professor.php?ACAO=EXCLUIR&codigo=" . $codigoProfessor . "'>Excluir</a>";

    return $sHTML;
}

function getAcaoAlterarProfessor($codigoProfessor){
    $sHTML = "<a id='acaoAlterar' href='http://localhost/sistemaescolar/api/professor/cadastrar_professor.php?ACAO=ALTERAR&codigo=" . $codigoProfessor . "'>Alterar</a>";

    return $sHTML;
}

require_once("../core/header.php");

echo '<h3 style="text-align:center;">CONSULTA DE PROFESSOR</h3>';

// JAVASCRIPT
$htmlTabelaProfessor = "
    <script>
        function abreCadastroInclusao(){
            // alert('Abrindo cadastro de inclusao de professor...');
            window.location.href = 'professor.php';
        }
    </script>
";

$htmlTabelaProfessor .= "<button class='button' type='button' onclick='abreCadastroInclusao()'>Incluir - JAVASCRIPT<button>";
$htmlTabelaProfessor .= "<button class='button' type='button' onclick='abreCadastroInclusao()'><a href='professor.php' target='_blank'>Incluir - PHP</a><button>";


$htmlTabelaProfessor .= "<table border='1'>";

// HEADER DA TABLE
$htmlTabelaProfessor .= "<head>";

// TITULOS DA TABLE
$htmlTabelaProfessor .= "<tr>";
$htmlTabelaProfessor .= "  <th>Código</th>";
$htmlTabelaProfessor .= "  <th>Nome</th>";
$htmlTabelaProfessor .= "  <th>E-mail</th>";
$htmlTabelaProfessor .= "  <th>Senha</th>";
$htmlTabelaProfessor .= "  <th colspan='2'>Ações</th>";
$htmlTabelaProfessor .= "</tr>";

$htmlTabelaProfessor .= "</head>";

// CORPO DA TABELA
$htmlTabelaProfessor .= "<tbody>";

// LINHAS DA TABELA
// LER OS DADOS DO ARQUIVO
$arDadosProfessor = array();
// Primeiro, verifica se existe dados no arquivo json
// @ na frente do metodo, remove o warning
$dadosProfessor = @file_get_contents("professor.json");
if($dadosProfessor){
    // transforma os dados lidos em ARRAY, que estavam em JSON
    $arDadosProfessor = json_decode($dadosProfessor, true);
}

foreach($arDadosProfessor as $aDados){
    // echo '<br>lendo dados do aluno: ' . json_encode($aDados);

    // ABRIR UMA NOVA LINHA
    $htmlTabelaProfessor .= "<tr>";
    
    // COLUNAS DENTRO DA LINHA
    // ALINHAMENTO
    // TEXTO, ALINHADO A ESQUERDA
    // VALORES, ALINHADOS A DIREITA
    $htmlTabelaProfessor .= "<td align='center'>" . $aDados["codigo"] . "</td>";
    $htmlTabelaProfessor .= "<td>" . $aDados["nome"] . "</td>";
    $htmlTabelaProfessor.= "<td>" . $aDados["email"] . "</td>";
    $htmlTabelaProfessor .= "<td>" . $aDados["senha"] . "</td>";

    // Adiciona a ação de excluir aluno
    $codigoProfessor = $aDados["codigo"];

    $htmlTabelaProfessor .= '<td>';
    $htmlTabelaProfessor .= getAcaoExcluirProfessor($codigoProfessor);
    $htmlTabelaProfessor .= '</td>';

    $htmlTabelaProfessor .= '<td>';
    $htmlTabelaProfessor .= getAcaoAlterarProfessor($codigoProfessor);
    $htmlTabelaProfessor .= '</td>';


    // FECHAR A LINHA ATUAL
    $htmlTabelaProfessor .= "</tr>";
}

$htmlTabelaProfessor .= "</tbody>";

$htmlTabelaProfessor .= "</table>";

echo $htmlTabelaProfessor;

require_once("../core/footer.php");
