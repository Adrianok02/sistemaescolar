<?php
function alterar_escola(){
    $codigoEscolaAlterar = $_POST["codigo"];
    $descricao = $_POST["descricao"];
    $cidade = $_POST["cidade"];
    $tidoDeEnsino = $_POST["tipo_de_ensino"];
    
    $dadosEscolas = @file_get_contents("escolas.json");
    $arDadosEscolas = json_decode($dadosEscolas, true);

    $arDadosEscolasNovo = array();
    foreach($arDadosEscolas as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoEscolaAlterar == $codigoAtual){
            $aDados["descricao"] = $descricao;
            $aDados["cidade"] = $cidade;
        }

        $arDadosEscolasNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("escolas.json", json_encode($arDadosEscolasNovo));
}

function excluir_Escola(){
    $codigoEscolaExcluir = $_GET["codigo"];

    $dadosEscolas = @file_get_contents("escolas.json");
    $arDadosEscolas = json_decode($dadosEscolas, true);

    $arDadosEscolasNovo = array();
    foreach($arDadosEscolas as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoEscolaExcluir == $codigoAtual){
            // ignora e vai para o proximo registro
            continue;
        }

        $arDadosEscolasNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("escolas.json", json_encode($arDadosEscolasNovo));
}

function incluir_escola(){
    $arDadosEscolas = array();

    // Primeiro, verifica se existe dados no arquivo json
    // @ na frente do metodo, remove o warning
    $dadosEscolas = @file_get_contents("escolas.json");
    if($dadosEscolas){
        // transforma os dados lidos em ARRAY, que estavam em JSON
        $arDadosEscolas = json_decode($dadosEscolas, true);
    }

    // Armazenar os dados do Escola atual, num array associativo

    $aDadosEscolaAtual = array();
    $aDadosEscolaAtual["codigo"] = getProximoCodigo($arDadosEscolas);
    $aDadosEscolaAtual["descricao"] = $_POST["descricao"];
    $aDadosEscolaAtual["cidade"] = $_POST["cidade"];
    $aDadosEscolaAtual["tipo_de_ensino"] = $_POST["tipo_de_ensino"];

    // Pega os dados atuais do Escola e armazena no array que foi lido
    $arDadosEscolas[] = $aDadosEscolaAtual;

    // Gravar os dados no arquivo
    file_put_contents("escolas.json", json_encode($arDadosEscolas));
}

function getProximoCodigo($arDadosEscolas){
    $ultimoCodigo = 0;
    foreach($arDadosEscolas as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoAtual > $ultimoCodigo){
            $ultimoCodigo = $codigoAtual;
        }      
    }

    return $ultimoCodigo + 1;
}

// PROCESSAMENTO DA PAGINA
// echo "<pre>" . print_r($_POST, true) . "</pre>";return true;
// echo "<pre>" . print_r($_GET, true) . "</pre>";return true;

// Verificar se esta setado o $_POST
if(isset($_POST["ACAO"])){
    $acao = $_POST["ACAO"];
    if($acao == "INCLUIR"){
        incluir_escola();

        // Redireciona para a pagina de consulta de Escola
        header('Location: consulta_escola.php');
    } else if($acao == "ALTERAR"){        
        alterar_escola();

        // Redireciona para a pagina de consulta de Escola
        header('Location: consulta_escola.php');
    }
} else if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];
    if($acao == "EXCLUIR"){
        excluir_Escola();
        
        // Redireciona para a pagina de consulta de Escola
        header('Location: consulta_escola.php');
    } else if($acao == "ALTERAR"){
        $codigoEscolaAlterar = $_GET["codigo"];

        // Redireciona para a pagina de Escola
        header('Location: escola.php?ACAO=ALTERAR&codigo=' . $codigoEscolaAlterar);
    }
} else {
    // Redireciona para a pagina de consulta de Escola
    header('Location: consulta_escola.php');
}
