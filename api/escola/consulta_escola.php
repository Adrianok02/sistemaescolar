<?php

function getAcaoExcluirEscola($codigoEscola){
    $sHTML = "<a id='acaoExcluir' href='http://localhost/sistemaescolar/api/escola/cadastrar_escola.php?ACAO=EXCLUIR&codigo=" . $codigoEscola . "'>Excluir</a>";

    return $sHTML;
}

function getAcaoAlterarEscola($codigoEscola){
    $sHTML = "<a id='acaoAlterar' href='http://localhost/sistemaescolar/api/escola/cadastrar_escola.php?ACAO=ALTERAR&codigo=" . $codigoEscola . "'>Alterar</a>";

    return $sHTML;
}

require_once("../core/header.php");

echo '<h3 style="text-align:center;">CONSULTA DE Escola</h3>';

// JAVASCRIPT
$htmlTabelaEscolas = "
    <script>
        function abreCadastroInclusao(){
            // alert('Abrindo cadastro de inclusao de Escola...');
            window.location.href = 'Escola.php';
        }
    </script>
";

$htmlTabelaEscolas .= "<button class='button' type='button' onclick='abreCadastroInclusao()'>Incluir - JAVASCRIPT<button>";
$htmlTabelaEscolas .= "<button class='button' type='button' onclick='abreCadastroInclusao()'><a href='escola.php' target='_blank'>Incluir - PHP</a><button>";


$htmlTabelaEscolas .= "<table border='1'>";

// HEADER DA TABLE
$htmlTabelaEscolas .= "<head>";

// TITULOS DA TABLE
$htmlTabelaEscolas .= "<tr>";
$htmlTabelaEscolas .= "  <th>Código</th>";
$htmlTabelaEscolas .= "  <th>Descrição</th>";
$htmlTabelaEscolas .= "  <th>Cidade</th>";
$htmlTabelaEscolas .= "  <th>Tipo de Encino</th>";
$htmlTabelaEscolas .= "  <th colspan='2'>Ações</th>";
$htmlTabelaEscolas .= "</tr>";

$htmlTabelaEscolas .= "</head>";

// CORPO DA TABELA
$htmlTabelaEscolas .= "<tbody>";

// LINHAS DA TABELA
// LER OS DADOS DO ARQUIVO
$arDadosEscolas = array();
// Primeiro, verifica se existe dados no arquivo json
// @ na frente do metodo, remove o warning
$dadosEscolas = @file_get_contents("escolas.json");
if($dadosEscolas){
    // transforma os dados lidos em ARRAY, que estavam em JSON
    $arDadosEscolas = json_decode($dadosEscolas, true);
}

foreach($arDadosEscolas as $aDados){
    // echo '<br>lendo dados do Escola: ' . json_encode($aDados);

    // ABRIR UMA NOVA LINHA
    $htmlTabelaEscolas .= "<tr>";
    
    // COLUNAS DENTRO DA LINHA
    // ALINHAMENTO
    // TEXTO, ALINHADO A ESQUERDA
    // VALORES, ALINHADOS A DIREITA
    $htmlTabelaEscolas .= "<td align='center'>" . $aDados["codigo"] . "</td>";
    $htmlTabelaEscolas .= "<td>" . $aDados["descricao"] . "</td>";
    $htmlTabelaEscolas .= "<td>" . $aDados["cidade"] . "</td>";
    $htmlTabelaEscolas .= "<td>" . $aDados["tipo_de_encino"] . "</td>";

    // Adiciona a ação de excluir Escola
    $codigoEscola = $aDados["codigo"];

    $htmlTabelaEscolas .= '<td>';
    $htmlTabelaEscolas .= getAcaoExcluirEscola($codigoEscola);
    $htmlTabelaEscolas .= '</td>';

    $htmlTabelaEscolas .= '<td>';
    $htmlTabelaEscolas .= getAcaoAlterarEscola($codigoEscola);
    $htmlTabelaEscolas .= '</td>';


    // FECHAR A LINHA ATUAL
    $htmlTabelaEscolas .= "</tr>";
}

$htmlTabelaEscolas .= "</tbody>";

$htmlTabelaEscolas .= "</table>";

echo $htmlTabelaEscolas;

require_once("../core/footer.php");
