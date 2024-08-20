<?php

require_once("header.php");

echo '<h3 style="text-align:center;">CONSULTA DE ALUNO</h3>';

// JAVASCRIPT
$htmlTabelaAlunos = "
    <script>
        function abreCadastroInclusao(){
            // alert('Abrindo cadastro de inclusao de aluno...');
            window.location.href = 'aluno.php';
        }
    </script>
";

$htmlTabelaAlunos .= "<button class='button' type='button' onclick='abreCadastroInclusao()'>Incluir - JAVASCRIPT<button>";
$htmlTabelaAlunos .= "<button class='button' type='button' onclick='abreCadastroInclusao()'><a href='aluno.php' target='_blank'>Incluir - PHP</a><button>";
$htmlTabelaAlunos .= "<table border='1'>";

// HEADER DA TABLE
$htmlTabelaAlunos .= "<head>";

// TITULOS DA TABLE
$htmlTabelaAlunos .= "<tr>";
$htmlTabelaAlunos .= "  <th>Código</th>";
$htmlTabelaAlunos .= "  <th>Nome</th>";
$htmlTabelaAlunos .= "  <th>E-mail</th>";
$htmlTabelaAlunos .= "  <th>Senha</th>";
$htmlTabelaAlunos .= "</tr>";

$htmlTabelaAlunos .= "</head>";

// CORPO DA TABELA
$htmlTabelaAlunos .= "<tbody>";

// LINHAS DA TABELA
// LER OS DADOS DO ARQUIVO
$arDadosAlunos = array();
// Primeiro, verifica se existe dados no arquivo json
// @ na frente do metodo, remove o warning
$dadosAlunos = @file_get_contents("alunos.json");
if($dadosAlunos){
    // transforma os dados lidos em ARRAY, que estavam em JSON
    $arDadosAlunos = json_decode($dadosAlunos, true);
}

foreach($arDadosAlunos as $aDados){
    // echo '<br>lendo dados do aluno: ' . json_encode($aDados);

    // ABRIR UMA NOVA LINHA
    $htmlTabelaAlunos .= "<tr>";
    
    // COLUNAS DENTRO DA LINHA
    // ALINHAMENTO
    // TEXTO, ALINHADO A ESQUERDA
    // VALORES, ALINHADOS A DIREITA
    $htmlTabelaAlunos .= "<td align='center'>" . $aDados["codigo"] . "</td>";
    $htmlTabelaAlunos .= "<td>" . $aDados["nome"] . "</td>";
    $htmlTabelaAlunos .= "<td>" . $aDados["email"] . "</td>";
    $htmlTabelaAlunos .= "<td>" . $aDados["senha"] . "</td>";

    // FECHAR A LINHA ATUAL
    $htmlTabelaAlunos .= "</tr>";
}

$htmlTabelaAlunos .= "</tbody>";

$htmlTabelaAlunos .= "</table>";

echo $htmlTabelaAlunos;

require_once("footer.php");
